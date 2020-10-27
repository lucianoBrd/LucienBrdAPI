<?php

namespace App\Service;

use App\Entity\Project;
use App\Entity\Service;
use App\Entity\Education;
use Doctrine\Persistence\ObjectManager;

class DatabaseGenerator
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    private function reset($repository)
    {
        $entities = $repository->findAll();

        foreach ($entities as $entity) {
            $this->manager->remove($entity);
        }
    }

    public function updateDatabase()
    {
        $this->manageProject();
        $this->manageEducation();
        $this->manageService();
    }

    public function manageProject()
    {
        $repository = $this->manager->getRepository(Project::class);

        /* Reset project database */
        $this->reset($repository);

        $projects = [
            ['emilie-nguyen.png', 'site pour une photographe', 'site vitrine - Freelance', '2017', 'https://emilie-nguyen.com/', 'https://github.com/lucianoBrd/EmilieNguyen', 'symfony 4', null],
            ['yosagaf.png', 'site pour un développeur de systèmes embarqués', 'site vitrine - Freelance', '2019', 'https://yosagaf.fr/', 'https://github.com/lucianoBrd/Sagaf', 'symfony 4', null],
            ['smart-ev.png', 'cette application permet de localiser des stations de recharge compatibles avec son véhicule électrique et d’obtenir des itinéraires “intelligents”', 'projet - CPE', '2019', 'https://smart-ev.lucien-brd.com/', 'https://github.com/lucianoBrd/SmartEV', 'JavaScript Leaflet OpenChargeMap', null],
            ['graphjs.png', 'GraphJS affiche des données JSON dans un graphique SVG avec des animations et un design époustouflant', 'projet - CPE', '2019', null, 'https://github.com/lucianoBrd/graphJS', 'JavaScript', null],
            ['snakejs.png', 'Crazy Snake pour des parties de folie.', 'projet - IUT', '2018', null, 'https://github.com/lucianoBrd/SnakeJs', 'Jeu du snake fait en javascript, html et css', null],
            ['morpion.png', 'Jeu de morpion', 'projet - IUT', '2017', null, 'https://github.com/lucianoBrd/Morpion', 'Java', 'RapportIHM_MorpionMALDONADO_BURDET_ISSOUFI_DLTEYSSONNIERE.pdf'],
            ['beeleat.png', 'BeelEAT permet de gérer tout un restaurant.', 'Projet tutoré - IUT', '2018 - 2019', 'https://youtu.be/i4Llz617ovY', 'https://github.com/lucianoBrd/BeelEAT', 'BeelEAT permet de gérer tout un restaurant. D\'une part un côté administrateur/cuisine permet : D\'automatiser certaines tâches comme la gestion des stocks. De gérer les commandes via l\'envoi automatique de notifications aux clients sur le statut de leur commande. De gérer les menus, produits, ingrédients... D\'autre part, le côté client du site permet de passer des commandes en ligne.', 'BeelEAT_Rapport_Projet_Tutore_S4_2019 ​MALDONADO Emilio, BURDET Lucien, DAHOUMANE Etienne, CASTILLO Berson.pdf'],
            ['festival.png', 'application de gestion de festival (Festival de films : Cannes)', 'Projet - IUT', '2018', null, 'https://github.com/lucianoBrd/Festival', 'PHP/Twig (Framework Symfony4), MySQL (PhpMyAdmin/Doctrine), HTML/CSS, JavaScript', 'Spec-festival.pdf'],
            ['diminuo.png', 'Une URL longue ? Raccourcissez-la!', 'projet', '2018', null, 'https://github.com/lucianoBrd/Diminuo', 'PHP, MySQL (PhpMyAdmin), HTML/CSS, JavaScript', null],
            ['derailleur.png', 'Dérailleur Automatique, dispositif d’assistance au passage de vitesse sur un Vélo', 'projet - Lycée', '2016 - 2017', 'https://cotiere.ent.auvergnerhonealpes.fr/en-direct-du-lycee-de-la-cotiere/actualites/actualites-des-eleves/nos-lyceens-en-finale-des-olympiades-de-si-a-paris-2226.htm', null, 'Le dispositif est piloté par une application Android. Il dispose d’un mode manuel et automatique. De plus, le dispositif permet d\'automatisé le changement de rapport de transmission sur deux types de dérail-leurs afin d’être adaptable sur tous les vélos. Ainsi, le dispositif permet d\'automatisé un dérailleur tradi-tionnel; mais aussi un dérailleur électrique. En mode manuel, le changement de rapport de transmission se fait en appuyant sur les boutons de l’application. En mode automatique le système change de ma-nière autonome le rapport de transmission pour permettre de pédaler à cadence de pédalage constante. Il faut simplement indiquer au système à l’aide du téléphone, quelle est la cadence de pédalage.', 'Derailleur Automatique.pdf'],
            ['cral.png', 'Codage de la structure du logiciel de réduction de données de l’instrument ELT/HARMONI.', 'stage - Centre de Recherche Astrophysique de Lyon (CRAL)', '2019', 'http://harmoni-web.physics.ox.ac.uk/', null, 'L’objectif principal était de coder la structure du logiciel en C notamment les entrées/sorties. Ce logiciel sera livré avec l’instrument HARMONI à l’ESO, il avait donc des contraintes de développement fortes. En termes de contraintes de temps, il fallait finir de développer l’architecture du logiciel avant la fin du stage. Le travail était basé sur des diagrammes d’architecture. J’avait dû apprendre les librairies et logiciels de l’ESO : CPL, HDRL, EsoRex et EsoReflex. De plus, afin de générer de la documentation, j’avait dû me former à la librairie Doxygen.', 'Rapport_Stage_BURDET.pdf'],
        ];

        foreach ($projects as $p) {
            $project = new Project();

            $project->setImage($p[0])
                    ->setTitle($p[1])
                    ->setType($p[2])
                    ->setDate($p[3])
                    ->setUrl($p[4])
                    ->setGit($p[5])
                    ->setContent($p[6])
                    ->setDocument($p[7]);

            $this->manager->persist($project);
        }

        $this->manager->flush();

    }

    public function manageEducation()
    {
        $repository = $this->manager->getRepository(Education::class);

        /* Reset project database */
        $this->reset($repository);

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

            $this->manager->persist($education);
        }

        $this->manager->flush();

    }

    public function manageService()
    {
        $repository = $this->manager->getRepository(Service::class);

        /* Reset project database */
        $this->reset($repository);

        $services = [
            ['web.png', 'Web', 'Je peux développer tous types de site : E-commerce, site vitrine, blog...'],
            ['communication.png', 'Communication', 'Vous ne savez pas comment bien utiliser les réseaux sociaux ? Je peux gérer vos comptes afin d’accroître votre notoriété.'],
            ['publicite.png', 'Publicité', 'Afin de d’augmenter votre présence sur internet il vous faut les meilleures publicités : image, bannière, vidéo...'],
            ['web-design.png', 'Web design', 'Je respecte les derniers standards et normes de design afin de vous proposer un produit numérique beau et fonctionnel.'],
            ['logo.png', 'Logo', 'Création de logo sur mesure avec une identité forte et de qualité.'],
            ['referencement.png', 'Référencement', 'Je peux positionner les pages web de votre site internet dans les premiers résultats naturels des moteurs de recherche.'],
        ];

        foreach ($services as $s) {
            $service = new Service();

            $service->setImage($s[0])
                    ->setTitle($s[1])
                    ->setDescription($s[2]);

            $this->manager->persist($service);
        }

        $this->manager->flush();

    }
}