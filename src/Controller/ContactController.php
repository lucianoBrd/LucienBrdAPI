<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/{name}/{email}/{message}", name="contact")
     */
    public function index(MailerInterface $mailer, string $name, string $email, string $message)
    {
        $error = false;

        if ($name && !empty($name) && $email && !empty($email) && $message && !empty($message)) {
            $html = '<h1>' . $name . '</h1>';
            $html .= '<a href="mailto:' . $email . '">' . $email . '</a>';
            $html .= '<p>' . $message . '</p>';
            $html .= fopen('../public/assets/email/mail.html', 'r');

            $email = (new Email())
                ->from(Address::fromString('Lucien Burdet <no-reply@lucien-brd.com>'))
                ->to('contact@lucien-brd.com')
                ->subject('Message de ' . $name)
                ->html($html);

            try {
                $mailer->send($email);
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
