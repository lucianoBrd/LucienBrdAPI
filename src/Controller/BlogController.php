<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Service\LocalGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private $localGenerator;

    public function __construct(LocalGenerator $localGenerator)
    {
        $this->localGenerator = $localGenerator;
    }

    private function formatBlog($blogs, $array = true)
    {
        $key = 'date';
        if ($array) {
            $newBlogs = [];
            foreach ($blogs as $blog) {
                $blog[$key] = $blog[$key]->format('Y-m-d H:i:s');
                $newBlogs[] = $blog;
            }
            return $newBlogs;
        } else {
            $blogs[$key] = $blog[$key]->format('Y-m-d H:i:s');
            return $blogs;
        }
    }

    /**
     * @Route("/blog/latest/{local}", name="blog_latest")
     */
    public function getLatest($local)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $blogs = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->findLatestArray($local);

        return $this->json([
            'blogs' => $this->formatBlog($blogs),
            'imagePath' => $this->getParameter('app.assets.images.blogs'),
        ]);
    }

    /**
     * @Route("/blog/{local}", name="blog")
     */
    public function index($local)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $blogs = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->findAllArray($local);

        return $this->json([
            'blogs' => $this->formatBlog($blogs),
            'imagePath' => $this->getParameter('app.assets.images.blogs'),
        ]);
    }

    /**
     * @Route("/blog/tag/{local}/{slug}", name="blog_tag")
     */
    public function getByTag($local, $slug)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $blogs = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->findByTagArray($local, $slug);

        return $this->json([
            'blogs' => $this->formatBlog($blogs),
            'imagePath' => $this->getParameter('app.assets.images.blogs'),
        ]);
    }

    /**
     * @Route("/blog/{local}/{slug}", name="blog_slug")
     */
    public function getOneBySlug($local, $slug)
    {
        if ($this->localGenerator->checkLocal($local)) {
            return $this->json([]);
        }

        $blog = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->findOneBySlugArray($local, $slug);

        return $this->json([
            'blog' => $this->formatBlog($blogs, false),
            'imagePath' => $this->getParameter('app.assets.images.blogs'),
            'documentPath' => $this->getParameter('app.assets.documents.blogs'),
        ]);
    }

}
