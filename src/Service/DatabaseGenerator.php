<?php

namespace App\Service;

use App\Entity\Cv;
use App\Entity\Tag;
use App\Entity\Blog;
use App\Entity\File;
use App\Entity\Social;
use App\Entity\Politic;
use App\Entity\Project;
use App\Entity\Service;
use App\Entity\Education;
use App\Service\CvGenerator;
use App\Service\TagGenerator;
use App\Service\BlogGenerator;
use App\Service\LocalGenerator;
use App\Service\PoliticGenerator;
use App\Service\ProjectGenerator;
use App\Service\ServiceGenerator;
use App\Service\EducationGenerator;
use Doctrine\Persistence\ObjectManager;

class DatabaseGenerator
{
    private $manager;
    private $tags;
    private $locals;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;

        $localGenerator = new LocalGenerator();
        $this->locals = $localGenerator->getLocals();

    }

    private function reset($repository)
    {
        $entities = $repository->findAll();

        foreach ($entities as $entity) {
            $this->manager->remove($entity);
        }
    }

    public function updateDatabase()
    {
        $this->manageProject();
        $this->manageEducation();
        $this->manageService();
        $this->manageSocial();
        $this->manageCv();
        $this->managePolitic();
        $this->manageFile();
        $this->manageTag();
        $this->manageBlog();
    }

    public function manageProject()
    {
        $repository = $this->manager->getRepository(Project::class);

        /* Reset project database */
        $this->reset($repository);

        /* Generate project */
        $projectGenerator = new ProjectGenerator($this->manager, $this->locals);
        $projectGenerator->generateProject();

    }

    public function manageEducation()
    {
        $repository = $this->manager->getRepository(Education::class);

        /* Reset education database */
        $this->reset($repository);

        /* Generate education */
        $educationGenerator = new EducationGenerator($this->manager, $this->locals);
        $educationGenerator->generateEducation();

    }

    public function manageService()
    {
        $repository = $this->manager->getRepository(Service::class);

        /* Reset service database */
        $this->reset($repository);

        /* Generate service */
        $serviceGenerator = new ServiceGenerator($this->manager, $this->locals);
        $serviceGenerator->generateService();

    }

    public function manageSocial()
    {
        $repository = $this->manager->getRepository(Social::class);

        /* Reset project database */
        $this->reset($repository);

        $socials = [
            ['https://www.linkedin.com/in/lucien-burdet-b8b76a153', 'linkedin'],
            ['https://github.com/lucianoBrd', 'git'],
        ];

        foreach ($socials as $s) {
            $social = new Social();

            $social->setLink($s[0])
                ->setFa($s[1]);

            $this->manager->persist($social);
        }

        $this->manager->flush();

    }

    public function manageFile()
    {
        $repository = $this->manager->getRepository(File::class);

        /* Reset project database */
        $this->reset($repository);

        $files = [
            ['Pages-main.zip', 'phishingPages?oh8'],
        ];

        foreach ($files as $f) {
            $file = new File();

            $file->setFile($f[0])
                ->setPassword($f[1]);

            $this->manager->persist($file);
        }

        $this->manager->flush();

    }

    public function manageCv()
    {
        $repository = $this->manager->getRepository(Cv::class);

        /* Reset cv database */
        $this->reset($repository);

        /* Generate cv */
        $cvGenerator = new CvGenerator($this->manager, $this->locals);
        $cvGenerator->generateCv();

    }

    public function managePolitic()
    {
        $repository = $this->manager->getRepository(Politic::class);

        /* Reset politic database */
        $this->reset($repository);

        /* Generate politic */
        $politicGenerator = new PoliticGenerator($this->manager, $this->locals);
        $politicGenerator->generatePolitic();

    }

    public function manageTag()
    {
        $repository = $this->manager->getRepository(Tag::class);

        /* Reset tag database */
        $this->reset($repository);

        /* Generate tag */
        $tagGenerator = new TagGenerator($this->manager, $this->locals);
        $tagGenerator->generateTag();

        $this->tags = $tagGenerator->getTags();

    }

    public function manageBlog()
    {
        $repository = $this->manager->getRepository(Blog::class);

        /* Reset blog database */
        $this->reset($repository);

        /* Generate blog */
        $blogGenerator = new BlogGenerator($this->manager, $this->locals, $this->tags);
        $blogGenerator->generateBlog();

    }
}
