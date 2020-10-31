<?php

namespace App\Controller;

use App\Entity\Politic;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PoliticController extends AbstractController
{
    /**
     * @Route("/politic", name="politic")
     */
    public function index()
    {
        $politic = $this->getDoctrine()
            ->getRepository(Politic::class)
            ->findOneArray();

        return $this->json([
            'politic' => $politic,
            'documentPath' => $this->getParameter('app.assets.documents.politic'),
        ]);
    }
}
