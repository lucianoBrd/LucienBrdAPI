<?php

namespace App\Controller;

use App\Entity\Service;
use App\Service\LocalGenerator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }
    
    /**
     * @Route("/service/{local}", name="service")
     */
    public function index($local)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $services = $this->getDoctrine()
            ->getRepository(Service::class)
            ->findAllArray($local);

        return $this->json([
            'services' => $services,
            'imagePath' => $this->getParameter('app.assets.images.services')
        ]);
    }
}
