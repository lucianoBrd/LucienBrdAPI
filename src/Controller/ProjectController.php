<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project")
     */
    public function index()
    {
        $projects = $this->getDoctrine()
                        ->getRepository(Project::class)
                        ->findAllArray();

        return $this->json([
            $projects
        ]);
    }
}
