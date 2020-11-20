<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
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

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
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

                /* Check captcha */
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $_ENV['PRIVATE_KEY'] . '&response=' . $captcha);
                $resp = json_decode($verifyResponse);

                if ($resp != null && $resp->success &&
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

                    $userService->addUser($user);

                    /* Create messages */
                    $title = 'Message de ' . $name;
                    $message = (new \Swift_Message($title))
                        ->setFrom('lucien.burdet@gmail.com')
                        ->setTo('lucien.burdet@gmail.com')
                        ->setBody(
                            $this->renderView(
                                'emails/base.html.twig',
                                [
                                    'local' => $local,
                                    'title' => $title,
                                    'clientPath' => $this->getParameter('app.client.url'),
                                    'emailPath' => $this->getParameter('app.assets.email'),
                                    'banner' => 'contact',
                                    'h1' => [
                                        'hello' => $this->localGenerator->getHello($local),
                                        'name' => 'Lucien Burdet',
                                    ],
                                    'h3' => $title,
                                    'paragraphs' => [
                                        $name,
                                        $mail,
                                        $m->getMessage(),
                                    ],
                                    'button' => null,
                                    'question' => $this->localGenerator->getQuestion($local),
                                    'contact' => $this->localGenerator->getContact($local),
                                ]
                            ),
                            'text/html'
                    );
                    $titleConfirm = $this->localGenerator->getRecusal($local);
                    $messageConfirm = (new \Swift_Message($titleConfirm))
                        ->setFrom('lucien.burdet@gmail.com')
                        ->setTo($mail)
                        ->setBody(
                            $this->renderView(
                                'emails/base.html.twig',
                                [
                                    'local' => $local,
                                    'title' => $titleConfirm,
                                    'clientPath' => $this->getParameter('app.client.url'),
                                    'emailPath' => $this->getParameter('app.assets.email'),
                                    'banner' => 'contact',
                                    'h1' => [
                                        'hello' => $this->localGenerator->getHello($local),
                                        'name' => $name,
                                    ],
                                    'h3' => $titleConfirm,
                                    'paragraphs' => $this->localGenerator->getConfirm($local, $m->getMessage()),
                                    'button' => null,
                                    'question' => $this->localGenerator->getQuestion($local),
                                    'contact' => $this->localGenerator->getContact($local),
                                ]
                            ),
                            'text/html'
                    );

                    try {
                        $mailer->send($message);
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
}
