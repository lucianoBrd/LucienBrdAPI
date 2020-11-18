<?php

namespace App\Service;

use App\Entity\Education;

class EducationGenerator
{
    private $manager;
    private $locals;
    private $educations;

    public function __construct($manager, $locals)
    {
        $this->manager = $manager;
        $this->locals = $locals;

        $this->educations = [
            $this->locals['fr'] => [
                ['tma.webp', 'Baccalauréat Professionnel - Technicien Menuisier Agenceur - Arrêt de la formation en milieu d\'année', 'Institut Européen de Formation - Compagnons du Tour de France - Mouchard', '2015'],
                ['ssi.webp', 'Baccalauréat Scientifique - Sciences de l\'Ingénieur - Mention Bien', 'Lycée de la Cotière', '2015 - 2017'],
                ['b.webp', 'Permis B', 'Miribel', '2017'],
                ['dut.webp', 'DUT Informatique', 'IUT Lyon 1 - Villeurbanne', '2017 - 2019'],
                ['a2.webp', 'Permis A2', 'Saint-Alban', '2019'],
                ['irc.webp', 'Ingénieur en Informatique et Réseaux de Communication - Apprentissage EDF CNPE de Saint-Alban', 'CPE Lyon - Villeurbanne', '2019 - 2022'],
            ],
            $this->locals['en'] => [
                ['tma.webp', 'Professional baccalaureate - Technician Carpenter Agenceur - Abandonment of training mid-year', 'European Training Institute  - Compagnons du Tour de France - Mouchard', '2015'],
                ['ssi.webp', 'Scientific baccalaureate - French high school leaving diploma - Passed with honors', 'Lycée de la Cotière', '2015 - 2017'],
                ['b.webp', 'Driver’s license', 'Miribel', '2017'],
                ['dut.webp', 'DUT Informatique - Two-year university diploma in IT', 'IUT Lyon 1 - Villeurbanne', '2017 - 2019'],
                ['a2.webp', 'Motorcycle license', 'Saint-Alban', '2019'],
                ['irc.webp', 'CPE Lyon - Department of network engineering and telecoms in an integrated work and study programme', 'CPE Lyon - Villeurbanne', '2019 - 2022'],
            ],
        ];
    }

    public function generateEducation()
    {
        foreach ($this->locals as $l) {

            foreach ($this->educations[$l] as $e) {
                $education = new Education();
    
                $education->setImage($e[0])
                    ->setTitle($e[1])
                    ->setPlace($e[2])
                    ->setDate($e[3])
                    ->setLocal($l);
    
                $this->manager->persist($education);
            }
        }

        $this->manager->flush();
    }

}