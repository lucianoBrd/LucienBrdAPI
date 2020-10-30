<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/{captcha}/{name}/{mail}/{message}", name="contact")
     */
    public function index(MailerInterface $mailer, string $captcha, string $name, string $mail, string $message)
    {
        $error = false;

        /* Remove all illegal characters from mail */
        $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);

        /* Check captcha */
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $_ENV['PRIVATE_KEY'] . '&response=' . $captcha);
        $resp = json_decode($verifyResponse);

        if (!($resp != null && $resp->success)) {
            $error = true;
        }

        if (!$error &&
            $name && !empty($name) &&
            $mail && !empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL) &&
            $message && !empty($message)
        ) {
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
            } catch (TransportExceptionInterface $e) {
                $error = true;
            }
        } else {
            $error = true;
        }

        return $this->json([
            'error' => $error,
        ]);
    }
}
