<?php

namespace App\Service;

class LocalGenerator
{
    private $locals;

    public function __construct()
    {
        $this->locals = [
            'fr' => 'fr',
            'en' => 'en',
        ];
    }

    public function getLocals() {
        return $this->locals;
    }

    public function checkLocal($local): bool {
        $error = true;
        foreach ($this->locals as $l) {
            if ($l == $local) {
                $error = false;
            }
        }
        return $error;
    }

}
