-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 19 nov. 2020 à 10:33
-- Version du serveur :  5.7.21
-- Version de PHP :  7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lucien_brd_api`
--

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `blog`
--

INSERT INTO `blog` (`id`, `image`, `title`, `date`, `content`, `document`, `slug`, `local`) VALUES
(1, 'evil-twin.webp', 'L\'attaque Evil Twin - Récupérer clé WPA - WifiPhisher', '2020-11-16', 'L\'attaque Evil Twin est une technique permettant de capturer la clé WPA d\'un point d\'accès Wifi. Dans un premier temps, en rendant indisponible celui-ci. Puis, en redirigeant les clients connectés vers un faux point d\'accès contrôlé par le pirate et ressemblant de toute pièce au vrai point d\'accès, pour que les clients saisissent la clé WPA du point d\'accès légitime sans se méfier.', 'evil-twin-fr.md', 'evil-twin-attack-recover-wpa-key-wifiphisher', 'fr'),
(2, 'kali-nethunter.webp', 'Installer Kali Linux NetHunter sur un appareil Android', '2020-11-03', 'Ce tutoriel vous permettra d\'installer Kali Linux NetHunter sur un appareil Android compatible (Samsung Galaxy S5 - SM-G900F dans le tutoriel). Kali NetHunter est une plate-forme de test de pénétration mobile gratuite et open-source pour les appareils Android, basée sur Kali Linux.', 'kali-nethunter-fr.md', 'install-kali-linux-nethunter-android-device', 'fr'),
(3, 'root-twrp-sm-g900f.webp', 'Rooter et installer un Recovery Custom TWRP pour Samsung Galaxy S5 - SM-G900F', '2020-11-01', 'Équivalent du jailbreak sur iPhone, l\'idée de rooter son téléphone c\'est d\'accéder à un contrôle complet de l\'appareil. Les principaux usages qui peuvent venir en tête sont la suppression d\'applications installées par le fabricant / l\'opérateur, l\'accélération de la machine, installer une ROM spécifique ou encore pirater des jeux.', 'root-twrp-sm-g900f-fr.md', 'root-install-custom-recovery-twrp-sm-g900f', 'fr'),
(4, 'sd-card.webp', 'Augmenter le stockage d\'un appareil Android - Fusionner les mémoires', '2020-11-02', 'Votre téléphone possède un slot pour mettre une carte micro SD qui va permettre d’augmenter cette mémoire. En revanche son utilisation est vite restrictive au niveau déplacement du contenu. Si votre téléphone propose nativement dans les paramètres une option qui permet de fusionner les deux mémoires, il vous suffit de l\'activer. Sinon, voici comment procéder pour un appareil sous Android 6 minimum.', 'sd-card-fr.md', 'increase-storage-android-device-merge-memory', 'fr'),
(5, 'evil-twin.webp', 'Evil Twin Attack - Recover WPA Key - WifiPhisher', '2020-11-16', 'The Evil Twin attack is a technique to capture the WPA key of a WiFi access point. First, by making this one unavailable. Then, by redirecting the connected clients to a fake access point controlled by the hacker and resembling the real access point, so that the clients enter the WPA key of the legitimate access point without being suspicious.', 'evil-twin-en.md', 'evil-twin-attack-recover-wpa-key-wifiphisher', 'en'),
(6, 'kali-nethunter.webp', 'Install Kali Linux NetHunter on an Android device', '2020-11-03', 'This tutorial will allow you to install Kali Linux NetHunter on a compatible Android device (Samsung Galaxy S5 - SM-G900F in the tutorial). Kali NetHunter is a free and open-source mobile penetration testing platform for Android devices, based on Kali Linux.', 'kali-nethunter-en.md', 'install-kali-linux-nethunter-android-device', 'en'),
(7, 'root-twrp-sm-g900f.webp', 'Root and install a Custom Recovery TWRP for Samsung Galaxy S5 - SM-G900F', '2020-11-01', 'Equivalent to jailbreak on iPhone, the idea of rooting your phone is to access complete control of the device. The main uses that can come to mind are the removal of applications installed by the manufacturer/operator, the acceleration of the machine, install a specific ROM or even hack games.', 'root-twrp-sm-g900f-en.md', 'root-install-custom-recovery-twrp-sm-g900f', 'en'),
(8, 'sd-card.webp', 'Increase storage of an Android device - Merge memory', '2020-11-02', 'Your phone has a slot to put a micro SD card that will increase this memory. On the other hand, its use is quickly restrictive at the level of content displacement. If your phone natively offers in the settings an option that allows to merge the two memories, you just have to activate it. Otherwise, here is how to proceed for a device running on Android 6 minimum.', 'sd-card-en.md', 'increase-storage-android-device-merge-memory', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `blog_tag`
--

DROP TABLE IF EXISTS `blog_tag`;
CREATE TABLE IF NOT EXISTS `blog_tag` (
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`blog_id`,`tag_id`),
  KEY `IDX_6EC3989DAE07E97` (`blog_id`),
  KEY `IDX_6EC3989BAD26311` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `blog_tag`
--

INSERT INTO `blog_tag` (`blog_id`, `tag_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 4),
(5, 6),
(6, 4),
(6, 5),
(7, 5),
(8, 5);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv`
--

DROP TABLE IF EXISTS `cv`;
CREATE TABLE IF NOT EXISTS `cv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cv`
--

INSERT INTO `cv` (`id`, `document`, `local`) VALUES
(1, 'CV_BURDET_LUCIEN_FR.webp', 'fr'),
(2, 'CV_BURDET_LUCIEN_EN.webp', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201022191630', '2020-11-19 10:32:37', 46),
('DoctrineMigrations\\Version20201026135729', '2020-11-19 10:32:37', 76),
('DoctrineMigrations\\Version20201031161618', '2020-11-19 10:32:37', 19),
('DoctrineMigrations\\Version20201102135650', '2020-11-19 10:32:37', 154),
('DoctrineMigrations\\Version20201118152629', '2020-11-19 10:32:37', 187),
('DoctrineMigrations\\Version20201118194851', '2020-11-19 10:32:37', 19),
('DoctrineMigrations\\Version20201119094734', '2020-11-19 10:32:37', 150);

-- --------------------------------------------------------

--
-- Structure de la table `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `education`
--

INSERT INTO `education` (`id`, `image`, `title`, `place`, `date`, `local`) VALUES
(1, 'tma.webp', 'Baccalauréat Professionnel - Technicien Menuisier Agenceur - Arrêt de la formation en milieu d\'année', 'Institut Européen de Formation - Compagnons du Tour de France - Mouchard', '2015', 'fr'),
(2, 'ssi.webp', 'Baccalauréat Scientifique - Sciences de l\'Ingénieur - Mention Bien', 'Lycée de la Cotière', '2015 - 2017', 'fr'),
(3, 'b.webp', 'Permis B', 'Miribel', '2017', 'fr'),
(4, 'dut.webp', 'DUT Informatique', 'IUT Lyon 1 - Villeurbanne', '2017 - 2019', 'fr'),
(5, 'a2.webp', 'Permis A2', 'Saint-Alban', '2019', 'fr'),
(6, 'irc.webp', 'Ingénieur en Informatique et Réseaux de Communication - Apprentissage EDF CNPE de Saint-Alban', 'CPE Lyon - Villeurbanne', '2019 - 2022', 'fr'),
(7, 'tma.webp', 'Professional baccalaureate - Technician Carpenter Agenceur - Abandonment of training mid-year', 'European Training Institute  - Compagnons du Tour de France - Mouchard', '2015', 'en'),
(8, 'ssi.webp', 'Scientific baccalaureate - French high school leaving diploma - Passed with honors', 'Lycée de la Cotière', '2015 - 2017', 'en'),
(9, 'b.webp', 'Driver’s license', 'Miribel', '2017', 'en'),
(10, 'dut.webp', 'DUT Informatique - Two-year university diploma in IT', 'IUT Lyon 1 - Villeurbanne', '2017 - 2019', 'en'),
(11, 'a2.webp', 'Motorcycle license', 'Saint-Alban', '2019', 'en'),
(12, 'irc.webp', 'CPE Lyon - Department of network engineering and telecoms in an integrated work and study programme', 'CPE Lyon - Villeurbanne', '2019 - 2022', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `politic`
--

DROP TABLE IF EXISTS `politic`;
CREATE TABLE IF NOT EXISTS `politic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `politic`
--

INSERT INTO `politic` (`id`, `title`, `document`, `local`) VALUES
(1, 'Politique de Confidentialité', 'politique-de-confidentialite-fr.md', 'fr'),
(2, 'Privacy Policy', 'politique-de-confidentialite-en.md', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `git` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id`, `image`, `title`, `type`, `date`, `url`, `git`, `content`, `document`, `local`) VALUES
(1, 'emilie-nguyen.webp', '@ngyemilie', 'Site vitrine - Freelance', '2017', 'https://emilie-nguyen.com/', 'https://github.com/lucianoBrd/EmilieNguyen', 'Site pour une photographe en PHP, MySQL, HTML/CSS, JavaScript.', NULL, 'fr'),
(2, 'yosagaf.webp', 'Sagaf Youssouf', 'Site vitrine - Freelance', '2019', 'https://yosagaf.fr/', 'https://github.com/lucianoBrd/Sagaf', 'Site pour un développeur de systèmes embarqués en Symfony 4.', NULL, 'fr'),
(3, 'smart-ev.webp', 'Smart-EV', 'Projet - CPE', '2020', 'https://smart-ev.lucien-brd.com/', 'https://github.com/lucianoBrd/SmartEV', 'Cette application permet de localiser des stations de recharge compatibles avec son véhicule électrique et d’obtenir des itinéraires “intelligents”. JavaScript, Leaflet, OpenChargeMap.', NULL, 'fr'),
(4, 'graphjs.webp', 'GraphJS', 'Projet - CPE', '2020', NULL, 'https://github.com/lucianoBrd/graphJS', 'GraphJS affiche des données JSON dans un graphique SVG avec des animations et un design époustouflant en JavaScript.', NULL, 'fr'),
(5, 'snakejs.webp', 'Crazy Snake', 'Projet - IUT', '2018', NULL, 'https://github.com/lucianoBrd/SnakeJs', 'Crazy Snake pour des parties de folie. Jeu du snake fait en JavaScript, HTML et CSS', NULL, 'fr'),
(6, 'morpion.webp', 'Jeu de morpion', 'Projet - IUT', '2017', NULL, 'https://github.com/lucianoBrd/Morpion', 'Java.', 'RapportIHM_MorpionMALDONADO_BURDET_ISSOUFI_DLTEYSSONNIERE.pdf', 'fr'),
(7, 'beeleat.webp', 'BeelEAT', 'Projet tutoré - IUT', '2018 - 2019', 'https://youtu.be/i4Llz617ovY', 'https://github.com/lucianoBrd/BeelEAT', 'BeelEAT permet de gérer tout un restaurant. D\'une part un côté administrateur/cuisine permet : D\'automatiser certaines tâches comme la gestion des stocks. De gérer les commandes via l\'envoi automatique de notifications aux clients sur le statut de leur commande. De gérer les menus, produits, ingrédients... D\'autre part, le côté client du site permet de passer des commandes en ligne.', 'BeelEAT_Rapport_Projet_Tutore_S4_2019 ​MALDONADO Emilio, BURDET Lucien, DAHOUMANE Etienne, CASTILLO Berson.pdf', 'fr'),
(8, 'festival.webp', 'Festival', 'Projet - IUT', '2018', NULL, 'https://github.com/lucianoBrd/Festival', 'Application de gestion de festival (Festival de films : Cannes). PHP/Twig, Framework Symfony 4, MySQL (PhpMyAdmin/Doctrine), HTML/CSS, JavaScript.', 'Spec-festival.pdf', 'fr'),
(9, 'diminuo.webp', 'Diminuo', 'Projet', '2018', NULL, 'https://github.com/lucianoBrd/Diminuo', 'Une URL longue ? Raccourcissez-la!. PHP, MySQL, HTML/CSS, JavaScript.', NULL, 'fr'),
(10, 'derailleur.webp', 'Dérailleur Automatique', 'Projet - Lycée', '2016 - 2017', 'https://cotiere.ent.auvergnerhonealpes.fr/en-direct-du-lycee-de-la-cotiere/actualites/actualites-des-eleves/nos-lyceens-en-finale-des-olympiades-de-si-a-paris-2226.htm', NULL, 'Le dispositif d’assistance au passage de vitesse sur un Vélo est piloté par une application Android. Il dispose d’un mode manuel et automatique. De plus, le dispositif permet d\'automatisé le changement de rapport de transmission sur deux types de dérailleurs afin d’être adaptable sur tous les vélos. Ainsi, le dispositif permet d\'automatisé un dérailleur traditionnel; mais aussi un dérailleur électrique. En mode manuel, le changement de rapport de transmission se fait en appuyant sur les boutons de l’application. En mode automatique le système change de manière autonome le rapport de transmission pour permettre de pédaler à cadence de pédalage constante. Il faut simplement indiquer au système à l’aide du téléphone, quelle est la cadence de pédalage.', 'Derailleur Automatique.pdf', 'fr'),
(11, 'cral.webp', 'ELT/HARMONI.', 'Stage - Centre de Recherche Astrophysique de Lyon (CRAL)', '2019', 'http://harmoni-web.physics.ox.ac.uk/', NULL, 'L’objectif principal était de coder la structure du logiciel en C notamment les entrées/sorties. Ce logiciel sera livré avec l’instrument HARMONI à l’ESO, il avait donc des contraintes de développement fortes. En termes de contraintes de temps, il fallait finir de développer l’architecture du logiciel avant la fin du stage. Le travail était basé sur des diagrammes d’architecture. J’avait dû apprendre les librairies et logiciels de l’ESO : CPL, HDRL, EsoRex et EsoReflex. De plus, afin de générer de la documentation, j’avait dû me former à la librairie Doxygen.', 'Rapport_Stage_BURDET.pdf', 'fr'),
(12, 'emilie-nguyen.webp', '@ngyemilie', 'Website showcase - Freelance', '2017', 'https://emilie-nguyen.com/', 'https://github.com/lucianoBrd/EmilieNguyen', 'Website for a photographer in PHP, MySQL, HTML/CSS, JavaScript.', NULL, 'en'),
(13, 'yosagaf.webp', 'Sagaf Youssouf', 'Website showcase - Freelance', '2019', 'https://yosagaf.fr/', 'https://github.com/lucianoBrd/Sagaf', 'Website for an embedded systems developer in Symfony 4.', NULL, 'en'),
(14, 'smart-ev.webp', 'Smart-EV', 'Project - CPE', '2020', 'https://smart-ev.lucien-brd.com/', 'https://github.com/lucianoBrd/SmartEV', 'This application allows you to locate charging stations compatible with your electric vehicle and obtain \"smart\" itineraries. JavaScript, Leaflet, OpenChargeMap.', NULL, 'en'),
(15, 'graphjs.webp', 'GraphJS', 'Project - CPE', '2020', NULL, 'https://github.com/lucianoBrd/graphJS', 'GraphJS displays JSON data in an SVG graphic with stunning animations and design in JavaScript.', NULL, 'en'),
(16, 'snakejs.webp', 'Crazy Snake', 'Project - IUT', '2018', NULL, 'https://github.com/lucianoBrd/SnakeJs', 'Crazy Snake for crazy games. Snake game made in JavaScript, HTML et CSS', NULL, 'en'),
(17, 'morpion.webp', 'Game of tic-tac-toe', 'Project - IUT', '2017', NULL, 'https://github.com/lucianoBrd/Morpion', 'Java.', 'RapportIHM_MorpionMALDONADO_BURDET_ISSOUFI_DLTEYSSONNIERE.pdf', 'en'),
(18, 'beeleat.webp', 'BeelEAT', 'Tutored project - IUT', '2018 - 2019', 'https://youtu.be/i4Llz617ovY', 'https://github.com/lucianoBrd/BeelEAT', 'BeelEAT allows you to manage an entire restaurant. On the one hand, an administrator/kitchen side allows: To automate certain tasks such as inventory management. To manage orders via automatic sending of notifications to customers on the status of their order. To manage menus, products, ingredients... On the other hand, the customer side of the site allows to place orders online.', 'BeelEAT_Rapport_Projet_Tutore_S4_2019 ​MALDONADO Emilio, BURDET Lucien, DAHOUMANE Etienne, CASTILLO Berson.pdf', 'en'),
(19, 'festival.webp', 'Festival', 'Project - IUT', '2018', NULL, 'https://github.com/lucianoBrd/Festival', 'Festival management application (Film festival : Cannes). PHP/Twig, Framework Symfony 4, MySQL (PhpMyAdmin/Doctrine), HTML/CSS, JavaScript.', 'Spec-festival.pdf', 'en'),
(20, 'diminuo.webp', 'Diminuo', 'Project', '2018', NULL, 'https://github.com/lucianoBrd/Diminuo', 'A long URL? Shorten it!. PHP, MySQL, HTML/CSS, JavaScript.', NULL, 'en'),
(21, 'derailleur.webp', 'Automatic Derailleur', 'Project - High School', '2016 - 2017', 'https://cotiere.ent.auvergnerhonealpes.fr/en-direct-du-lycee-de-la-cotiere/actualites/actualites-des-eleves/nos-lyceens-en-finale-des-olympiades-de-si-a-paris-2226.htm', NULL, 'The speed assist device on a Bicycle is driven by an Android app. It has a manual and automatic mode. In addition, the device allows anautomated gear shifting on two types of derailleur to be adaptable on all bikes. Thus, the device allows to automate a traditional derailleur; but also an electric derailleur. In manual mode, the transmission ratio change is done by pressing the buttons of the application. In automatic mode the system independently changes the transmission ratio to allow pedaling at a constant pedaling rate. You just have to tell the system, using the phone, what is the pedaling rate you want.', 'Derailleur Automatique.pdf', 'en'),
(22, 'cral.webp', 'ELT/HARMONI.', 'Internship - Lyon Astrophysical Research Center (CNRS)', '2019', 'http://harmoni-web.physics.ox.ac.uk/', NULL, 'The main objective was to code the structure of the software in C including the inputs/outputs. This software will be delivered with the HARMONI instrument to ESO, so it had strong development constraints. In terms of time constraints, it was necessary to finish developing the software architecture before the end of the internship. The work was based on architectural diagrams. I had to learn ESO’s libraries and software: CPL, HDRL, EsoRex and EsoReflex. Moreover, in order to generate documentation, I had to train myself at the Doxygen library.', 'Rapport_Stage_BURDET.pdf', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id`, `image`, `title`, `description`, `local`) VALUES
(1, 'web.webp', 'Web', 'Je peux développer tous types de site : E-commerce, site vitrine, blog...', 'fr'),
(2, 'communication.webp', 'Communication', 'Vous ne savez pas comment bien utiliser les réseaux sociaux ? Je peux gérer vos comptes afin d’accroître votre notoriété.', 'fr'),
(3, 'publicite.webp', 'Publicité', 'Afin de d’augmenter votre présence sur internet il vous faut les meilleures publicités : image, bannière, vidéo...', 'fr'),
(4, 'web-design.webp', 'Web design', 'Je respecte les derniers standards et normes de design afin de vous proposer un produit numérique beau et fonctionnel.', 'fr'),
(5, 'logo.webp', 'Logo', 'Création de logo sur mesure avec une identité forte et de qualité.', 'fr'),
(6, 'referencement.webp', 'Référencement', 'Je peux positionner les pages web de votre site internet dans les premiers résultats naturels des moteurs de recherche.', 'fr'),
(7, 'web.webp', 'Web', 'I can develop all types of site: E-commerce, website showcase, blog...', 'en'),
(8, 'communication.webp', 'Communication', 'Not sure how to use social media properly? I can manage your accounts to increase your profile.', 'en'),
(9, 'publicite.webp', 'Advertising', 'In order to increase your presence on the internet you need the best advertisements: image, banner, video...', 'en'),
(10, 'web-design.webp', 'Web design', 'I respect the latest standards and design standards in order to offer you a beautiful and functional digital product.', 'en'),
(11, 'logo.webp', 'Logo', 'Custom logo creation with strong identity and quality.', 'en'),
(12, 'referencement.webp', 'SEO', 'I can position the web pages of your website in the first natural search engine results.', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `social`
--

DROP TABLE IF EXISTS `social`;
CREATE TABLE IF NOT EXISTS `social` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `social`
--

INSERT INTO `social` (`id`, `link`, `fa`) VALUES
(1, 'https://www.linkedin.com/in/lucien-burdet-b8b76a153', 'linkedin'),
(2, 'https://github.com/lucianoBrd', 'git');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`id`, `title`, `slug`, `local`) VALUES
(1, 'Sécurité', 'security', 'fr'),
(2, 'Android', 'android', 'fr'),
(3, 'Wifi', 'wifi', 'fr'),
(4, 'Security', 'security', 'en'),
(5, 'Android', 'android', 'en'),
(6, 'Wifi', 'wifi', 'en');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `blog_tag`
--
ALTER TABLE `blog_tag`
  ADD CONSTRAINT `FK_6EC3989BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6EC3989DAE07E97` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
