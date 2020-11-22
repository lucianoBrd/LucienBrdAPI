<?php

namespace App\Service;

use App\Service\LocalGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailService extends AbstractController
{
    private $localGenerator;
    private $mailer;

    public function __construct(
        LocalGenerator $localGenerator, 
        \Swift_Mailer $mailer
    )
    {
        $this->localGenerator = $localGenerator;
        $this->mailer = $mailer;
    }

    public function checkCaptcha($captcha) {
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $_ENV['PRIVATE_KEY'] . '&response=' . $captcha);
        $resp = json_decode($verifyResponse);
        return $resp != null && $resp->success;
    }

    public function sendMessages($messages) {
        $error = false;
        foreach ($messages as $message) {
            $error = $error || $this->sendMessage(
                $message['to'],
                $message['title'],
                $message['m']
            );
        }
        return $error;
    }

    public function sendMessage(
        $to,
        $title,
        $m
    ) {
        $error = true;

        $message = (new \Swift_Message($title))
            ->setFrom('lucien.burdet@gmail.com')
            ->setTo($to)
            ->setBody(
                $m,
                'text/html'
        );
        try {
            $this->mailer->send($message);
            $error = false;
        } catch (\Swift_TransportException $Ste) {
            $error = true;
        }
        return $error;
    }

    public function getMessage(
        $title,
        $local,
        $banner,
        $name,
        $paragraphs,
        $button,
        $secret
    )
    {
        return $this->render(
            'emails/base.html.twig',
            [
                'local' => $local,
                'title' => $title,
                'clientPath' => $this->getParameter('app.client.url'),
                'emailPath' => $this->getParameter('app.assets.email'),
                'banner' => $banner,
                'h1' => [
                    'hello' => $this->localGenerator->getHello($local),
                    'name' => $name,
                ],
                'h3' => $title,
                'paragraphs' => $paragraphs,
                'button' => $button,
                'question' => $this->localGenerator->getQuestion($local),
                'contact' => $this->localGenerator->getContact($local),
                'unsubscribe' => $this->localGenerator->getUnsubscribe($local),
                'unsubscribePath' => $secret ? $this->getParameter('app.url') . '/unsubscribe/' . $local . '/' . $secret : null,
            ]
        );
    }

    public function getMessageView(
        $title,
        $local,
        $banner,
        $name,
        $paragraphs,
        $button,
        $secret
    )
    {
        return $this->renderView(
            'emails/base.html.twig',
            [
                'local' => $local,
                'title' => $title,
                'clientPath' => $this->getParameter('app.client.url'),
                'emailPath' => $this->getParameter('app.assets.email'),
                'banner' => $banner,
                'h1' => [
                    'hello' => $this->localGenerator->getHello($local),
                    'name' => $name,
                ],
                'h3' => $title,
                'paragraphs' => $paragraphs,
                'button' => $button,
                'question' => $this->localGenerator->getQuestion($local),
                'contact' => $this->localGenerator->getContact($local),
                'unsubscribe' => $this->localGenerator->getUnsubscribe($local),
                'unsubscribePath' => $secret ? $this->getParameter('app.url') . '/unsubscribe/' . $local . '/' . $secret : null,
            ]
        );
    }
}
