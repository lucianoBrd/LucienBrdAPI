<?php

namespace App\Controller;

use App\Entity\Education;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EducationController extends AbstractController
{
    /**
     * @Route("/education", name="education")
     */
    public function index()
    {
        $educations = $this->getDoctrine()
            ->getRepository(Education::class)
            ->findAllArray();

        return $this->json([
            'educations' => $educations,
            'imagePath' => $this->getParameter('app.assets.images.educations'),
        ]);
    }
}
