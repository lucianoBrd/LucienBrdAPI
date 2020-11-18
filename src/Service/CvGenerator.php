<?php

namespace App\Service;

use App\Entity\Cv;

class CvGenerator
{
    private $manager;
    private $locals;
    private $cvs;

    public function __construct($manager, $locals)
    {
        $this->manager = $manager;
        $this->locals = $locals;

        $this->cvs = [
            $this->locals['fr'] => [
                'CV_BURDET_LUCIEN_FR.webp',
            ],
            $this->locals['en'] => [
                'CV_BURDET_LUCIEN_EN.webp',
            ],
        ];
    }

    public function generateCv()
    {
        foreach ($this->locals as $l) {

            foreach ($this->cvs[$l] as $doc) {
                $cv = new Cv();

                $cv->setDocument($doc)
                    ->setLocal($l);

                $this->manager->persist($cv);    
            }
        }

        $this->manager->flush();
    }

}