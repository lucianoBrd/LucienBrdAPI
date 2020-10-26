<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index()
    {
        $services = $this->getDoctrine()
            ->getRepository(Service::class)
            ->findAllArray();

        return $this->json([
            $services
        ]);
    }
}
