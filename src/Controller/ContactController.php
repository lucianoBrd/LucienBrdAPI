<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
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

        $email = (new Email())
            ->from('no-reply@lucien-brd.com')
            ->to('contact@lucien-brd.com')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Message de ' . $name)
            ->html('<h1>' . $name . '</h1>')
            ->html('<a href="mailto:' . $email . '">' . $email . '</a>')
            ->html('<p>' . $message . '</p>');

        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $error = true;
        }

        return $this->json([
            'error' => $error,
        ]);
    }
}
