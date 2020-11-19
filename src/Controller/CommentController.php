<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\User;
use App\Entity\Comment;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    private $images;
    private $length;

    public function __construct()
    {
        $this->images = [
            'user.webp',
            'businessman.webp',
            'customer.webp',
            'employee.webp',
            'manager.webp',
            'scientist.webp',
        ];

        $this->length = sizeof($this->images);
    }

    private function getRandomImage() {
        return $this->images[rand(0, ($this->length - 1))];
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
    
    /**
     * @Route("/comment", name="comment_new")
     */
    public function addComment(EntityManagerInterface $manager, Request $request)
    {
        $userService = new UserService($manager);

        $error = true;

        if ($request->getMethod() == 'POST') {

            $postData = json_decode($request->getContent(), true);

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
                    $blog = $repository->findOneBy(['slug' => $post, 'local' => 'fr']);
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

                    $commen->setMessage($message)
                        ->setImage($this->getRandomImage())
                        ->setPost($post)
                        ->setUser($user);

                    $error = false;
                }
            }
        }

        return $this->json([
            'error' => $error,
        ]);
    }
}
