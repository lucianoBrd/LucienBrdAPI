<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\User;
use App\Entity\Comment;
use App\Service\MailService;
use App\Service\UserService;
use App\Service\LocalGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    private $localGenerator;
    private $mailService;

    public function __construct(LocalGenerator $localGenerator, MailService $mailService)
    {
        $this->localGenerator = $localGenerator;
        $this->mailService = $mailService;
    }

    private function formatComment($comments) {
        $key = 'date';
        $newComments = [];
        foreach ($comments as $comment) {
            $comment[$key] = $comment[$key]->format('Y/m/d H:i:s');
            $newCommentsReply = [];
            foreach ($comment['comments'] as $c) {
                $c[$key] = $c[$key]->format('Y/m/d H:i:s');
                $newCommentsReply[] = $c;
            }
            $comment['comments'] = $newCommentsReply;
            $newComments[] = $comment;
        }
        return $newComments;
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

                if ($this->mailService->checkCaptcha($captcha) &&
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
                    $messages = [];
                    $title = $this->localGenerator->getThankComment($local);
                    $message = $this->mailService->getMessageView(
                        $title,
                        $local,
                        'comment',
                        $name,
                        [
                            $this->localGenerator->getAnswer($local)
                        ],
                        [
                            'url' => $this->getParameter('app.client.url') . '/blog/' . $blog->getSlug(), 
                            'title' => $this->localGenerator->getSeePost($local),
                        ],
                        $user->getSecret()
                    );
                    $messages[] = [
                        'to' => $mail,
                        'title' => $title,
                        'm' => $message
                    ];

                    if ($reply) {
                        $titleReply = $this->localGenerator->getTitleReplyComment($local, $name);
                        $messageReply = $this->mailService->getMessageView(
                            $titleReply,
                            $local,
                            'comment-reply',
                            $reply->getUser()->getName(),
                            $this->localGenerator->getReplyComment($local, $blog, $comment),
                            [
                                'url' => $this->getParameter('app.client.url') . '/blog/' . $blog->getSlug(), 
                                'title' => $this->localGenerator->getSeePost($local),
                            ],
                            $reply->getUser()->getSecret()
                        );
                        $messages[] = [
                            'to' => $reply->getUser()->getMail(),
                            'title' => $titleReply,
                            'm' => $messageReply
                        ];
                    }

                    $titleConfirm = 'Nouveau commentaire';
                    $messageConfirm = $this->mailService->getMessageView(
                        $titleConfirm,
                        $local,
                        'comment-reply',
                        'Lucien Burdet',
                        $this->localGenerator->getConfirmComment($local, $blog, $comment),
                        [
                            'url' => $this->getParameter('app.client.url') . '/blog/' . $blog->getSlug(), 
                            'title' => $this->localGenerator->getSeePost($local),
                        ],
                        null
                    );
                    $messages[] = [
                        'to' => 'lucien.burdet@gmail.com',
                        'title' => $titleConfirm,
                        'm' => $messageConfirm
                    ];

                    /* Send messages */
                    $error = $this->mailService->sendMessages($messages);
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
            'comments' => $this->formatComment($comments),
            'imagePath' => $this->getParameter('app.assets.images.comments'),
        ]);
    }
}
