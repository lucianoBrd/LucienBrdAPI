[eviltwin]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/eviltwin.webp "eviltwin"
[AWUS036NH]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/AWUS036NH.webp "AWUS036NH"
[bouygues]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/bouygues.webp "bouygues"
[phishing-pages]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/phishing-pages.webp "phishing-pages"
[wifiphisher-start]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/wifiphisher-start.webp "wifiphisher-start"
[wifiphisher-wifi]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/wifiphisher-wifi.webp "wifiphisher-wifi"
[wifiphisher-phising]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/wifiphisher-phising.webp "wifiphisher-phising"
[wifiphisher-starting]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/wifiphisher-starting.webp "wifiphisher-starting"
[wifiphisher-ddos]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/wifiphisher-ddos.webp "wifiphisher-ddos"
[wifiphisher-connect]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/wifiphisher-connect.webp "wifiphisher-connect"
[wifiphisher-wpa]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/wifiphisher-wpa.webp "wifiphisher-wpa"
[wifiphisher-resume]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/wifiphisher-resume.gif "wifiphisher-resume"
[victim]: https://api.lucien-brd.com/assets/images/blogs/evil-twin/victim.gif "victim"

> Les systèmes, programmes et méthodologies de ce tutoriel sont utilisés à but éducatif et préventif uniquement. 
> Vous restez les responsables de vos actions et aucune responsabilité ne sera engagée quant à la mauvaise utilisation du contenu enseigné.

L'attaque Evil Twin est une technique permettant de capturer la clé WPA d'un point d'accès Wifi.
Dans un premier temps, en rendant indisponible celui-ci.
Puis, en redirigeant les clients connectés vers un faux point d'accès contrôlé par le pirate et ressemblant de toute pièce au vrai point d'accès, pour que les clients saisissent la clé WPA du point d'accès légitime sans se méfier.

Pour réaliser l'attaque, nous aurons besoin de deux cartes réseaux wifi, dont une supportant l'injection de paquet.
Plus précisément, une première interface wifi sera définie comme point d'accès et la seconde comme interface d'attaque pour rendre indisponible le point d'accès et copier son identité.
Ensuite, les clients seront déconnectés de force du point d'accès et comme un faux point d'accès identique ne disposant pas d'authentification aura été créé, ils se reconnecteront automatiquement sans se rendre compte de rien.
Ensuite, le DHCP les redirigera vers une fausse page, leur demandant de saisir la clé WPA.

Pour automatiser l'attaque, nous allons utiliser WifiPhisher. 

# Table des matières

1. Prérequis
2. Présentation générale
    1. Présentation de l'attaque Evil Twin
    2. L'utilitaire WifiPhisher
3. Préparation des outils
    1. Télécharger WifiPhisher
    2. Associer des pages personnalisées à WifiPhisher
    3. Installer WifiPhisher
4. L'attaque Evil Twin
    1. L'attaquant
    2. La victime
5. Comment éviter les attaques Evil Twin
6. En savoir plus
    1. Liens de téléchargement
    2. Documentation

# 1. Prérequis

* Disposer de **Kali Linux**, vous pouvez utiliser une machine virtuelle sous **VirtualBox** par exemple.
* Disposer de **deux cartes réseaux wifi**, dont une supportant **l'injection de paquet**. Dans ce tutoriel, j'utilise deux cartes [Alfa Network AWUS036NH](https://www.amazon.fr/ALFA-Network-AWUS036NH-150Mbit-adaptateur/dp/B00358XUC4).

    ![AWUS036NH][AWUS036NH]

    Sinon voir la liste des [cartes Wifi compatibles Kali Linux](https://www.kali-linux.fr/cartes-wifi-compatibles).

# 2. Présentation générale

## 2.1. Présentation de l'attaque Evil Twin

Scénario d'attaque EvilTwin :

* ![eviltwin][eviltwin]

1. Le pirate créé d'abord un faux point d'accès sans fil, autrement dit un AP et se fait passer pour un point d'accès wifi légitime.
2. Il déclenche ensuite une attaque par déni de service DDOS vers le point d'accès wifi légitime ou il crée des interférences autour de ce dernier, qui déconnectent alors les utilisateurs sans fil.
3. Ces derniers sont ensuite invités à inspecter les réseaux disponibles : c'est la que le piège se referme, car une fois déconnecté du point d'accès wifi légitime, le pirate va forcer les ordinateurs et périphériques hors ligne à se reconnecter automatiquement au jumeau maléfique, permettant au pirate d'intercepter tout le trafic via ce dispositif.

La technique est également connu comme :
* AP Phishing
* Wi-Fi Phishing
* Hotspotter
* Rogue AP
* Honeypot AP

Ces genres d'attaques font usage de faux points d'accès avec des pages de connection truquées pour capturer : les informations d'identification wifi des utilisateurs, les numéros de cartes de crédit ou encore lancer des attaques *Man in the Middle* connu sous le nom de MITM et infecter les hôtes du réseau sans fil.

## 2.2. L'utilitaire WifiPhisher

Un chercheur en sécurité Grec nommé George Chatzisofroniou a développé un outils d'ingiéneurie social wifi, qui est conçu pour voler les informations d'identification des utilisateurs via des réseaux wifi sécurisés.

L'outil est baptisé WifiPhisher et a été publié sur [Github](https://github.com/wifiphisher/wifiphisher). Cependant, il existe de nombreux autres outils de hacking sur Internet dédiés au piratage d'un réseau sécurisé wifi. Mais WifiPhisher automatise de multiples techniques de piratage wifi, se démarquant ainsi des autres.

WifiPhisher implémente l'attaque EvilTwin de manière automatique, en fournissant un serveur WEB, un DHCP et des pages de phishing toutes prêtes pour le hacker.

# 3. Préparation des outils

## 3.1. Télécharger WifiPhisher

Pour télécharger WifiPhisher, taper la commande suivante :
```sh
$ git clone https://github.com/wifiphisher/wifiphisher.git
```

Vous trouverez dans ```wifiphisher/wifiphisher/data/phishing-pages```, les différentes pages *truquées* selon le scénario (mise à jour, pages de connection...). 

En revanche, ces pages sont en anglais, donc pas forcément compréhensibles par un utilisateur francais et le design de ces pages laisse à désirer.

Il faut considérer ces pages comme des exemples. Il vaut mieux éviter de les utiliser telles quelles, car elles ne sont pas adaptées à la plupart des situations rencontrées. 

Il est préférable de les modifier, afin qu'elles paraissent légitimes aux yeux de la victime. Pour cela, il faut prendre en considération le FAI et le modèle de la box dont nous essayons d'usurper l'identité, ainsi que la langue utilisée par défaut dans le pays ou vous vous trouvez. 

## 3.2. Associer des pages personnalisées à WifiPhisher

J'ai confectionné pour vous des pages toutes prêtes pour trois principaux FAI francais : SFR, Bouygues et Orange. Pour les récupérer, vous pouvez les [télécharger ici](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/PhishingPages-main.zip) et extraire l'archive.

Voici un exemple de la page Bouygues. Le SSID et le Canal du point d'accès seront automatiquement mis à jour en fonction du point d'accès que vous aurez choisi :
* ![bouygues][bouygues]

Vous pouvez modifier les informations présentes dans les pages, afin qu'elles concordent avec celles de la victime (adresse IP, adresse MAC...).

Copier les dossiers présents dans ```PhishingPages-main``` dans ```wifiphisher/wifiphisher/data/phishing-pages``` :
* ```PhishingPages-main/bouygues```
* ```PhishingPages-main/orange```
* ```PhishingPages-main/sfr```

Votre dossier ```wifiphisher/wifiphisher/data/phishing-pages``` devrait ressembler à cela :

* ![phishing-pages][phishing-pages]

Il faudra réinstaller WifiPhisher à chaque fois que vous modifiez les pages de *phising* (voir 3.3. Installer WifiPhisher).

## 3.3. Installer WifiPhisher

Pour installer WifiPhisher, rendez-vous dans le dossier téléchargé précedemment (étape 3.1. Télécharger WifiPhisher) et taper la commande suivante :
```sh
$ sudo python3 setup.py install
```

# 4. L'attaque Evil Twin

## 4.1. L'attaquant

1. Brancher les deux cartes réseaux wifi à votre ordianateur. Connecter celle-ci à votre machine virtuelle si vous en utilisez une.
2. Lancer WifiPhisher avec la commande suivante, en étant dans le dossier téléchargé précedemment (étape 3.1. Télécharger WifiPhisher) :
    ```sh
    $ python3 bin/wifiphisher
    ```
    ![wifiphisher-start][wifiphisher-start]
3. Une fois que l'outil s'est lancé, séléctionner le point d'accès Wifi de la victime :
    ![wifiphisher-wifi][wifiphisher-wifi]
4. Séléctionner la page de *phising* en fonction de la victime :
    ![wifiphisher-phising][wifiphisher-phising]
5. Puis, WifiPhisher va lancer le faux point d'accès et le serveur WEB :
    ![wifiphisher-starting][wifiphisher-starting]
6. Ensuite, l'outil va déconnecter tous les utilisateurs connecté au point d'accès légitime et rendre indisponible celui-ci :
    ![wifiphisher-ddos][wifiphisher-ddos]
7. Les utilisateurs précédemment connectés vont se reconnecter automatiquement / manuellement au jumeau maléfique :
    ![wifiphisher-connect][wifiphisher-connect]
8. Le DHCP de WifiPhisher va alors rediriger les requêtes vers la page de *phising* précédemment choisie. Une fois que la victime aura envoyé la clé WPA, vous la recevrez directement sur la console  :
    ![wifiphisher-wpa][wifiphisher-wpa]
9. Voici un résumé de l'attaque :
    ![wifiphisher-resume][wifiphisher-resume]

## 4.2. La victime

Voici ce qui se passe du côté de la vitime lors de l'attaque : 
* ![victim][victim]

# 5. Comment éviter les attaques Evil Twin

Les entreprises qui offrent la connexion Wifi à leurs employés ou à leurs clients, peuvent utiliser des systèmes de prévention des intrusions sans fil (WIPS) afin de détecter la présence d’une attaque Evil Twin et empêcher les employés et les clients des entreprises de s’y connecter.

* Demander toujours à l’établissement quel est le nom du hotspot officiel. Cela vous évitera de faire des suppositions incorrectes et de choisir un hotspot malveillant.
* Éviter de vous connecter à des points d’accès Wifi qui portent la mention « Unsecure » (ou « non sécurisé »), même s’ils leur SSID vous semble familier.
* Ne visiter que les sites web HTTPS, surtout lorsqu’ils se trouvent sur des réseaux ouverts. Les sites web HTTPS offrent un chiffrement de bout en bout. Ceci rend difficile – voire impossible – pour les pirates de voir ce que vous faites lorsque vous naviguez.
* Si le hotspot officiel auquel vous voulez vous connecter a une clé, essayez de taper intentionnellement la mauvaise clé. Si la connexion accepte la clé manifestement erronée, il s’agit très probablement d’un jumeau maléfique.
* Désactiver les fonctions « auto connect » ou « auto join » pour les hotspots enregistrés pour tous vos appareils sans fil.
* Utilisez un VPN chaque fois que vous vous connectez à un Wifi public. Ceci vous permet de vous assurer que les pirates ne puissent pas voir vos habitudes de navigation.

# 6. En savoir plus

## 6.1. Liens de téléchargement

* [wifiphisher](https://github.com/wifiphisher/wifiphisher.git)
* [PhishingPages-main.zi](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/PhishingPages-main.zip)

## 6.2. Documentation

* https://wifiphisher.org/
* https://github.com/wifiphisher/wifiphisher/blob/master/README.md