<?php

namespace App\Controller;

use App\Service\LocalGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function testMail(\Swift_Mailer $mailer)
    {
        $local = 'en';
        $title = 'Test';
        $m = $this->render('emails/base.html.twig', [
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
                'Ceci est un paragraphe',
                'Deuxième paragraphe',
            ],
            'button' => [
                'url' => '#', 
                'title' => $this->localGenerator->getDownload($local),
            ],
            'question' => $this->localGenerator->getQuestion($local),
            'contact' => $this->localGenerator->getContact($local),
        ]);

        $message = (new \Swift_Message($title))
            ->setFrom('lucien.burdet@gmail.com')
            ->setTo('lucien.burdet@gmail.com')
            ->setBody($m, 'text/html');

        try {
            $mailer->send($message);
        } catch (\Swift_TransportException $Ste) {
            dump($Ste);
        }

        return $m;
    }
}
