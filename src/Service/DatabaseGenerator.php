<?php

namespace App\Service;

use DateTime;
use App\Entity\Cv;
use App\Entity\Tag;
use App\Entity\Blog;
use App\Entity\Social;
use App\Entity\Politic;
use App\Entity\Project;
use App\Entity\Service;
use App\Entity\Education;
use Doctrine\Persistence\ObjectManager;

class DatabaseGenerator
{
    private $manager;
    private $tags;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->tags = [
            'security' => 'Sécurité',
            'android' => 'Android',
            'wifi' => 'Wifi',
        ];
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
        $this->manageSocial();
        $this->manageCv();
        $this->managePolitic();
        $this->manageTag();
        $this->manageBlog();
    }

    public function manageProject()
    {
        $repository = $this->manager->getRepository(Project::class);

        /* Reset project database */
        $this->reset($repository);

        $projects = [
            ['emilie-nguyen.webp', '@ngyemilie', 'site vitrine - Freelance', '2017', 'https://emilie-nguyen.com/', 'https://github.com/lucianoBrd/EmilieNguyen', 'site pour une photographe en symfony 4', null],
            ['yosagaf.webp', 'sagaf youssouf', 'site vitrine - Freelance', '2019', 'https://yosagaf.fr/', 'https://github.com/lucianoBrd/Sagaf', 'site pour un développeur de systèmes embarqués en symfony 4', null],
            ['smart-ev.webp', 'Smart-EV', 'projet - CPE', '2020', 'https://smart-ev.lucien-brd.com/', 'https://github.com/lucianoBrd/SmartEV', 'cette application permet de localiser des stations de recharge compatibles avec son véhicule électrique et d’obtenir des itinéraires “intelligents”. JavaScript Leaflet OpenChargeMap', null],
            ['graphjs.webp', 'GraphJS', 'projet - CPE', '2020', null, 'https://github.com/lucianoBrd/graphJS', 'GraphJS affiche des données JSON dans un graphique SVG avec des animations et un design époustouflant en JavaScript', null],
            ['snakejs.webp', 'Crazy Snake', 'projet - IUT', '2018', null, 'https://github.com/lucianoBrd/SnakeJs', 'Crazy Snake pour des parties de folie. Jeu du snake fait en javascript, html et css', null],
            ['morpion.webp', 'Jeu de morpion', 'projet - IUT', '2017', null, 'https://github.com/lucianoBrd/Morpion', 'Java', 'RapportIHM_MorpionMALDONADO_BURDET_ISSOUFI_DLTEYSSONNIERE.pdf'],
            ['beeleat.webp', 'BeelEAT', 'Projet tutoré - IUT', '2018 - 2019', 'https://youtu.be/i4Llz617ovY', 'https://github.com/lucianoBrd/BeelEAT', 'BeelEAT permet de gérer tout un restaurant. D\'une part un côté administrateur/cuisine permet : D\'automatiser certaines tâches comme la gestion des stocks. De gérer les commandes via l\'envoi automatique de notifications aux clients sur le statut de leur commande. De gérer les menus, produits, ingrédients... D\'autre part, le côté client du site permet de passer des commandes en ligne.', 'BeelEAT_Rapport_Projet_Tutore_S4_2019 ​MALDONADO Emilio, BURDET Lucien, DAHOUMANE Etienne, CASTILLO Berson.pdf'],
            ['festival.webp', 'Festival', 'Projet - IUT', '2018', null, 'https://github.com/lucianoBrd/Festival', 'application de gestion de festival (Festival de films : Cannes). PHP/Twig (Framework Symfony4), MySQL (PhpMyAdmin/Doctrine), HTML/CSS, JavaScript', 'Spec-festival.pdf'],
            ['diminuo.webp', 'Diminuo', 'projet', '2018', null, 'https://github.com/lucianoBrd/Diminuo', 'Une URL longue ? Raccourcissez-la!. PHP, MySQL (PhpMyAdmin), HTML/CSS, JavaScript', null],
            ['derailleur.webp', 'Dérailleur Automatique', 'projet - Lycée', '2016 - 2017', 'https://cotiere.ent.auvergnerhonealpes.fr/en-direct-du-lycee-de-la-cotiere/actualites/actualites-des-eleves/nos-lyceens-en-finale-des-olympiades-de-si-a-paris-2226.htm', null, 'Le dispositif d’assistance au passage de vitesse sur un Vélo est piloté par une application Android. Il dispose d’un mode manuel et automatique. De plus, le dispositif permet d\'automatisé le changement de rapport de transmission sur deux types de dérail-leurs afin d’être adaptable sur tous les vélos. Ainsi, le dispositif permet d\'automatisé un dérailleur tradi-tionnel; mais aussi un dérailleur électrique. En mode manuel, le changement de rapport de transmission se fait en appuyant sur les boutons de l’application. En mode automatique le système change de ma-nière autonome le rapport de transmission pour permettre de pédaler à cadence de pédalage constante. Il faut simplement indiquer au système à l’aide du téléphone, quelle est la cadence de pédalage.', 'Derailleur Automatique.pdf'],
            ['cral.webp', 'ELT/HARMONI.', 'stage - Centre de Recherche Astrophysique de Lyon (CRAL)', '2019', 'http://harmoni-web.physics.ox.ac.uk/', null, 'L’objectif principal était de coder la structure du logiciel en C notamment les entrées/sorties. Ce logiciel sera livré avec l’instrument HARMONI à l’ESO, il avait donc des contraintes de développement fortes. En termes de contraintes de temps, il fallait finir de développer l’architecture du logiciel avant la fin du stage. Le travail était basé sur des diagrammes d’architecture. J’avait dû apprendre les librairies et logiciels de l’ESO : CPL, HDRL, EsoRex et EsoReflex. De plus, afin de générer de la documentation, j’avait dû me former à la librairie Doxygen.', 'Rapport_Stage_BURDET.pdf'],
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
            ['tma.webp', 'Baccalauréat Professionnel - Technicien Menuisier Agenceur - Arrêt de la formation en milieu d\'année', 'Institut Européen de Formation - Compagnons du Tour de France - Mouchard', '2015'],
            ['ssi.webp', 'Baccalauréat Scientifique - Sciences de l\'Ingénieur - Mention Bien', 'Lycée de la Cotière', '2015 - 2017'],
            ['b.webp', 'Permis B', 'Miribel', '2017'],
            ['dut.webp', 'DUT Informatique', 'IUT Lyon 1 - Villeurbanne', '2017 - 2019'],
            ['a2.webp', 'Permis A2', 'Saint-Alban', '2019'],
            ['irc.webp', 'Ingénieur en Informatique et Réseaux de Communication - Apprentissage EDF CNPE de Saint-Alban', 'CPE Lyon - Villeurbanne', '2019 - 2022'],
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
            ['web.webp', 'Web', 'Je peux développer tous types de site : E-commerce, site vitrine, blog...'],
            ['communication.webp', 'Communication', 'Vous ne savez pas comment bien utiliser les réseaux sociaux ? Je peux gérer vos comptes afin d’accroître votre notoriété.'],
            ['publicite.webp', 'Publicité', 'Afin de d’augmenter votre présence sur internet il vous faut les meilleures publicités : image, bannière, vidéo...'],
            ['web-design.webp', 'Web design', 'Je respecte les derniers standards et normes de design afin de vous proposer un produit numérique beau et fonctionnel.'],
            ['logo.webp', 'Logo', 'Création de logo sur mesure avec une identité forte et de qualité.'],
            ['referencement.webp', 'Référencement', 'Je peux positionner les pages web de votre site internet dans les premiers résultats naturels des moteurs de recherche.'],
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

    public function manageSocial()
    {
        $repository = $this->manager->getRepository(Social::class);

        /* Reset project database */
        $this->reset($repository);

        $socials = [
            ['https://www.linkedin.com/in/lucien-burdet-b8b76a153', 'linkedin'],
            ['https://github.com/lucianoBrd', 'git'],
        ];

        foreach ($socials as $s) {
            $social = new Social();

            $social->setLink($s[0])
                ->setFa($s[1]);

            $this->manager->persist($social);
        }

        $this->manager->flush();

    }

    public function manageCv()
    {
        $repository = $this->manager->getRepository(Cv::class);

        /* Reset project database */
        $this->reset($repository);

        $cv = new Cv();

        $cv->setDocument('CV_BURDET_LUCIEN.webp');

        $this->manager->persist($cv);

        $this->manager->flush();

    }

    public function managePolitic()
    {
        $repository = $this->manager->getRepository(Politic::class);

        /* Reset project database */
        $this->reset($repository);

        $politic = new Politic();

        $politic->setTitle('Politique de confidentialité')
            ->setDocument('politique-de-confidentialite.md');

        $this->manager->persist($politic);

        $this->manager->flush();

    }

    public function manageTag()
    {
        $repository = $this->manager->getRepository(Tag::class);

        /* Reset project database */
        $this->reset($repository);

        foreach ($this->tags as $t) {
            $tag = new Tag();

            $tag->setTitle($t);

            $this->manager->persist($tag);
        }

        $this->manager->flush();

    }

    public function manageBlog()
    {
        $repository = $this->manager->getRepository(Blog::class);
        $repoTag = $this->manager->getRepository(Tag::class);

        /* Reset project database */
        $this->reset($repository);

        $blogs = [
            [
                'evil-twin.webp',
                'L\'attaque Evil Twin - Récupérer clé WPA - WifiPhisher',
                'attaque-evil-twin-recuperer-cle-wpa-wifiphisher',
                [
                    $this->tags['security'], 
                    $this->tags['wifi']
                ],
                new \DateTime('16-11-2020'),
                'L\'attaque Evil Twin est une technique permettant de capturer la clé WPA d\'un point d\'accès Wifi. Dans un premier temps en rendant insdiponible celui-ci. Puis, en redirigeant les clients connectés vers un faux point d\'accès contrôlé par le pirate ressemblant de toute pièce au vrai point d\'accès, de tel sorte à ce que les clients saississent la clé WPA du point d\'accès légitime sans se méfier.',
                'evil-twin.md'
            ],
            [
                'kali-nethunter.webp',
                'Installer Kali Linux NetHunter sur un appareil Android (Samsung Galaxy S5 - SM-G900F)',
                'installer-kali-linux-nethunter-appareil-android-sm-g900f',
                [
                    $this->tags['security'], 
                    $this->tags['android']
                ],
                new \DateTime('03-11-2020'),
                'Ce tutoriel vous permettra d\'installer Kali Linux NetHunter sur un appareil Android compatible (Samsung Galaxy S5 - SM-G900F dans le tutoriel). Kali NetHunter est une plate-forme de test de pénétration mobile gratuite et open-source pour les appareils Android, basée sur Kali Linux.',
                'kali-nethunter.md'
            ],
            [
                'root-twrp-sm-g900f.webp',
                'Rooter et installer un Recovery Custom TWRP pour Samsung Galaxy S5 - SM-G900F',
                'rooter-installer-recovery-custom-twrp-sm-g900f',
                [
                    $this->tags['android']
                ],
                new \DateTime('01-11-2020'),
                'Équivalent du jailbreak sur iPhone, l\'idée de rooter son téléphone c\'est d\'accéder à un contrôle complet de l\'appareil. Les principaux usages qui peuvent venir en tête sont la suppression d\'applications installées par le fabricant / l\'opérateur, l\'accélération de la machine, installer une ROM spécifique ou encore pirater des jeux.',
                'root-twrp-sm-g900f.md'
            ],
            [
                'sd-card.webp',
                'Augmenter le stockage d\'un appareil Android - Fusionner les mémoires',
                'augmenter-stockage-appareil-android-fusionner-mémoires',
                [
                    $this->tags['android']
                ],
                new \DateTime('02-11-2020'),
                'Votre téléphone possède un slot pour mettre une carte micro SD qui va permettre d’augmenter cette mémoire. En revanche son utilisation est vite restrictive niveau déplacement du contenu. Si votre téléphone propose nativement dans les paramètres une option qui permet de fusionner les deux mémoires, il vous suffit de l\'activer.',
                'sd-card.md'
            ],
        ];

        foreach ($blogs as $b) {
            $blog = new Blog();

            $blog->setImage($b[0])
                ->setTitle($b[1])
                ->setSlug($b[2])
                ->setDate($b[4])
                ->setContent($b[5])
                ->setDocument($b[6]);
            
            foreach ($b[3] as $t) {
                $tag = $repoTag->findOneBy(['title' => $t]);
                $blog->addTag($tag);
            }

            $this->manager->persist($blog);
        }

        $this->manager->flush();

    }
}
