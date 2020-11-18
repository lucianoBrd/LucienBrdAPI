<?php

namespace App\Controller;

use App\Entity\Project;
use App\Service\LocalGenerator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }

    /**
     * @Route("/project/random/{local}", name="project_random")
     */
    public function random($local)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $repo = $this->getDoctrine()
            ->getRepository(Project::class);

        $ids = $repo->findAllId($local);

        $projects = $repo->findRandomArray($ids);

        return $this->json([
            'projects' => $projects,
            'imagePath' => $this->getParameter('app.assets.images.projects')
        ]);
    }

    /**
     * @Route("/project/{local}", name="project")
     */
    public function index($local)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAllArray($local);

        return $this->json([
            'projects' => $projects,
            'imagePath' => $this->getParameter('app.assets.images.projects'),
            'documentPath' => $this->getParameter('app.assets.documents.projects'),
        ]);
    }
}
