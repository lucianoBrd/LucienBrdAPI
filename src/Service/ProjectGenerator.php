<?php

namespace App\Service;

use App\Entity\Project;

class ProjectGenerator
{
    private $manager;
    private $locals;
    private $projects;

    public function __construct($manager, $locals)
    {
        $this->manager = $manager;
        $this->locals = $locals;

        $this->projects = [
            $this->locals['fr'] => [
                [
                    'emilie-nguyen.webp', 
                    '@ngyemilie', 
                    'Site vitrine - Freelance', 
                    '2017', 
                    'https://emilie-nguyen.com/', 
                    'https://github.com/lucianoBrd/EmilieNguyen', 
                    'Site pour une photographe en PHP, MySQL, HTML/CSS, JavaScript.', 
                    null
                ],
                [
                    'yosagaf.webp', 
                    'Sagaf Youssouf', 
                    'Site vitrine - Freelance', 
                    '2019', 
                    'https://yosagaf.fr/', 
                    'https://github.com/lucianoBrd/Sagaf', 
                    'Site pour un développeur de systèmes embarqués en Symfony 4.', 
                    null
                ],
                [
                    'smart-ev.webp', 
                    'Smart-EV', 
                    'Projet - CPE', 
                    '2020', 
                    'https://smart-ev.lucien-brd.com/', 
                    'https://github.com/lucianoBrd/SmartEV', 
                    'Cette application permet de localiser des stations de recharge compatibles avec son véhicule électrique et d’obtenir des itinéraires “intelligents”. JavaScript, Leaflet, OpenChargeMap.', 
                    null
                ],
                [
                    'CPE-Projet-Transversal-2021.webp', 
                    'CPE Projet Transversal 2021', 
                    'Projet - CPE', 
                    '2021', 
                    'https://youtu.be/eT1Ov4cR_HA', 
                    'https://github.com/lucianoBrd/TransversalCPE', 
                    'L’objectif de ce projet était de réaliser d’une part un simulateur d’incendies permettant la création, le suivi et la propagation de feux de différents types (localisés sur une carte), et d’autre part de créer un dispositif de gestion de services d’urgences permettant, à partir d’informations collectées par des capteurs, de déployer et gérer les dispositifs adaptés pour éteindre les incendies.', 
                    'CPE-Projet-Transversal-2021.pdf'
                ],
                [
                    'graphjs.webp', 
                    'GraphJS', 
                    'Projet - CPE', 
                    '2020', 
                    null, 
                    'https://github.com/lucianoBrd/graphJS', 
                    'GraphJS affiche des données JSON dans un graphique SVG avec des animations et un design époustouflant en JavaScript.', 
                    null
                ],
                [
                    'snakejs.webp', 
                    'Crazy Snake', 
                    'Projet - IUT', 
                    '2018', 
                    null, 
                    'https://github.com/lucianoBrd/SnakeJs', 
                    'Crazy Snake pour des parties de folie. Jeu du snake fait en JavaScript, HTML et CSS', 
                    null
                ],
                [
                    'morpion.webp', 
                    'Jeu de morpion', 
                    'Projet - IUT', 
                    '2017', 
                    null, 
                    'https://github.com/lucianoBrd/Morpion', 
                    'Java.', 
                    'RapportIHM_MorpionMALDONADO_BURDET_ISSOUFI_DLTEYSSONNIERE.pdf'
                ],
                [
                    'beeleat.webp', 
                    'BeelEAT', 
                    'Projet tutoré - IUT', 
                    '2018 - 2019', 
                    'https://youtu.be/i4Llz617ovY', 
                    'https://github.com/lucianoBrd/BeelEAT', 
                    'BeelEAT permet de gérer tout un restaurant. D\'une part un côté administrateur/cuisine permet : D\'automatiser certaines tâches comme la gestion des stocks. De gérer les commandes via l\'envoi automatique de notifications aux clients sur le statut de leur commande. De gérer les menus, produits, ingrédients... D\'autre part, le côté client du site permet de passer des commandes en ligne.', 
                    'BeelEAT_Rapport_Projet_Tutore_S4_2019 ​MALDONADO Emilio, BURDET Lucien, DAHOUMANE Etienne, CASTILLO Berson.pdf'
                ],
                [
                    'festival.webp', 
                    'Festival', 
                    'Projet - IUT', 
                    '2018', 
                    null, 
                    'https://github.com/lucianoBrd/Festival', 
                    'Application de gestion de festival (Festival de films : Cannes). PHP/Twig, Framework Symfony 4, MySQL (PhpMyAdmin/Doctrine), HTML/CSS, JavaScript.', 
                    'Spec-festival.pdf'
                ],
                [
                    'diminuo.webp', 
                    'Diminuo', 
                    'Projet', 
                    '2018', 
                    null, 
                    'https://github.com/lucianoBrd/Diminuo', 
                    'Une URL longue ? Raccourcissez-la!. PHP, MySQL, HTML/CSS, JavaScript.', 
                    null
                ],
                [
                    'derailleur.webp', 
                    'Dérailleur Automatique', 
                    'Projet - Lycée', 
                    '2016 - 2017', 
                    'https://cotiere.ent.auvergnerhonealpes.fr/en-direct-du-lycee-de-la-cotiere/actualites/actualites-des-eleves/nos-lyceens-en-finale-des-olympiades-de-si-a-paris-2226.htm', 
                    null, 
                    'Le dispositif d’assistance au passage de vitesse sur un Vélo est piloté par une application Android. Il dispose d’un mode manuel et automatique. De plus, le dispositif permet d\'automatisé le changement de rapport de transmission sur deux types de dérailleurs afin d’être adaptable sur tous les vélos. Ainsi, le dispositif permet d\'automatisé un dérailleur traditionnel; mais aussi un dérailleur électrique. En mode manuel, le changement de rapport de transmission se fait en appuyant sur les boutons de l’application. En mode automatique le système change de manière autonome le rapport de transmission pour permettre de pédaler à cadence de pédalage constante. Il faut simplement indiquer au système à l’aide du téléphone, quelle est la cadence de pédalage.', 
                    'Derailleur Automatique.pdf'
                ],
                [
                    'cral.webp', 
                    'ELT/HARMONI.', 
                    'Stage - Centre de Recherche Astrophysique de Lyon (CRAL)', 
                    '2019', 
                    'http://harmoni-web.physics.ox.ac.uk/', 
                    null, 
                    'L’objectif principal était de coder la structure du logiciel en C notamment les entrées/sorties. Ce logiciel sera livré avec l’instrument HARMONI à l’ESO, il avait donc des contraintes de développement fortes. En termes de contraintes de temps, il fallait finir de développer l’architecture du logiciel avant la fin du stage. Le travail était basé sur des diagrammes d’architecture. J’avait dû apprendre les librairies et logiciels de l’ESO : CPL, HDRL, EsoRex et EsoReflex. De plus, afin de générer de la documentation, j’avait dû me former à la librairie Doxygen.', 
                    'Rapport_Stage_BURDET.pdf'
                ],
            ],
            $this->locals['en'] => [
                [
                    'emilie-nguyen.webp', 
                    '@ngyemilie', 
                    'Website showcase - Freelance', 
                    '2017', 
                    'https://emilie-nguyen.com/', 
                    'https://github.com/lucianoBrd/EmilieNguyen', 
                    'Website for a photographer in PHP, MySQL, HTML/CSS, JavaScript.', 
                    null
                ],
                [
                    'yosagaf.webp', 
                    'Sagaf Youssouf', 
                    'Website showcase - Freelance', 
                    '2019', 
                    'https://yosagaf.fr/', 
                    'https://github.com/lucianoBrd/Sagaf', 
                    'Website for an embedded systems developer in Symfony 4.', 
                    null
                ],
                [
                    'smart-ev.webp', 
                    'Smart-EV', 
                    'Project - CPE', 
                    '2020', 
                    'https://smart-ev.lucien-brd.com/', 
                    'https://github.com/lucianoBrd/SmartEV', 
                    'This application allows you to locate charging stations compatible with your electric vehicle and obtain "smart" itineraries. JavaScript, Leaflet, OpenChargeMap.', 
                    null
                ],
                [
                    'CPE-Projet-Transversal-2021.webp', 
                    'CPE Transversal Project 2021', 
                    'Project - CPE', 
                    '2021', 
                    'https://youtu.be/eT1Ov4cR_HA', 
                    'https://github.com/lucianoBrd/TransversalCPE', 
                    'The aim of the project was to create a fire simulator allowing the creation, monitoring and propagation of fires of different types (located on a map), and to create an emergency services management system allowing, from information collected by sensors, deploy and manage suitable devices for extinguishing fires.', 
                    'CPE-Projet-Transversal-2021.pdf'
                ],
                [
                    'graphjs.webp', 
                    'GraphJS', 
                    'Project - CPE', 
                    '2020', 
                    null, 
                    'https://github.com/lucianoBrd/graphJS', 
                    'GraphJS displays JSON data in an SVG graphic with stunning animations and design in JavaScript.', 
                    null
                ],
                [
                    'snakejs.webp', 
                    'Crazy Snake', 
                    'Project - IUT', 
                    '2018', 
                    null, 
                    'https://github.com/lucianoBrd/SnakeJs', 
                    'Crazy Snake for crazy games. Snake game made in JavaScript, HTML et CSS', 
                    null
                ],
                [
                    'morpion.webp', 
                    'Game of tic-tac-toe', 
                    'Project - IUT', 
                    '2017', 
                    null, 
                    'https://github.com/lucianoBrd/Morpion', 
                    'Java.', 
                    'RapportIHM_MorpionMALDONADO_BURDET_ISSOUFI_DLTEYSSONNIERE.pdf'
                ],
                [
                    'beeleat.webp', 
                    'BeelEAT', 
                    'Tutored project - IUT', 
                    '2018 - 2019', 
                    'https://youtu.be/i4Llz617ovY', 
                    'https://github.com/lucianoBrd/BeelEAT', 
                    'BeelEAT allows you to manage an entire restaurant. On the one hand, an administrator/kitchen side allows: To automate certain tasks such as inventory management. To manage orders via automatic sending of notifications to customers on the status of their order. To manage menus, products, ingredients... On the other hand, the customer side of the site allows to place orders online.', 
                    'BeelEAT_Rapport_Projet_Tutore_S4_2019 ​MALDONADO Emilio, BURDET Lucien, DAHOUMANE Etienne, CASTILLO Berson.pdf'
                ],
                [
                    'festival.webp', 
                    'Festival', 
                    'Project - IUT', 
                    '2018', 
                    null, 
                    'https://github.com/lucianoBrd/Festival', 
                    'Festival management application (Film festival : Cannes). PHP/Twig, Framework Symfony 4, MySQL (PhpMyAdmin/Doctrine), HTML/CSS, JavaScript.', 
                    'Spec-festival.pdf'
                ],
                [
                    'diminuo.webp', 
                    'Diminuo', 
                    'Project', 
                    '2018', 
                    null, 
                    'https://github.com/lucianoBrd/Diminuo', 
                    'A long URL? Shorten it!. PHP, MySQL, HTML/CSS, JavaScript.', 
                    null
                ],
                [
                    'derailleur.webp', 
                    'Automatic Derailleur', 
                    'Project - High School', 
                    '2016 - 2017', 
                    'https://cotiere.ent.auvergnerhonealpes.fr/en-direct-du-lycee-de-la-cotiere/actualites/actualites-des-eleves/nos-lyceens-en-finale-des-olympiades-de-si-a-paris-2226.htm', 
                    null, 
                    'The speed assist device on a Bicycle is driven by an Android app. It has a manual and automatic mode. In addition, the device allows anautomated gear shifting on two types of derailleur to be adaptable on all bikes. Thus, the device allows to automate a traditional derailleur; but also an electric derailleur. In manual mode, the transmission ratio change is done by pressing the buttons of the application. In automatic mode the system independently changes the transmission ratio to allow pedaling at a constant pedaling rate. You just have to tell the system, using the phone, what is the pedaling rate you want.', 
                    'Derailleur Automatique.pdf'
                ],
                [
                    'cral.webp', 
                    'ELT/HARMONI.', 
                    'Internship - Lyon Astrophysical Research Center (CNRS)', 
                    '2019', 
                    'http://harmoni-web.physics.ox.ac.uk/', 
                    null, 
                    'The main objective was to code the structure of the software in C including the inputs/outputs. This software will be delivered with the HARMONI instrument to ESO, so it had strong development constraints. In terms of time constraints, it was necessary to finish developing the software architecture before the end of the internship. The work was based on architectural diagrams. I had to learn ESO’s libraries and software: CPL, HDRL, EsoRex and EsoReflex. Moreover, in order to generate documentation, I had to train myself at the Doxygen library.', 
                    'Rapport_Stage_BURDET.pdf'
                ],
            ],
        ];
    }

    public function generateProject()
    {
        foreach ($this->locals as $l) {

            foreach ($this->projects[$l] as $p) {
                $project = new Project();

                $project->setImage($p[0])
                    ->setTitle($p[1])
                    ->setType($p[2])
                    ->setDate($p[3])
                    ->setUrl($p[4])
                    ->setGit($p[5])
                    ->setContent($p[6])
                    ->setDocument($p[7])
                    ->setLocal($l);

                $this->manager->persist($project);
            }
        }

        $this->manager->flush();
    }

}