[build.py-h]: https://api.lucien-brd.com/assets/images/blogs/kali-nethunter/build.py-h.webp "build.py -h résultat"
[install-zip]: https://api.lucien-brd.com/assets/images/blogs/kali-nethunter/install-zip.webp "installer zip"
[twrp]: https://api.lucien-brd.com/assets/images/blogs/kali-nethunter/twrp.webp "twrp"
[kernel]: https://api.lucien-brd.com/assets/images/blogs/kali-nethunter/kernel.webp "kernel"

Ce tutoriel vous permettra d'installer Kali Linux NetHunter sur un appareil Android compatible (Samsung Galaxy S5 - SM-G900F dans le tutoriel) :
* *Kernel* spécifique NetHunter
* Surcouche avec les outils et applications NetHunter

Kali NetHunter est une plate-forme de test de pénétration mobile gratuite et open-source pour les appareils Android, basée sur Kali Linux. Les principaux outils fournis sont :
* Conteneur Kali Linux qui inclut tous les outils et applications fournis par Kali Linux (avec un émulateur de terminal)
* Kali NetHunter App qui inclut des outils et services supplémentaires (*HID Keyboard Attacks*, *BadUSB attacks*, *Evil AP MANA attacks*, etc...)
* Kali NetHunter Store pour installer des applications et outils de sécurité
* Kali NetHunter Desktop Experience (KeX) pour exécuter des sessions de bureau Kali Linux complètes sur un écran (via HDMI ou *screen casting*)

# Table des matières

1. Prérequis
2. L'image NetHunter
    1. Télécharger une image déjà existante
    2. Générer sa propre image
3. Installation
4. Configuration après installation
5. En savoir plus
    1. Liens de téléchargement
    2. Documentation

# 1. Prérequis

Avant toute manipulation je vous invite à vérifier que votre appareil est compatible (voir 2. L'image NetHunter).

* Assurez vous d'avoir une batterie chargée (75% minimum).
* Avoir au moins 9go de stockage de disponible (voir [Augmenter le stockage d'un appareil Android - Fusionner les mémoires](https://www.lucien-brd.com/blog/augmenter-stockage-appareil-android-fusionner-mémoires))  
* Avoir un téléphone *rooté* avec un *Recovery Custom* (voir [Rooter et installer un Recovery Custom TWRP pour Samsung Galaxy S5 - SM-G900F](https://www.lucien-brd.com/blog/rooter-installer-recovery-custom-twrp-sm-g900f)).
* Avoir l'image NetHunter compatible avec son téléphone (voir 2. L'image NetHunter).

# 2. L'image NetHunter

## 2.1. Télécharger une image déjà existante
Si vous trouvez une image NetHunter compatible avec votre appareil (attention à la version d'Android) via ce lien https://www.offensive-security.com/kali-linux-nethunter-download, il vous suffit de télécharger celle-ci (pas besoin de siuvre les étapes suivante de cette partie).

L'image pour un Samsung Galaxy S5 - SM-G900F, Android 6 - *Marshmallow*, ROM officielle *Touchwiz* est disponible [ici](https://api.lucien-brd.com/assets/documents/blogs/kali-nethunter/update-nethunter-20201020_215800-klte-touchwiz-marshmallow.zip) (pas besoin de siuvre les étapes suivante de cette partie).

Si vous n'avez pas trouvé d'image compatible avec votre appareil tout n'est pas perdu.

## 2.2. Générer sa propre image
1. Premièrement il faudra que vous récupériez le projet :
    ```sh
    $ git clone https://gitlab.com/kalilinux/nethunter/build-scripts/kali-nethunter-project
    ```

2. Puis allez dans le dossier ```nethunter-installer``` du projet afin de le *build* :
    ```sh
    $ cd kali-nethunter/nethunter-installer
    $ ./bootstrap.sh
    ```

3. Si tout c'est bien déroulé, vous devrié pouvoir executer la commande suivante (dans le dossier ```nethunter-installer```) :
    ```sh
    $ python3 build.py -h
    ```

    ![build.py -h résultat][build.py-h]

    Comme vous le constatez, la liste des appareils et des versions d'Android compatible sont affichées.

4. Enfin vous devez générer l'image NetHunter. Si vous avez installé une ROM        *custom*, vérifiez dans la liste des *device* qu'il n'existe pas une version spécifique à celle-ci.
    Dans le cas d'un Samsung Galaxy S5 - SM-G900F, Android 6 - *Marshmallow*, ROM   officielle *Touchwiz*, la commande est la suivante ( dans le dossier              ```nethunter-installer```) :
    ```sh
    $ python3 build.py -d klte-touchwiz -m
    ```
    L'image sera crée dans le dossier ```nethunter-installer``` au format zip.
    C'est le fichier zip dont vous aurez besoin pour flasher votre appareil.

# 3. Installation

Afin d'installer l'image NetHunter, il faudra flasher celle-ci sur votre téléphone.

1. Copier l'image NetHunter (fichier zip) sur votre téléphone.
2. Eteindre votre téléphone.
3. Démarer votre téléphone en mode *recovery*.
Pour le s5 appuyez simultanément sur **volume haut + home + power**.
![twrp][twrp]
3. Faites un *backup* de votre configuration actuelle (optionnel).
4. Installez le fichier. ![install-zip][install-zip]

Si l'installation s'est bien déroulée, si vous ouvrez NetHunter App, le *Kernel Version* devrait être celui de Kali Linux NetHunter :
![kernel][kernel]

# 4. Configuration après installation

1. Ouvrez NetHunter App et allez dans *Kali Chroot Manager*. Téléchargez et installez *Kali Chroot* (faites attention de choisir la version compatible avec l'architecture de votre processeur).
2. Ouvrez NetHunter Store (F-Droid) et installez *Hacker Keyboard*.

# 5. En savoir plus

## 5.1. Liens de téléchargement

* [update-nethunter-20201020_215800-klte-touchwiz-marshmallow.zip](https://api.lucien-brd.com/assets/documents/blogs/kali-nethunter/update-nethunter-20201020_215800-klte-touchwiz-marshmallow.zip)

## 5.2. Documentation

* https://www.kali.org/docs/nethunter/
* https://gitlab.com/kalilinux/nethunter/build-scripts/kali-nethunter-project
