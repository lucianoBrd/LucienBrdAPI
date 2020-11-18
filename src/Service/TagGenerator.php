<?php

namespace App\Service;

use App\Entity\Tag;

class TagGenerator
{
    private $manager;
    private $locals;
    private $tags;

    public function __construct($manager, $locals)
    {
        $this->manager = $manager;
        $this->locals = $locals;

        $this->tags = [
            $this->locals['fr'] => [
                'security' => ['Sécurité', 'security'],
                'android' => ['Android', 'android'],
                'wifi' => ['Wifi', 'wifi'],
            ],
            $this->locals['en'] => [
                'security' => ['Security', 'security'],
                'android' => ['Android', 'android'],
                'wifi' => ['Wifi', 'wifi'],
            ],
        ];
    }

    public function generateTag()
    {

        foreach ($this->locals as $l) {

            foreach ($this->tags[$l] as $t) {
                $tag = new Tag();

                $tag->setTitle($t[0])
                    ->setSlug($t[1])
                    ->setLocal($l);

                $this->manager->persist($tag);
            }
        }

        $this->manager->flush();
    }

    public function getTags()
    {
        return $this->tags;
    }

}
