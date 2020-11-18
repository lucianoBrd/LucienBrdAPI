<?php

namespace App\Controller;

use App\Entity\Education;
use App\Service\LocalGenerator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EducationController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }
    
    /**
     * @Route("/education/{local}", name="education")
     */
    public function index($local)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $educations = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findAllArray($local);

        return $this->json([
            'educations' => $educations,
            'imagePath' => $this->getParameter('app.assets.images.educations'),
        ]);
    }
}
