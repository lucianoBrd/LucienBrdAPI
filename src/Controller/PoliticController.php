<?php

namespace App\Controller;

use App\Entity\Politic;
use App\Service\LocalGenerator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PoliticController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }
    
    /**
     * @Route("/politic/{local}", name="politic")
     */
    public function index($local)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $politic = $this->getDoctrine()
            ->getRepository(Politic::class)
            ->findOneArray($local);

        return $this->json([
            'politic' => $politic,
            'documentPath' => $this->getParameter('app.assets.documents.politic'),
        ]);
    }
}
