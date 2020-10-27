<?php

namespace App\Controller;

use App\Entity\Social;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SocialController extends AbstractController
{
    /**
     * @Route("/social", name="social")
     */
    public function index()
    {
        $socials = $this->getDoctrine()
            ->getRepository(Social::class)
            ->findAllArray();

        return $this->json([
            $socials
        ]);
    }
}
