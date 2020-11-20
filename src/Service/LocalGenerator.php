<?php

namespace App\Service;

use App\Entity\Blog;
use App\Entity\File;
use App\Entity\Comment;

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

    public function getConfirm($local, $message) {
        $confirm = [];
        if ($local == 'fr') {
            $confirm[] = 'Merci pour votre message, je vous répondrais dans les meilleurs délais.';
            $message[] = '';
            $confirm[] = 'Votre message :';
        } else {
            $confirm[] = 'Thank you for your message, I will answer you as soon as possible.';
            $message[] = '';
            $confirm[] = 'Your message :';
        }
        $confirm[] = $message;

        return $confirm;
    }

    public function getFile($local, File $f) {
        $message = [];
        if ($local == 'fr') {
            $message[] = 'Le mot de passe de l\'archive est : ' . $f->getPassword();
            $message[] = '';
            $message[] = 'Pour rappel : "Les systèmes, programmes et méthodologies sont utilisés à but éducatif et préventif uniquement. Vous restez les responsables de vos actions et aucune responsabilité ne sera engagée quant à la mauvaise utilisation du contenu enseigné."';
        } else {
            $message[] = 'The archive password is : ' . $f->getPassword();
            $message[] = '';
            $message[] = 'As a reminder: "Systems, programmes and methodologies are used for educational and preventive purposes only. You remain responsible for your actions and there will be no liability for the misuse of the content taught."';
        }

        return $message;
    }

    public function getReplyComment($local, Blog $blog, Comment $comment) {
        $message = [];
        if ($local == 'fr') {
            $message[] = 'Vous aviez commenté l\'article : ' . $blog->getTitle();
            $message[] = '';
            $message[] = $comment->getUser()->getName() . ' vous a répondu :';
        } else {
            $message[] = 'You commented on the article : ' . $blog->getTitle();
            $message[] = '';
            $message[] = $comment->getUser()->getName() . ' answered you :';
        }

        $message[] = $comment->getMessage();

        return $message;
    }

    public function getConfirmComment($local, Blog $blog, Comment $comment) {
        $message = [];
        if ($local == 'fr') {
            $message[] = 'Nouveau commentaire sur l\'article : ' . $blog->getTitle();
            $message[] = '';
            $message[] = $comment->getUser()->getName() . ' a commenté :';
        } else {
            $message[] = 'New comment on the article : ' . $blog->getTitle();
            $message[] = '';
            $message[] = $comment->getUser()->getName() . ' has commented :';
        }

        $message[] = $comment->getMessage();

        return $message;
    }

    public function getThankComment($local) {
        if ($local == 'fr') {
            return 'Merci pour votre commentaire';
        } else {
            return 'Thank you for your comment';
        }
    }

    public function getTitleReplyComment($local, $name) {
        if ($local == 'fr') {
            return $name . ' a répondu à votre commentaire';
        } else {
            return $name . ' responded to your comment';
        }
    }

    public function getAnswer($local) {
        if ($local == 'fr') {
            return 'Je vous répondrais dans les meilleurs délais.';
        } else {
            return 'I will answer you as soon as possible.';
        }
    }

    public function getRecusal($local) {
        if ($local == 'fr') {
            return 'Confirmation de Réception';
        } else {
            return 'Confirmation of Recusal';
        }
    }

    public function getQuestion($local) {
        if ($local == 'fr') {
            return 'Vous avez une question ?';
        } else {
            return 'Have A question ?';
        }
    }

    public function getContact($local) {
        if ($local == 'fr') {
            return 'Si vous avez des questions, n\'hésitez pas à me contacter';
        } else {
            return 'If you have any questions, please contact me';
        }
    }

    public function getHello($local) {
        if ($local == 'fr') {
            return 'Bonjour';
        } else {
            return 'Hello';
        }
    }

    public function getDownload($local) {
        if ($local == 'fr') {
            return 'Télécharger';
        } else {
            return 'Download';
        }
    }

    public function getSeePost($local) {
        if ($local == 'fr') {
            return 'Voir l\'article';
        } else {
            return 'See post';
        }
    }

}
