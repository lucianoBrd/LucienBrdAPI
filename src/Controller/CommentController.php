<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\User;
use App\Entity\Comment;
use App\Service\UserService;
use App\Service\LocalGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }
    
    /**
     * @Route("/comment/reply/{local}", name="comment_reply_new")
     * @Route("/comment/new/{local}", name="comment_new")
     */
    public function addComment($local, EntityManagerInterface $manager, \Swift_Mailer $mailer, Request $request)
    {
        $userService = new UserService($manager);

        $error = true;

        if ($request->getMethod() == 'POST' && !$this->localGenerator->checkLocal($local)) {

            $postData = json_decode($request->getContent(), true);

            /* Check isset reply */
            $reply = null;
            if (isset($postData['reply'])) {
                $reply = htmlspecialchars($postData['reply']);
                if ($reply && !empty($reply)) {
                    /* Check reply exist */
                    $repository = $manager->getRepository(Comment::class);
                    $reply = $repository->findOneBy(['id' => $reply]);

                } else {
                    $reply = null;
                    
                }
            }

            if (isset($postData['captcha']) && isset($postData['name']) && isset($postData['mail']) && isset($postData['message']) && isset($postData['post'])) {

                $captcha = htmlspecialchars($postData['captcha']);
                $name = htmlspecialchars($postData['name']);
                $mail = htmlspecialchars($postData['mail']);
                $message = htmlspecialchars($postData['message']);
                $post = htmlspecialchars($postData['post']);

                /* Remove all illegal characters from mail */
                $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

                /* Check post exist */
                $blog = null;
                if ($post && !empty($post)) {
                    $repository = $manager->getRepository(Blog::class);
                    $blog = $repository->findOneBy(['slug' => $post, 'local' => $local]);
                }

                /* Check captcha */
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $_ENV['PRIVATE_KEY'] . '&response=' . $captcha);
                $resp = json_decode($verifyResponse);

                if ($resp != null && $resp->success &&
                    $name && !empty($name) &&
                    $mail && !empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL) &&
                    $message && !empty($message) &&
                    $blog
                ) {
                    /* Save User + Message */
                    $user = new User();

                    $user->setName($name)
                        ->setMail($mail);

                    $user = $userService->addUser($user);

                    $comment = new Comment();

                    $comment->setMessage($message)
                        ->setPost($post)
                        ->setUser($user)
                        ->setReply(false);

                    $manager->persist($comment);

                    /* If isset reply add comment to it */
                    if ($reply) {
                        $comment->setReply(true);
                        $reply->addComment($comment);

                        $manager->persist($comment);
                        $manager->persist($reply);
                    }

                    $manager->flush();

                    /* Create messages */
                    $title = $this->localGenerator->getThankComment($local);
                    $message = (new \Swift_Message($title))
                        ->setFrom('lucien.burdet@gmail.com')
                        ->setTo($mail)
                        ->setBody(
                            $this->renderView(
                                'emails/base.html.twig',
                                [
                                    'local' => $local,
                                    'title' => $title,
                                    'clientPath' => $this->getParameter('app.client.url'),
                                    'emailPath' => $this->getParameter('app.assets.email'),
                                    'banner' => 'comment',
                                    'h1' => [
                                        'hello' => $this->localGenerator->getHello($local),
                                        'name' => $name,
                                    ],
                                    'h3' => $title,
                                    'paragraphs' => [$this->localGenerator->getAnswer($local)],
                                    'button' => [
                                        'url' => $this->getParameter('app.client.url') . '/blog/' . $blog->getSlug(), 
                                        'title' => $this->localGenerator->getSeePost($local),
                                    ],
                                    'question' => $this->localGenerator->getQuestion($local),
                                    'contact' => $this->localGenerator->getContact($local),
                                ]
                            ),
                            'text/html'
                    );
                    if ($reply) {
                        $titleReply = $this->localGenerator->getTitleReplyComment($local, $name);
                        $messageReply = (new \Swift_Message($titleReply))
                            ->setFrom('lucien.burdet@gmail.com')
                            ->setTo($reply->getUser()->getMail())
                            ->setBody(
                                $this->renderView(
                                    'emails/base.html.twig',
                                    [
                                        'local' => $local,
                                        'title' => $titleReply,
                                        'clientPath' => $this->getParameter('app.client.url'),
                                        'emailPath' => $this->getParameter('app.assets.email'),
                                        'banner' => 'comment-reply',
                                        'h1' => [
                                            'hello' => $this->localGenerator->getHello($local),
                                            'name' => $reply->getUser()->getName(),
                                        ],
                                        'h3' => $titleReply,
                                        'paragraphs' => $this->localGenerator->getReplyComment($local, $blog, $comment),
                                        'button' => [
                                            'url' => $this->getParameter('app.client.url') . '/blog/' . $blog->getSlug(), 
                                            'title' => $this->localGenerator->getSeePost($local),
                                        ],
                                        'question' => $this->localGenerator->getQuestion($local),
                                        'contact' => $this->localGenerator->getContact($local),
                                    ]
                                ),
                                'text/html'
                        );
                    }
                    $titleConfirm = 'Nouveau commentaire';
                    $messageConfirm = (new \Swift_Message($titleConfirm))
                        ->setFrom('lucien.burdet@gmail.com')
                        ->setTo('lucien.burdet@gmail.com')
                        ->setBody(
                            $this->renderView(
                                'emails/base.html.twig',
                                [
                                    'local' => $local,
                                    'title' => $titleConfirm,
                                    'clientPath' => $this->getParameter('app.client.url'),
                                    'emailPath' => $this->getParameter('app.assets.email'),
                                    'banner' => 'comment-reply',
                                    'h1' => [
                                        'hello' => $this->localGenerator->getHello($local),
                                        'name' => 'Lucien Burdet',
                                    ],
                                    'h3' => $titleConfirm,
                                    'paragraphs' => $this->localGenerator->getConfirmComment($local, $blog, $comment),
                                    'button' => [
                                        'url' => $this->getParameter('app.client.url') . '/blog/' . $blog->getSlug(), 
                                        'title' => $this->localGenerator->getSeePost($local),
                                    ],
                                    'question' => $this->localGenerator->getQuestion($local),
                                    'contact' => $this->localGenerator->getContact($local),
                                ]
                            ),
                            'text/html'
                    );

                    try {
                        $mailer->send($message);
                        if ($reply && $reply->getUser()->getId() != $comment->getUser()->getId()) {
                            $mailer->send($messageReply);
                        }
                        $mailer->send($messageConfirm);
                        $error = false;
                    } catch (\Swift_TransportException $Ste) {
                        $error = true;
                    }
                }
            }
        }

        return $this->json([
            'error' => $error,
        ]);
    }

    /**
     * @Route("/comment/{post}", name="comment_post")
     */
    public function getByPost($post)
    {
        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findByPostArray($post);
        
        return $this->json([
            'comments' => $comments,
            'imagePath' => $this->getParameter('app.assets.images.comments'),
        ]);
    }
}
