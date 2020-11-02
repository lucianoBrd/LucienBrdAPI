<?php

namespace App\Controller;

use App\Entity\Tag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="tag")
     */
    public function index()
    {
        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findAllArray();

        return $this->json([
            'tags' => $tags
        ]);
    }
}
