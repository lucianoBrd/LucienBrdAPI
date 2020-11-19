<?php

namespace App\Service;

use App\Entity\File;

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

    public function getConfirm($local, $name) {
        if ($local == 'fr') {
            $confirm = '<h1>Bonjour ' . $name . '</h1>';
            $confirm .= '<p>Merci pour votre message, je vous répondrais dans les meilleurs délais.</p>';
            $confirm .= '<br>';
            $confirm .= '<p>---------------------------------------</p>';
        } else {
            $confirm = '<h1>Hello ' . $name . '</h1>';
            $confirm .= '<p>Thank you for your message, I will answer you as soon as possible.</p>';
            $confirm .= '<br>';
            $confirm .= '<p>---------------------------------------</p>';
        }

        return $confirm;
    }

    public function getMessageFile($local, $name, $path, File $f) {
        $fullPath = $path . $f->getFile();

        if ($local == 'fr') {
            $html = '<h1>Bonjour ' . $name . '</h1>';
            $html .= '<p>Vous trouverez le fichier ici : <a href="' . $fullPath . '">' . $fullPath . '</a></p>';
            $html .= '<p>Le mot de passe de l\'archive est : ' . $f->getPassword() . '.</p>';
            $html .= '<p>Pour rappel : "Les systèmes, programmes et méthodologies sont utilisés à but éducatif et préventif uniquement. Vous restez les responsables de vos actions et aucune responsabilité ne sera engagée quant à la mauvaise utilisation du contenu enseigné."</p>';
            $html .= '<br>';
        } else {
            $html = '<h1>Hello ' . $name . '</h1>';
            $html .= '<p>You can find the file here : <a href="' . $fullPath . '">' . $fullPath . '</a></p>';
            $html .= '<p>The archive password is : ' . $f->getPassword() . '.</p>';
            $html .= '<p>As a reminder: "Systems, programmes and methodologies are used for educational and preventive purposes only. You remain responsible for your actions and there will be no liability for the misuse of the content taught."</p>';
            $html .= '<br>';
        }

        return $html;
    }

    public function getSubject($local) {
        if ($local == 'fr') {
            return 'Confirmation de Réception';
        } else {
            return 'Confirmation of Recusal';
        }
    }

    public function getSubjectFile($local, $file) {
        if ($local == 'fr') {
            return 'Télécharger ' . $file;
        } else {
            return 'Download ' . $file;
        }
    }

}
