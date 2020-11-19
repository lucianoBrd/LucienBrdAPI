<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Service\UserService;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(EntityManagerInterface $manager, MailerInterface $mailer, Request $request)
    {
        $userService = new UserService($manager);

        $error = true;

        if ($request->getMethod() == 'POST') {
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

                    /* Create message */
                    $html = '<h2>' . $name . '</h2>';
                    $html .= '<a href="mailto:' . $mail . '">' . $mail . '</a>';
                    $html .= '<p>' . $message . '</p>';

                    /* Get signature */
                    $signature = '';
                    $f = fopen('../public/assets/email/mail.html', 'r');
                    while (!feof($f)) {
                        $result = fgets($f);
                        $signature .= $result;
                    }
                    fclose($f);

                    $html .= $signature;

                    $confirm = '<h1>Bonjour ' . $name . '</h1>';
                    $confirm .= '<p>Merci pour votre message, je vous répondrais dans les meilleurs délais.</p>';
                    $confirm .= '<p>---------------------------------------</p>';

                    $email = (new Email())
                        ->from(Address::fromString('Lucien Burdet <no-reply@lucien-brd.com>'))
                        ->to('lucien.burdet@gmail.com')
                        ->subject('Message de ' . $name)
                        ->html($html);

                    $emailConfirm = (new Email())
                        ->from(Address::fromString('Lucien Burdet <no-reply@lucien-brd.com>'))
                        ->to(new Address($mail))
                        ->subject('Confirmation de récéption')
                        ->html($confirm . $html);
                    try {
                        $mailer->send($email);
                        $mailer->send($emailConfirm);
                        $error = false;
                    } catch (TransportExceptionInterface $e) {
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
