<?php

namespace App\Service;

use App\Entity\Service;

class ServiceGenerator
{
    private $manager;
    private $locals;
    private $services;

    public function __construct($manager, $locals)
    {
        $this->manager = $manager;
        $this->locals = $locals;

        $this->services = [
            $this->locals['fr'] => [
                ['web.webp', 'Web', 'Je peux développer tous types de site : E-commerce, site vitrine, blog...'],
                ['communication.webp', 'Communication', 'Vous ne savez pas comment bien utiliser les réseaux sociaux ? Je peux gérer vos comptes afin d’accroître votre notoriété.'],
                ['publicite.webp', 'Publicité', 'Afin de d’augmenter votre présence sur internet il vous faut les meilleures publicités : image, bannière, vidéo...'],
                ['web-design.webp', 'Web design', 'Je respecte les derniers standards et normes de design afin de vous proposer un produit numérique beau et fonctionnel.'],
                ['logo.webp', 'Logo', 'Création de logo sur mesure avec une identité forte et de qualité.'],
                ['referencement.webp', 'Référencement', 'Je peux positionner les pages web de votre site internet dans les premiers résultats naturels des moteurs de recherche.'],
            ],
            $this->locals['en'] => [
                ['web.webp', 'Web', 'I can develop all types of site: E-commerce, website showcase, blog...'],
                ['communication.webp', 'Communication', 'Not sure how to use social media properly? I can manage your accounts to increase your profile.'],
                ['publicite.webp', 'Advertising', 'In order to increase your presence on the internet you need the best advertisements: image, banner, video...'],
                ['web-design.webp', 'Web design', 'I respect the latest standards and design standards in order to offer you a beautiful and functional digital product.'],
                ['logo.webp', 'Logo', 'Custom logo creation with strong identity and quality.'],
                ['referencement.webp', 'SEO', 'I can position the web pages of your website in the first natural search engine results.'],
            ],
        ];
    }

    public function generateService()
    {
        foreach ($this->locals as $l) {

            foreach ($this->services[$l] as $s) {
                $service = new Service();
    
                $service->setImage($s[0])
                    ->setTitle($s[1])
                    ->setDescription($s[2])
                    ->setLocal($l);
    
                $this->manager->persist($service);
            }
        }

        $this->manager->flush();
    }

}