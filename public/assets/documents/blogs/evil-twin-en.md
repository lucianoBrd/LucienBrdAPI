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

> The systems, programs and methodologies in this tutorial are for educational and preventive purposes only. 
> You remain responsible for your actions and no responsibility will be taken for the misuse of the content taught.

The Evil Twin attack is a technique to capture the WPA key of a WiFi access point. 
First, by making this one unavailable. 
Then, by redirecting the connected clients to a fake access point controlled by the hacker and resembling the real access point, so that the clients enter the WPA key of the legitimate access point without being suspicious.

To carry out the attack, we will need two wifi network cards, one of which supports packet injection.
More precisely, a first wifi interface will be defined as an access point and the second as an attack interface to make the access point unavailable and copy its identity.
Then, the clients will be forcibly disconnected from the access point and as a false identical access point with no authentication will have been created, they will automatically reconnect without realizing anything.
Then DHCP will redirect them to a fake page, asking them to enter the WPA key.

To automate the attack, we will use WifiPhisher.

# Table of contents

1. Prerequisites
2. General Presentation
    1. Evil Twin Attack Presentation
    2. The WifiPhisher utility
3. Preparation of tools
    1. Download WifiPhisher
    2. Link custom pages to WifiPhisher
    3. Install WifiPhisher
4. The Evil Twin Attack
    1. The Attacker
    2. The victim
5. How to Avoid Evil Twin Attacks
6. Learn more
    1. Download Links
    2. Documentation

# 1. Prerequisites

* Having **Kali Linux**, you can use a virtual machine under **VirtualBox** for example.
* Have **two wifi network cards**, one of which supports **packet injection**. In this tutorial, I use two cards [Alfa Network AWUS036NH](https://www.amazon.fr/ALFA-Network-AWUS036NH-150Mbit-adaptateur/dp/B00358XUC4).

    ![AWUS036NH][AWUS036NH]

    Otherwise see the list of [Kali Linux compatible WiFi cards](https://www.kali-linux.fr/cartes-wifi-compatibles).

# 2. General Presentation

## 2.1. Evil Twin Attack Presentation

EvilTwin Attack Scenario :

* ![eviltwin][eviltwin]

1. The hacker first creates a fake wireless access point, in other words an AP and passes himself off as a legitimate Wi-Fi access point.
2. It then initiates a DDOS denial-of-service attack to or interferes with the legitimate Wi-Fi hotspot, which then disconnects wireless users.
3. The latter are then invited to inspect the available networks: this is when the trap closes, because once disconnected from the legitimate Wi-Fi access point, the hacker will force computers and offline devices to automatically reconnect to the evil twin, allowing the hacker to intercept all traffic via this device.

The technique is also known as:
* AP Phishing
* Wi-Fi Phishing
* Hotspotter
* Rogue AP
* Honeypot AP

These kinds of attacks make use of fake access points with fake connection pages to capture: users wifi credentials, credit card numbers or launch *Man in the Middle* attacks known as MITM and infect wireless network hosts.

## 2.2. The WifiPhisher utility

A Greek security researcher named George Chatzisofroniou has developed a wifi social engineering tool, which is designed to steal user identification information via secure wifi networks.

The tool is called WifiPhisher and has been published on [Github](https://github.com/wifiphisher/wifiphisher). However, there are many other hacking tools on Internet dedicated to hacking a secure wifi network. But WifiPhisher automates multiple Wi-Fi hacking techniques, differentiating itself from the others.

WifiPhisher implements the EvilTwin attack automatically, providing a web server, a DHCP and phishing pages ready to hack.

# 3. Preparation of tools

## 3.1. Download WifiPhisher

To download WifiPhisher, type the following command :
```sh
$ git clone https://github.com/wifiphisher/wifiphisher.git
```

You will find in ```wifiphisher/wifiphisher/data/phishing-pages```, the different pages *rigged* depending on the scenario (update, connection pages...).

However, these pages are in English, so not necessarily understandable by a French user and the design of these pages leaves something to be desired.

These pages should be considered as examples. It is best to avoid using them as they are, as they are not adapted to most situations encountered.

It is preferable to amend them so that they appear legitimate in the eyes of the victim. To do this, you have to take into account the ISP and the box model whose identity we are trying to usurp, as well as the language used by default in the country where you are.

## 3.2. Link custom pages to WifiPhisher

I have prepared pages for you ready to use pages for three main French ISPs: SFR, Bouygues and Orange. To retrieve them, you can [download them here](https://lucien-brd.com/download/Pages-main.zip) and extract the archive.

Here is an example of the Bouygues page. The SSID and Access Point Channel will be automatically updated based on the access point you choose:
* ![bouygues][bouygues]

You can modify the information present in the pages, so that it matches those of the victim (IP address, MAC address...).

Copy the folders present in```Pages-main``` in ```wifiphisher/wifiphisher/data/phishing-pages``` :
* ```Pages-main/bouygues```
* ```Pages-main/orange```
* ```Pages-main/sfr```

Your folder ```wifiphisher/wifiphisher/data/phishing-pages``` should look like this :

* ![phishing-pages][phishing-pages]

You will need to reinstall WifiPhisher each time you change the *phising* pages (see 3.3. Install WifiPhisher).

## 3.3. Install WifiPhisher

To install WifiPhisher, go to the previously downloaded folder (step 3.1. Download WifiPhisher) and type the following command :
```sh
$ sudo python3 setup.py install
```

# 4. The Evil Twin Attack

## 4.1. The Attacker

1. Connect the two wifi network cards to your computer. Connect it to your virtual machine if you use one.
2. Run WifiPhisher with the following command, in the folder downloaded above (step 3.1. Download WifiPhisher) :
    ```sh
    $ python3 bin/wifiphisher
    ```
    ![wifiphisher-start][wifiphisher-start]
3. Once the tool has launched, select the victim’s Wifi access point :
    ![wifiphisher-wifi][wifiphisher-wifi]
4. Select the *phising* page according to the victim :
    ![wifiphisher-phising][wifiphisher-phising]
5. Then, WifiPhisher will launch the fake access point and the WEB server :
    ![wifiphisher-starting][wifiphisher-starting]
6. Then, the tool will disconnect all users connected to the legitimate access point and make it unavailable :
    ![wifiphisher-ddos][wifiphisher-ddos]
7. Previously logged in users will automatically/manually reconnect to the evil twin :
    ![wifiphisher-connect][wifiphisher-connect]
8. The WifiPhisher DHCP will then redirect requests to the previously selected *phising* page. Once the victim has sent the WPA key, you will receive it directly on the console :
    ![wifiphisher-wpa][wifiphisher-wpa]
9. Here is a summary of the attack :
    ![wifiphisher-resume][wifiphisher-resume]

## 4.2. The victim

Here is what happens to the victim during the attack : 
* ![victim][victim]

# 5. How to Avoid Evil Twin Attacks

Companies that offer Wi-Fi to their employees or customers can use Wireless Intrusion Prevention (WIPS) systems to detect the presence of an Evil Twin attack and prevent employees and business customers from connecting to it.

* Always ask the facility for the name of the official hotspot. This will prevent you from making incorrect assumptions and choosing a malicious hotspot.
* Avoid connecting to Wi-Fi hotspots marked « Unsecure » (or « unsecured »), even if their SSID looks familiar.
* Only visit HTTPS websites, especially when they are on open networks. HTTPS websites offer end-to-end encryption. This makes it difficult – if not impossible – for hackers to see what you’re doing when you’re sailing.
* If the official hotspot you want to connect to has a key, try to intentionally type the wrong key. If the connection accepts the obviously wrong key, it is most likely an evil twin.
* Turn off « auto connect » or « auto join » for registered hotspots for all your wireless devices.
* Use a VPN whenever you connect to a public Wifi. This allows you to make sure that hackers can’t see your browsing habits.

# 6. Learn more

## 6.1. Download Links

* [wifiphisher](https://github.com/wifiphisher/wifiphisher.git)
* [Pages-main.zip](https://lucien-brd.com/download/Pages-main.zip)

## 6.2. Documentation

* https://wifiphisher.org/
* https://github.com/wifiphisher/wifiphisher/blob/master/README.md