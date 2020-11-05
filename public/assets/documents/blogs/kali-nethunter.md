[build.py-h]: https://api.lucien-brd.com/assets/documents/blogs/installer-kali-linux-nethunter-appareil-android-sm-g900f/build.py-h.webp "build.py -h résultat"
[install-zip]: https://api.lucien-brd.com/assets/documents/blogs/installer-kali-linux-nethunter-appareil-android-sm-g900f/install-zip.webp "installer zip"
[twrp]: https://api.lucien-brd.com/assets/documents/blogs/installer-kali-linux-nethunter-appareil-android-sm-g900f/twrp.webp "twrp"
[adb-list-disks]: https://api.lucien-brd.com/assets/documents/blogs/installer-kali-linux-nethunter-appareil-android-sm-g900f/adb-list-disks.webp "adb list-disks"
[kernel]: https://api.lucien-brd.com/assets/documents/blogs/installer-kali-linux-nethunter-appareil-android-sm-g900f/kernel.webp "kernel"

Ce tutoriel vous permettra d'installer Kali Linux NetHunter sur un appareil Android compatible (Samsung Galaxy S5 - SM-G900F dans le tutoriel) :
* *Kernel* spécifique NetHunter
* Surcouche avec les outils et applications NetHunter

Kali NetHunter est une plate-forme de test de pénétration mobile gratuite et open-source pour les appareils Android, basée sur Kali Linux. Les principaux outils fournis sont :
* Conteneur Kali Linux qui inclut tous les outils et applications fournis par Kali Linux (avec un émulateur de terminal)
* Kali NetHunter App qui inclut des outils et services supplémentaires (*HID Keyboard Attacks*, *BadUSB attacks*, *Evil AP MANA attacks*, etc...)
* Kali NetHunter Store pour installer des applications et outils de sécurité
* Kali NetHunter Desktop Experience (KeX) pour exécuter des sessions de bureau Kali Linux complètes sur un écran (via HDMI ou *screen casting*)

#### Table des matières

- [Table des matières](#table-des-matières)
- [Prérequis](#prérequis)
  - [Augmenter le stockage de l'appareil](#augmenter-le-stockage-de-lappareil)
  - [*Root* et *Recovery Custom*](#root-et-recovery-custom)
    - [*Rooter* le téléphone](#rooter-le-téléphone)
    - [Installer un *Recovery Custom* TWRP](#installer-un-recovery-custom-twrp)
  - [L'image NetHunter](#limage-nethunter)
    - [Télécharger une image déjà existante](#télécharger-une-image-déjà-existante)
    - [Générer sa propre image](#générer-sa-propre-image)
- [Installation](#installation)
- [Configuration après installation](#configuration-après-installation)
- [En savoir plus](#en-savoir-plus)

#### Prérequis
Avant toute manipulation je vous invite à vérifier que votre appareil est compatible (voir [L'image NetHunter](#limage-nethunter)).

* Assurez vous d'avoir une batterie chargée (75% minimum).
* Avoir au moins 9go de stockage de disponible (voir [Augmenter le stockage de l'appareil](#augmenter-le-stockage-de-lappareil))  
* Avoir un téléphone *rooté* avec un *Recovery Custom* (voir [*Root* et *Recovery Custom*](#root-et-recovery-custom)).
* Avoir l'image NetHunter compatible avec son téléphone (voir [L'image NetHunter](#limage-nethunter)).

##### Augmenter le stockage de l'appareil
Votre téléphone possède un slot pour mettre une carte micro SD qui va permettre d’augmenter cette mémoire. En revanche son utilisation est vite restrictive niveau déplacement du contenu.
Si votre téléphone propose nativement dans les paramètres une option qui permet de fusionner les deux mémoires, il vous suffit de l'activer.
Sinon, voici comment procéder pour un appareil sous Android 6 minimum (Android ne le prend pas en charge dans les versions précedente).

1. [Télécharger](https://api.lucien-brd.com/assets/documents/blogs/installer-kali-linux-nethunter-appareil-android-sm-g900f/adb-setup-1.4.3.exe) et installer l’application ADB pour votre ordinateur.
2. Activer :
   * Le mode développeur : Paramètres > A propos de l'appareil > Taper plusieurs fois sur le numéro de *build*
   * Le débogage USB : Paramètres > Options de développement > Débogage USB.
3. Ouvrir une invite de commande et allez dans le répertoire d'installation :
   ```sh
    $ cd \adb
    ```
4. Connecter votre téléphone à l'ordinateur et tapez la commande suivante qui permet de lancer adb :
    ```sh
    $ adb shell
    ```
5. Afin de connaitre le nom de votre carte SD, tapez la commande suivante :
    ```sh
    $ sm list-disks
    ```

    ![adb list-disks][adb-list-disks]

    Dans mon cas, le nom est ```disk:179,64```.
6. Enfin, afin de fusionner les mémoires, tapez la commande suivante en mettant le nom de votre carte SD :
    ```sh
    $ sm partition disk:179,64 private
    ```

##### *Root* et *Recovery Custom*
Voici comment procéder pour un SM-G900F.

1. [Télécharger](https://api.lucien-brd.com/assets/documents/blogs/installer-kali-linux-nethunter-appareil-android-sm-g900f/Samsung_USB_Driver_v1.7.31.0.zip) et installer les *driver* USB samsung. 
2. [Télécharger](https://api.lucien-brd.com/assets/documents/blogs/installer-kali-linux-nethunter-appareil-android-sm-g900f/SM-G900F-6.0.1.zip) et extraire les fichiers pour le *root* et le *Recovery Custom*.
3. Activer :
   * Le mode développeur : Paramètres > A propos de l'appareil > Taper plusieurs fois sur le numéro de *build*
   * Le débogage USB : Paramètres > Options de développement > Débogage USB.
4. Eteindre votre téléphone.
   
###### *Rooter* le téléphone
1. Démarrer en mode *download*. 
 Appuyez simultanément sur **volume bas + home + power**
2. Ouvrir ```Odin3-v3.10.6.exe``` (fichier extrait lors de l'étape 2) et connecter votre téléphone à l'ordinateur.
3. Clicker sur **AP** et sélectionner le fichier ```CF-Auto-Root.tar``` (fichier extrait lors de l'étape 2).
4. Clicker sur *Start*.
5. Une fois que le message *Pass* s'affiche, vous pouvez déconnecter votre téléphone de votre ordinateur : il est *rooté*.

###### Installer un *Recovery Custom* TWRP
1. Démarrer en mode *download*. 
 Appuyez simultanément sur **volume bas + home + power**
2. Ouvrir ```Odin3-v3.10.6.exe``` (fichier extrait lors de l'étape 2) et connecter votre téléphone à l'ordinateur.
3. Clicker sur **AP** et sélectionner le fichier ```twrp-3.3.1-0-klte.img.tar``` (fichier extrait lors de l'étape 2). Assurez-vous d'avoir uniquement *Auto Reboot* et *F.Reset Time* de coché.
4. Clicker sur *Start*.
5. Une fois que le message *Pass* s'affiche, vous pouvez déconnecter votre téléphone de votre ordinateur : TWRP est installé.

##### L'image NetHunter

###### Télécharger une image déjà existante
Si vous trouvez une image NetHunter compatible avec votre appareil (attention à la version d'Android) via ce lien https://www.offensive-security.com/kali-linux-nethunter-download, il vous suffit de télécharger celle-ci (pas besoin de siuvre les étapes suivante de cette partie).

L'image pour un Samsung Galaxy S5 - SM-G900F, Android 6 - *Marshmallow*, ROM officielle *Touchwiz* est disponible [ici](https://api.lucien-brd.com/assets/documents/blogs/installer-kali-linux-nethunter-appareil-android-sm-g900f/update-nethunter-20201020_215800-klte-touchwiz-marshmallow.zip) (pas besoin de siuvre les étapes suivante de cette partie).

Si vous n'avez pas trouvé d'image compatible avec votre appareil tout n'est pas perdu.

###### Générer sa propre image
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

#### Installation

Afin d'installer l'image NetHunter, il faudra flasher celle-ci sur votre téléphone.

1. Copier l'image NetHunter (fichier zip) sur votre téléphone.
2. Eteindre votre téléphone. 
3. Démarer votre téléphone en mode *recovery*. 
Pour le s5 appuyez simultanément sur **volume haut + home + power**.
![twrp][twrp]
3. Faites un *backup* de votre configuration actuelle (optionnel).
4. Installez le fichier.
   ![install-zip][install-zip]

Si l'installation s'est bien déroulée, si vous ouvrez NetHunter App, le *Kernel Version* devrait être celui de Kali Linux NetHunter :
![kernel][kernel]

#### Configuration après installation

1. Ouvrez NetHunter App et allez dans *Kali Chroot Manager*. Téléchargez et installez *Kali Chroot* (faites attention de choisir la version compatible avec l'architecture de votre processeur).
2. Ouvrez NetHunter Store (F-Droid) et installez *Hacker Keyboard*.

#### En savoir plus
https://www.kali.org/docs/nethunter/
https://gitlab.com/kalilinux/nethunter/build-scripts/kali-nethunter-project
