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
     * @Route("/contact/{name}/{email}/{message}", name="contact")
     */
    public function index(MailerInterface $mailer, string $name, string $email, string $message)
    {
        $error = false;

        /* Remove all illegal characters from email */
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ($name && !empty($name) && $email && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && $message && !empty($message)) {
            $html = '<h2>' . $name . '</h2>';
            $html .= '<a href="mailto:' . $email . '">' . $email . '</a>';
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
                ->to('contact@lucien-brd.com')
                ->subject('Message de ' . $name)
                ->html($html);

            $emailConfirm = (new Email())
                ->from(Address::fromString('Lucien Burdet <no-reply@lucien-brd.com>'))
                ->to(new Address($email))
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
