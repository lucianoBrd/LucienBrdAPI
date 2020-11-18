<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Service\LocalGenerator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }
    
    /**
     * @Route("/tag/{local}", name="tag")
     */
    public function index($local)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findAllArray($local);

        return $this->json([
            'tags' => $tags
        ]);
    }
}
