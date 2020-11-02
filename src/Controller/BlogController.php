<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $blogs = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->findAllArray();

        foreach ($blogs as $b) {
            
        }
        return $this->json([
            'blogs' => $blogs,
            'imagePath' => $this->getParameter('app.assets.images.blogs'),
        ]);
    }

    /**
     * @Route("/blog/latest", name="blog_latest")
     */
    public function getLatest()
    {
        $blogs = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->findLatestArray();

        return $this->json([
            'blogs' => $blogs,
            'imagePath' => $this->getParameter('app.assets.images.blogs'),
        ]);
    }

    /**
     * @Route("/blog/tag/{tag}", name="blog_tag")
     */
    public function getByTag($tag)
    {
        $blogs = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->findByTagArray($tag);

        return $this->json([
            'blogs' => $blogs,
            'imagePath' => $this->getParameter('app.assets.images.blogs'),
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="blog_slug")
     */
    public function getOneBySlug($slug)
    {
        $blog = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->findOneBySlugArray($slug);

        return $this->json([
            'blog' => $blog,
            'imagePath' => $this->getParameter('app.assets.images.blogs'),
            'documentPath' => $this->getParameter('app.assets.documents.blogs'),
        ]);
    }

}
