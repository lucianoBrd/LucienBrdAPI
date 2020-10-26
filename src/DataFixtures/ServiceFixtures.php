<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $services = [
            ['web.png', 'Web', 'Je peux développer tous types de site : E-commerce, site vitrine, blog...'],
            ['communication.png', 'Communication', 'Vous ne savez pas comment bien utiliser les réseaux sociaux ? Je peux gérer vos comptes afin d’accroître votre notoriété.'],
            ['publicite.png', 'Publicité', 'Afin de d’augmenter votre présence sur internet il vous faut les meilleures publicités : image, bannière, vidéo...'],
            ['web-design.png', 'Web design', 'Je respecte les derniers standards et normes de design afin de vous proposer un produit numérique beau et fonctionnel.'],
            ['logo.png', 'Logo', 'Création de logo sur mesure.'],
            ['referencement.png', 'Référencement', 'Je peux positionner les pages web de votre site internet dans les premiers résultats naturels des moteurs de recherche.'],
        ];

        foreach ($services as $s) {
            $service = new Service();

            $service->setImage($s[0])
                    ->setTitle($s[1])
                    ->setDescription($s[2]);

            $manager->persist($service);
        }

        $manager->flush();
    }
}
