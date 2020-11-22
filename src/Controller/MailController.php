<?php

namespace App\Controller;

use App\Service\MailService;
use App\Service\LocalGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    private $localGenerator;
    private $mailService;

    public function __construct(LocalGenerator $localGenerator, MailService $mailService)
    {
        $this->localGenerator = $localGenerator;
        $this->mailService = $mailService;
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function testMail()
    {
        $local = 'fr';
        $title = 'Titre';

        $m = $this->mailService->getMessage(
            $title,
            $local,
            'contact',
            'Lucien Burdet',
            [
                'Ceci est un paragraphe',
                'Deuxième paragraphe',
            ],
            [
                'url' => '#', 
                'title' => $this->localGenerator->getDownload($local),
            ],
            'secret'
        );
        
        /*$error = $this->mailService->sendMessage(
            'contact@lucien-brd.com',
            $title,
            $this->mailService->getMessageView(
                $title,
                $local,
                'contact',
                'Lucien Burdet',
                [
                    'Ceci est un paragraphe',
                    'Deuxième paragraphe',
                ],
                [
                    'url' => '#', 
                    'title' => $this->localGenerator->getDownload($local),
                ],
                'secret'
            )
        );*/

        return $m;
    }
}
