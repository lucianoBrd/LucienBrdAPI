[eviltwin]: https://api.lucien-brd.com/assets/documents/images/eviltwin/eviltwin.webp "eviltwin"

L'attaque Evil Twin technique permet de capturer la clé WPA d'un point d'accès Wifi.
Dans un premier temps en rendant insdiponible celui-ci.
Puis, en redirigeant les clients connectés vers un faux point d'accès contrôlé par le pirate ressemblant de toute pièce au vrai point d'accès, de tel sorte à ce que les clients saississent la clé WPA du point d'accès légitime sans se méfier.

# Table des matières

1. Prérequis
2. Présentation général
    1. Présentation de l'attaque Evil Twin
    2. L'utilitaire WifiPhisher
3. 

# 1. Prérequis

* Disposer de **Kali Linux**, vous pouvez utiliser une machine virtuelle sous **VirtualBox** par exemple
* Disposer de **deux cartes réseaux wifi**, dont une supportant **l'injection de paquet**, [cartes Wifi compatibles Kali Linux](https://www.kali-linux.fr/cartes-wifi-compatibles). Dans ce tutoriel, j'utilise deux cartes 

# 2. Présentation général

## 2.1. Présentation de l'attaque Evil Twin

Scénario d'attaque EvilTwin :

![eviltwin][eviltwin]

1. Le pirate créé d'abord un faux point d'accès sans fil, autrement dit un AP et se fait passer pour un point d'accès wifi légitime.
2. Il déclenche ensuite une attaque par dénis de service DDOS entre le point d'accès wifi légitime ou créé des interférences autour de ce dernier qui déconnecte alors les utilisateurs sans fil.
3. Ces derniers sont ensuite invité à inspecter les réseaux disponible et c'est la que le piège se referme car un fois déconnecté du point d'accès wifi légitime, le pirate va forcer les ordinateurs et périphériques hors ligne pour qu'ils se reconnectent automatiquement au jumeau maléfique permettant au pirate d'intercépter tout le trafic via ce dispositif.

La technique est également connu comme :
* AP Phishing
* Wi-Fi Phishing
* Hotspotter
* Rogue AP
* Honeypot AP

Ce genres d'attaques font usage de faux points d'accès avec des pages de connection trucés pour capturer les informations d'identification wifi des utilisateurs, numéro de cartes de crédit ou encore lancer des attaques *Man in the Middle* connu sous le nom de MITM et infecter les hôtes du réseau sans fil.

Pour réaliser l'attaque, nous aurons besoin de deux cartes réseaux wifi, dont une supportant l'injection de paquet.
Plus précisément, une première interface wifi sera défini comme point d'accès et la seconde comme interface d'attaque pour rendre indisponible le point d'accès et copier son identité.
Ensuite, les clients seront déconnectés de force du point d'accès et comme un faux point d'accès identique ne disposant pas d'authentification aura été créé, ils se reconnecteront automatiquement sans se rendre compte de rien.
Ensuite, le DHCP les redirigera vers une fausse page, leur demandant de saisir la clé WPA (suite à une mise à jour par exemple).

## 2.2. L'utilitaire WifiPhisher

Un chercheur en sécurité Grec nommé George Chatzisofroniou a développé un outils d'ingiéneurie social wifi qui est conçu pour voler les informations d'identification des utilisateurs via des réseaux wifi sécurisés.

L'outils est baptisé WifiPhisher et a été publié sur [Github](https://github.com/wifiphisher/wifiphisher). Cependant, il existe de nombreux autre outils de hacking sur Internet dédiés au piratage d'un réseau sécurisé wifi. Mais WifiPhisher automatise de multiple technique de piratage wifi qui fait qu'il se démarque des autres.

WifiPhisher implémente l'attaque EvilTwin de manière automatique en fournissant un serveur WEB, un DHCP et des pages de phishing toute prête pour le hacker.



Pour automatiser l'attaque, nous allons utiliser WifiPhisher.

```sh
$ git clone https://github.com/wifiphisher/wifiphisher.git
$ cd wifiphisher
$ sudo python setup.py install
```

Les systèmes, programmes et méthodologies de ce tutoriel sont utilisés à but éducatif et préventif uniquement. 
Vous restez les responsables de vos actions et aucune responsabilité ne sera engagée quant à la mauvaise utilisation du contenu enseigné. 