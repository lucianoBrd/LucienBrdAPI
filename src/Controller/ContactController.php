<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Service\MailService;
use App\Service\UserService;
use App\Service\LocalGenerator;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    private $localGenerator;
    private $mailService;

    public function __construct(LocalGenerator $localGenerator, MailService $mailService)
    {
        $this->localGenerator = $localGenerator;
        $this->mailService = $mailService;
    }
    
    /**
     * @Route("/contact/{local}", name="contact")
     */
    public function index($local, EntityManagerInterface $manager, \Swift_Mailer $mailer, Request $request)
    {
        $userService = new UserService($manager);

        $error = true;

        if ($request->getMethod() == 'POST' && !$this->localGenerator->checkLocal($local)) {

            $postData = json_decode($request->getContent(), true);

            if (isset($postData['captcha']) && isset($postData['name']) && isset($postData['mail']) && isset($postData['message'])) {

                $captcha = htmlspecialchars($postData['captcha']);
                $name = htmlspecialchars($postData['name']);
                $mail = htmlspecialchars($postData['mail']);
                $message = htmlspecialchars($postData['message']);

                /* Remove all illegal characters from mail */
                $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

                if ($this->mailService->checkCaptcha($captcha) &&
                    $name && !empty($name) &&
                    $mail && !empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL) &&
                    $message && !empty($message)
                ) {
                    /* Save User + Message */
                    $user = new User();
                    $m = new Message();

                    $m->setMessage($message);

                    $user->setName($name)
                        ->setMail($mail)
                        ->addMessage($m);

                    $user = $userService->addUser($user);

                    /* Create messages */
                    $title = 'Message de ' . $name;
                    $message = $this->mailService->getMessageView(
                        $title,
                        $local,
                        'contact',
                        'Lucien Burdet',
                        [
                            $name,
                            $mail,
                            $m->getMessage(),
                        ],
                        null,
                        null
                    );
                    $titleConfirm = $this->localGenerator->getRecusal($local);
                    $messageConfirm = $this->mailService->getMessageView(
                        $titleConfirm,
                        $local,
                        'contact',
                        $name,
                        $this->localGenerator->getConfirm($local, $m->getMessage()),
                        null,
                        $user->getSecret()
                    );

                    /* Send messages */
                    $error = $this->mailService->sendMessages(
                        [
                            [
                                'to' => 'contact@lucien-brd.com',
                                'title' => $title,
                                'm' => $message
                            ],
                            [
                                'to' => $mail,
                                'title' => $titleConfirm,
                                'm' => $messageConfirm
                            ]
                        ]
                    );
                }
            }
        }

        return $this->json([
            'error' => $error,
        ]);
    }
}
