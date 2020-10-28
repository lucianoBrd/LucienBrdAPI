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
            'projects' => $projects,
            'imagePath' => $this->getParameter('app.assets.images.projects'),
            'documentPath' => $this->getParameter('app.assets.documents.projects'),
        ]);
    }

    /**
     * @Route("/project/random", name="project_random")
     */
    public function random()
    {
        $repo = $this->getDoctrine()
            ->getRepository(Project::class);

        $ids = $repo->findAllId();

        $projects = $repo->findRandomArray($ids);

        return $this->json([
            'projects' => $projects,
            'imagePath' => $this->getParameter('app.assets.images.projects')
        ]);
    }
}
