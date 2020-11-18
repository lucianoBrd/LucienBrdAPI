<?php

namespace App\Controller;

use App\Entity\Cv;
use App\Service\LocalGenerator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CvController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }

    /**
     * @Route("/cv/{local}", name="cv")
     */
    public function index($local)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $cv = $this->getDoctrine()
            ->getRepository(Cv::class)
            ->findOneArray($local);

        return $this->json([
            'cv' => $cv,
            'documentPath' => $this->getParameter('app.assets.documents.cv'),
        ]);
    }
}
