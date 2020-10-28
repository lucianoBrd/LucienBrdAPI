<?php

namespace App\Controller;

use App\Entity\Cv;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CvController extends AbstractController
{
    /**
     * @Route("/cv", name="cv")
     */
    public function index()
    {
        $cv = $this->getDoctrine()
            ->getRepository(Cv::class)
            ->findOneArray();

        return $this->json([
            'cv' => $cv,
            'documentPath' => $this->getParameter('app.assets.documents.cv'),
        ]);
    }
}
