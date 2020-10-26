<?php

namespace App\DataFixtures;

use App\Entity\Education;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EducationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $educations = [
            ['tma.png', 'Baccalauréat Professionnel - Technicien Menuisier Agenceur - Arrêt de la formation en milieu d\'année', 'Institut Européen de Formation - Compagnons du Tour de France - Mouchard', '2015'],
            ['ssi.png', 'Baccalauréat Scientifique - Sciences de l\'Ingénieur - Mention Bien', 'Lycée de la Cotière', '2015 - 2017'],
            ['b.png', 'Permis B', 'Miribel', '2017'],
            ['dut.png', 'DUT Informatique', 'IUT Lyon 1 - Villeurbanne', '2017 - 2019'],
            ['a2.png', 'Permis A2', 'Saint-Alban', '2019'],
            ['irc.png', 'Ingénieur en Informatique et Réseaux de Communication - Apprentissage EDF CNPE de Saint-Alban', 'CPE Lyon - Villeurbanne', '2019 - 2022'],
        ];

        foreach ($educations as $e) {
            $education = new Education();

            $education->setImage($e[0])
                    ->setTitle($e[1])
                    ->setPlace($e[2])
                    ->setDate($e[3]);

            $manager->persist($education);
        }

        $manager->flush();
    }
}
