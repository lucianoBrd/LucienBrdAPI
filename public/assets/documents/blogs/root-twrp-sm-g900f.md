[twrp]: https://api.lucien-brd.com/assets/images/blogs/root-twrp-sm-g900f/twrp.webp "twrp"

Équivalent du *jailbreak* sur iPhone, l'idée de rooter son téléphone c'est d'accéder à **un contrôle complet de l'appareil**. Les principaux usages qui peuvent venir en tête sont la suppression d'applications installées par le fabricant / l'opérateur, l'accélération de la machine, installer une ROM spécifique ou encore pirater des jeux.

Les bénéfices potentiels que vous pouvez tirer d'un root de votre smartphone valent le coup de s'y pencher. Si on pense souvent avoir le contrôle complet de son appareil, dans les faits, de nombreuses fonctions restent très limitées.

Par exemple, les fabricants ou les opérateurs installent souvent leurs propres applications qu'il est impossible de retirer sans avoir les droits administrateurs. Cela vous permet ainsi de **nettoyer vraiment votre téléphone et de gagner de l'espace de stockage**.

Vous pouvez aussi faire un *overclock*. Cela consiste à augmenter la fréquence de l'horloge du processeur pour que votre téléphone aille plus vite. On peut aussi signaler la possibilité d'installer une ROM spécifique et ainsi ne pas rester bloqué sur le modèle installé de base. Vous aurez ainsi accès à des systèmes plus personnalisés et poussés.

Le *Recovery* est la barrière qui permet d’activer le *root*, d’installer un *kernel* modifié, une ROM modifiée, un thème, un mod (overclock ou autres modifications profondes liées au système), d’effacer la mémoire interne ou celle de la carte SD, et plus encore… Il existe bien certains recovery originaux qui permettent d’entreprendre certaines de ses possibilités, mais ils demeurent tout de même très rares. Pour étendre les possibilités de son terminal, la meilleure façon est d’employer un recovery modifié !

Parmi les *recovery* personnalisés disponibles, on retrouve notamment **TeamWin Recovery Project**. Depuis plusieurs années maintenant, l’équipe TWRP nous propose une solution stable qui se décline sur une multitude de terminaux. En plus d’offrir un support du tactile, TWRP propose des fonctionnalités avancées pour installer une ROM Custom (à partir de son fichier source), effacer un système, sauvegarder et restaurer ses données, mais aussi le paramétrer et accéder à des options avancées.

Voici comment procéder pour un SM-G900F.

# Table des matières

1. Prérequis
2. *Rooter* le téléphone
3. Installer un *Recovery Custom* TWRP
4. Liens de téléchargement

# 1. Prérequis

1. [Télécharger](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/Samsung_USB_Driver_v1.7.31.0.zip) et installer les *driver* USB samsung.
2. [Télécharger](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/SM-G900F-6.0.1.zip) et extraire les fichiers pour le *root* et le *Recovery Custom*.
3. Activer :
   * Le mode développeur : Paramètres > A propos de l'appareil > Taper plusieurs fois sur le numéro de *build*
   * Le débogage USB : Paramètres > Options de développement > Débogage USB.
4. Sauvegardez vos données.
5. Eteindre votre téléphone.
6. Assurez vous d'avoir une batterie chargée (75% minimum).

# 2. *Rooter* le téléphone
1. Démarrer en mode *download*.
 Appuyez simultanément sur **volume bas + home + power**
2. Ouvrir ```Odin3-v3.10.6.exe``` (fichier extrait lors de l'étape 2) et connecter votre téléphone à l'ordinateur.
3. Clicker sur **AP** et sélectionner le fichier ```CF-Auto-Root.tar``` (fichier extrait lors de l'étape 2).
4. Clicker sur *Start*.
5. Une fois que le message *Pass* s'affiche, vous pouvez déconnecter votre téléphone de votre ordinateur : il est *rooté*.

Si l'installation s'est bien déroulée, l'application SuperSU devrait être installée sur votre téléphone.

# 3. Installer un *Recovery Custom* TWRP
1. Démarrer en mode *download*.
 Appuyez simultanément sur **volume bas + home + power**
2. Ouvrir ```Odin3-v3.10.6.exe``` (fichier extrait lors de l'étape 2) et connecter votre téléphone à l'ordinateur.
3. Clicker sur **AP** et sélectionner le fichier ```twrp-3.3.1-0-klte.img.tar``` (fichier extrait lors de l'étape 2). Assurez-vous d'avoir uniquement *Auto Reboot* et *F.Reset Time* de coché.
4. Clicker sur *Start*.
5. Une fois que le message *Pass* s'affiche, vous pouvez déconnecter votre téléphone de votre ordinateur : TWRP est installé.

Si l'installation s'est bien déroulée, si vous démarer votre téléphone en mode *recovery*, appuyez simultanément sur **volume haut + home + power**, l'écran suivant devrait s'afficher.

![twrp][twrp]

# 4. Liens de téléchargement
* [Samsung_USB_Driver_v1.7.31.0.zip](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/Samsung_USB_Driver_v1.7.31.0.zip)
* [SM-G900F-6.0.1.zip](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/SM-G900F-6.0.1.zip)