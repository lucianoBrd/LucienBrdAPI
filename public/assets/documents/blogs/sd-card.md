[adb-list-disks]: https://api.lucien-brd.com/assets/documents/images/sd-card/adb-list-disks.webp "adb list-disks"

## 1.1. Augmenter le stockage de l'appareil

Votre téléphone possède un slot pour mettre une carte micro SD qui va permettre d’augmenter cette mémoire. En revanche son utilisation est vite restrictive niveau déplacement du contenu.
Si votre téléphone propose nativement dans les paramètres une option qui permet de fusionner les deux mémoires, il vous suffit de l'activer.

Sinon, voici comment procéder pour un appareil sous **Android 6 minimum** (Android ne le prend pas en charge dans les versions précedente).

# Table des matières

1. Prérequis
2. Fusionner la mémoire interne avec la mémoire de la carte SD
3. Liens de téléchargement

# 1. Prérequis

1. [Télécharger](https://api.lucien-brd.com/assets/documents/blogs/sd-card/adb-setup-1.4.3.exe) et installer l’application ADB pour votre ordinateur.
2. Activer :
   * Le mode développeur : Paramètres > A propos de l'appareil > Taper plusieurs fois sur le numéro de *build*
   * Le débogage USB : Paramètres > Options de développement > Débogage USB.

# 2. Fusionner la mémoire interne avec la mémoire de la carte SD

1. Ouvrir une invite de commande et allez dans le répertoire d'installation :
   ```sh
    $ cd \adb
    ```
2. Connecter votre téléphone à l'ordinateur et tapez la commande suivante qui permet de lancer adb :
    ```sh
    $ adb shell
    ```
3. Afin de connaitre le nom de votre carte SD, tapez la commande suivante :
    ```sh
    $ sm list-disks
    ```

    ![adb list-disks][adb-list-disks]

    Dans mon cas, le nom est ```disk:179,64```.
4. Enfin, afin de fusionner les mémoires, tapez la commande suivante en mettant le nom de votre carte SD :
    ```sh
    $ sm partition disk:179,64 private
    ```

# 3. Liens de téléchargement

* [adb-setup-1.4.3.exe](https://api.lucien-brd.com/assets/documents/blogs/sd-card/adb-setup-1.4.3.exe)