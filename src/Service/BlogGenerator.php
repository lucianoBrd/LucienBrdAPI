<?php

namespace App\Service;

use App\Entity\Tag;
use App\Entity\Blog;

class BlogGenerator
{
    private $manager;
    private $locals;
    private $blogs;
    private $tags;

    public function __construct($manager, $locals, $tags)
    {
        $this->manager = $manager;
        $this->locals = $locals;
        $this->tags = $tags;

        $this->blogs = [
            $this->locals['fr'] => [
                [
                    'evil-twin.webp',
                    'L\'attaque Evil Twin - Récupérer clé WPA - WifiPhisher',
                    'evil-twin-attack-recover-wpa-key-wifiphisher',
                    [
                        $this->tags['fr']['security'][1],
                        $this->tags['fr']['wifi'][1],
                    ],
                    new \DateTime('16-11-2020'),
                    'L\'attaque Evil Twin est une technique permettant de capturer la clé WPA d\'un point d\'accès Wifi. Dans un premier temps, en rendant indisponible celui-ci. Puis, en redirigeant les clients connectés vers un faux point d\'accès contrôlé par le pirate et ressemblant de toute pièce au vrai point d\'accès, pour que les clients saisissent la clé WPA du point d\'accès légitime sans se méfier.',
                    'evil-twin-fr.md',
                ],
                [
                    'kali-nethunter.webp',
                    'Installer Kali Linux NetHunter sur un appareil Android',
                    'install-kali-linux-nethunter-android-device',
                    [
                        $this->tags['fr']['security'][1],
                        $this->tags['fr']['android'][1],
                    ],
                    new \DateTime('03-11-2020'),
                    'Ce tutoriel vous permettra d\'installer Kali Linux NetHunter sur un appareil Android compatible (Samsung Galaxy S5 - SM-G900F dans le tutoriel). Kali NetHunter est une plate-forme de test de pénétration mobile gratuite et open-source pour les appareils Android, basée sur Kali Linux.',
                    'kali-nethunter-fr.md',
                ],
                [
                    'root-twrp-sm-g900f.webp',
                    'Rooter et installer un Recovery Custom TWRP pour Samsung Galaxy S5 - SM-G900F',
                    'root-install-custom-recovery-twrp-sm-g900f',
                    [
                        $this->tags['fr']['android'][1],
                    ],
                    new \DateTime('01-11-2020'),
                    'Équivalent du jailbreak sur iPhone, l\'idée de rooter son téléphone c\'est d\'accéder à un contrôle complet de l\'appareil. Les principaux usages qui peuvent venir en tête sont la suppression d\'applications installées par le fabricant / l\'opérateur, l\'accélération de la machine, installer une ROM spécifique ou encore pirater des jeux.',
                    'root-twrp-sm-g900f-fr.md',
                ],
                [
                    'sd-card.webp',
                    'Augmenter le stockage d\'un appareil Android - Fusionner les mémoires',
                    'increase-storage-android-device-merge-memory',
                    [
                        $this->tags['fr']['android'][1],
                    ],
                    new \DateTime('02-11-2020'),
                    'Votre téléphone possède un slot pour mettre une carte micro SD qui va permettre d’augmenter cette mémoire. En revanche son utilisation est vite restrictive au niveau déplacement du contenu. Si votre téléphone propose nativement dans les paramètres une option qui permet de fusionner les deux mémoires, il vous suffit de l\'activer. Sinon, voici comment procéder pour un appareil sous Android 6 minimum.',
                    'sd-card-fr.md',
                ],
            ],
            $this->locals['en'] => [
                [
                    'evil-twin.webp',
                    'Evil Twin Attack - Recover WPA Key - WifiPhisher',
                    'evil-twin-attack-recover-wpa-key-wifiphisher',
                    [
                        $this->tags['en']['security'][1],
                        $this->tags['en']['wifi'][1],
                    ],
                    new \DateTime('16-11-2020'),
                    'The Evil Twin attack is a technique to capture the WPA key of a WiFi access point. First, by making this one unavailable. Then, by redirecting the connected clients to a fake access point controlled by the hacker and resembling the real access point, so that the clients enter the WPA key of the legitimate access point without being suspicious.',
                    'evil-twin-en.md',
                ],
                [
                    'kali-nethunter.webp',
                    'Install Kali Linux NetHunter on an Android device',
                    'install-kali-linux-nethunter-android-device',
                    [
                        $this->tags['en']['security'][1],
                        $this->tags['en']['android'][1],
                    ],
                    new \DateTime('03-11-2020'),
                    'This tutorial will allow you to install Kali Linux NetHunter on a compatible Android device (Samsung Galaxy S5 - SM-G900F in the tutorial). Kali NetHunter is a free and open-source mobile penetration testing platform for Android devices, based on Kali Linux.',
                    'kali-nethunter-en.md',
                ],
                [
                    'root-twrp-sm-g900f.webp',
                    'Root and install a Custom Recovery TWRP for Samsung Galaxy S5 - SM-G900F',
                    'root-install-custom-recovery-twrp-sm-g900f',
                    [
                        $this->tags['en']['android'][1],
                    ],
                    new \DateTime('01-11-2020'),
                    'Equivalent to jailbreak on iPhone, the idea of rooting your phone is to access complete control of the device. The main uses that can come to mind are the removal of applications installed by the manufacturer/operator, the acceleration of the machine, install a specific ROM or even hack games.',
                    'root-twrp-sm-g900f-en.md',
                ],
                [
                    'sd-card.webp',
                    'Increase storage of an Android device - Merge memory',
                    'increase-storage-android-device-merge-memory',
                    [
                        $this->tags['en']['android'][1],
                    ],
                    new \DateTime('02-11-2020'),
                    'Your phone has a slot to put a micro SD card that will increase this memory. On the other hand, its use is quickly restrictive at the level of content displacement. If your phone natively offers in the settings an option that allows to merge the two memories, you just have to activate it. Otherwise, here is how to proceed for a device running on Android 6 minimum.',
                    'sd-card-en.md',
                ],
            ],
        ];
    }

    public function generateBlog()
    {
        $repoTag = $this->manager->getRepository(Tag::class);
        foreach ($this->locals as $l) {

            foreach ($this->blogs[$l] as $b) {
                $blog = new Blog();
    
                $blog->setImage($b[0])
                    ->setTitle($b[1])
                    ->setSlug($b[2])
                    ->setDate($b[4])
                    ->setContent($b[5])
                    ->setDocument($b[6])
                    ->setLocal($l);
    
                foreach ($b[3] as $t) {
                    $tag = $repoTag->findOneBy(['slug' => $t, 'local' => $l]);
                    $blog->addTag($tag);
                }
    
                $this->manager->persist($blog);
            }
        }

        $this->manager->flush();
    }

}