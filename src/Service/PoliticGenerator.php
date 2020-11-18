<?php

namespace App\Service;

use App\Entity\Politic;

class PoliticGenerator
{
    private $manager;
    private $locals;
    private $politics;

    public function __construct($manager, $locals)
    {
        $this->manager = $manager;
        $this->locals = $locals;

        $this->politics = [
            $this->locals['fr'] => [
                ['Politique de Confidentialité', 'politique-de-confidentialite-fr.md'],
            ],
            $this->locals['en'] => [
                ['Privacy Policy', 'politique-de-confidentialite-en.md'],
            ],
        ];
    }

    public function generatePolitic()
    {
        foreach ($this->locals as $l) {

            foreach ($this->politics[$l] as $p) {
                $politic = new Politic();

                $politic->setTitle($p[0])
                        ->setDocument($p[1])
                        ->setLocal($l);

                $this->manager->persist($politic);    
            }
        }

        $this->manager->flush();
    }

}