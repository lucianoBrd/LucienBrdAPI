[build.py-h]: https://api.lucien-brd.com/assets/images/blogs/kali-nethunter/build.py-h.webp "build.py -h result"
[install-zip]: https://api.lucien-brd.com/assets/images/blogs/kali-nethunter/install-zip.webp "installer zip"
[twrp]: https://api.lucien-brd.com/assets/images/blogs/kali-nethunter/twrp.webp "twrp"
[kernel]: https://api.lucien-brd.com/assets/images/blogs/kali-nethunter/kernel.webp "kernel"

This tutorial will allow you to install Kali Linux NetHunter on a compatible Android device (Samsung Galaxy S5 - SM-G900F in the tutorial) :
* Specific *Kernel* to NetHunter
* Overlay with NetHunter tools and applications

Kali NetHunter is a free and open-source mobile penetration testing platform for Android devices, based on Kali Linux. 
The main tools provided are:
* Kali Linux container that includes all tools and applications provided by Kali Linux (with a terminal emulator)
* Kali NetHunter App which includes additional tools and services (*HID Keyboard Attacks*, *BadUSB attacks*, *Evil AP MANA attacks*, etc...)
* Kali NetHunter Store to install security applications and tools
* Kali NetHunter Desktop Experience (KeX) to run full Kali Linux desktop sessions on a screen (via HDMI or *screen casting*)

# Table of contents

1. Prerequisites
2. The NetHunter image
    1. Download an existing image
    2. Generate your own image
3. Installation
4. Configuration after installation
5. Learn more
    1. Download Links
    2. Documentation

# 1. Prerequisites

Before any manipulation, I invite you to check that your device is compatible (see 2. The NetHunter image).

* Make sure you have a charged battery (75% minimum).
* Have at least 9 GB of storage available (see [Increase storage of an Android device - Merge memory](https://www.lucien-brd.com/blog/increase-storage-android-device-merge-memory)).  
* Have a *rooted* phone with a *Custom Recovery* (see [Root and install a Custom Recovery TWRP for Samsung Galaxy S5 - SM-G900F](https://www.lucien-brd.com/blog/root-install-custom-recovery-twrp-sm-g900f)).
* Have the NetHunter image compatible with your phone (see 2. The NetHunter image).

# 2. The NetHunter image

## 2.1. Download an existing image
If you find a NetHunter image compatible with your device (watch out for the Android version) via this link https://www.offensive-security.com/kali-linux-nethunter-download, you just need to download it (no need to work the next steps of this part).

The image for a Samsung Galaxy S5 - SM-G900F, Android 6 - *Marshmallow*, official ROM *Touchwiz* is available [here](https://api.lucien-brd.com/assets/documents/blogs/kali-nethunter/update-nethunter-20201020_215800-klte-touchwiz-marshmallow.zip) (no need to work the next steps of this part).

If you have not found an image compatible with your device, everything is not lost.

## 2.2. Generate your own image
1. First, you will need to download the project :
    ```sh
    $ git clone https://gitlab.com/kalilinux/nethunter/build-scripts/kali-nethunter-project.git
    ```

2. Then go to the project folder ```nethunter-installer``` in order to *build* it :
    ```sh
    $ cd kali-nethunter/nethunter-installer
    $ ./bootstrap.sh
    ```

3. If all is well, you should be able to execute the following command (in the folder ```nethunter-installer```) :
    ```sh
    $ python3 build.py -h
    ```

    ![build.py -h résultat][build.py-h]

    As you can see, the list of compatible Android devices and versions is displayed.

4. Finally you need to generate the NetHunter image. If you have installed a *custom* ROM, check in the *device* list that there is no specific version for it.
    In the case of a Samsung Galaxy S5 - SM-G900F, Android 6 - *Marshmallow*, official ROM *Touchwiz*, the command is ( in the folder ```nethunter-installer```) :
    ```sh
    $ python3 build.py -d klte-touchwiz -m
    ```
    The image will be created in the folder ```nethunter-installer``` in zip format.
    This is the zip file you will need to flash your device.

# 3. Installation

In order to install the NetHunter image, you will need to flash it on your phone.

1. Copy the NetHunter image (zip file) to your phone.
2. Turn off your phone.
3. Start your phone in *recovery* mode.
    For S5, simultaneously press **high volume + home + power**.
    ![twrp][twrp]
3. Make a *backup* of your current configuration (optional).
4. Install the file. ![install-zip][install-zip]

If the installation went well, if you open NetHunter App, the *Kernel Version* should be the Kali Linux NetHunter :

* ![kernel][kernel]

# 4. Configuration after installation

1. Open NetHunter App and go to *Kali Chroot Manager*. Download and install *Kali Chroot* (be careful to choose the version compatible with your processor architecture).
2. Open NetHunter Store (F-Droid) and install *Hacker Keyboard*.

# 5. Learn more

## 5.1. Download Links

* [update-nethunter-20201020_215800-klte-touchwiz-marshmallow.zip](https://api.lucien-brd.com/assets/documents/blogs/kali-nethunter/update-nethunter-20201020_215800-klte-touchwiz-marshmallow.zip)

## 5.2. Documentation

* https://www.kali.org/docs/nethunter/
* https://gitlab.com/kalilinux/nethunter/build-scripts/kali-nethunter-project
