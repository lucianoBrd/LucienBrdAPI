[twrp]: https://api.lucien-brd.com/assets/images/blogs/root-twrp-sm-g900f/twrp.webp "twrp"

Equivalent to jailbreak on iPhone, the idea of rooting your phone is to access **complete control of the device**. The main uses that can come to mind are the removal of applications installed by the manufacturer/operator, the acceleration of the machine, install a specific ROM or even hack games.

The potential benefits you can derive from a root from your smartphone are worth looking into. Although we often think we have complete control over our device, in fact, many functions remain very limited.

For example, manufacturers or operators often install their own applications that cannot be removed without having administrator rights. This allows you to **really clean your phone and save storage space**.

You can also do a *overclock*. This consists of increasing the frequency of the processor clock so that your phone goes faster. One can also point out the possibility of installing a specific ROM and thus not stuck on the basic installed model. This will give you access to more personalized and advanced systems.

The *Recovery* is the barrier to enable *root*, install a modified *kernel*, a modified ROM, theme, mod (overclock or other system-related deep changes), erase internal memory or SD card memory, and more… There are some original recoveries that make it possible to undertake some of its possibilities, but they are still very rare. To extend the possibilities of its terminal, the best way is to use a modified recovery !

**TeamWin Recovery Project** is one of the available custom recovery tools. For several years now, the TWRP team has been offering us a stable solution that is available on a multitude of terminals. In addition to providing touch support, TWRP offers advanced features to install a Custom ROM (from its source file), erase a system, backup and restore its data, but also set it up and access advanced options.

Here is how to proceed for a SM-G900F.

# Table of contents

1. Prerequisites
2. *Root* the phone
3. Install a *Custom Recover* TWRP
4. Download Links

# 1. Prerequisites

1. [Download](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/Samsung_USB_Driver_v1.7.31.0.zip) and install the Samsung USB *drivers*.
2. [Download](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/SM-G900F-6.0.1.zip) and extract files for *root* and *Custom Recovery*.
3. Activate:
   * Developer Mode: Settings > About the device > Type several times on the *build* number.
   * USB debugging: Settings > Development Options > USB debugging.
4. Back up your data.
5. Turn off your phone.
6. Make sure you have a charged battery (75% minimum).

# 2. *Root* the phone
1. Start in *download* mode.
   Simultaneously press **low volume + home + power**
2. Open ```Odin3-v3.10.6.exe``` (file extracted in step 2) and connect your phone to the computer.
3. Click on **AP** and select the file ```CF-Auto-Root.tar``` (file extracted in step 2).
4. Click on *Start*.
5. Once the *Pass* message appears, you can disconnect your phone from your computer : it is *rooted*.

If the installation went well, the SuperSU application should be installed on your phone.

# 3. Install a *Custom Recover* TWRP
1. Start in *download* mode.
   Simultaneously press **low volume + home + power**
2. Open ```Odin3-v3.10.6.exe``` (file extracted in step 2) and connect your phone to the computer.
3. Click on **AP** and select the file ```twrp-3.3.1-0-klte.img.tar``` (file extracted in step 2). Make sure you only have *Auto Reboot* and *F.Reset Time* checked.
4. Click on *Start*.
5. Once the *Pass* message appears, you can disconnect your phone from your computer : TWRP is installed.

If the installation went smoothly, if you start your phone in *recovery* mode, simultaneously press **high volume + home + power**, the following screen should appear :

* ![twrp][twrp]

# 4. Liens de téléchargement
* [Samsung_USB_Driver_v1.7.31.0.zip](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/Samsung_USB_Driver_v1.7.31.0.zip)
* [SM-G900F-6.0.1.zip](https://api.lucien-brd.com/assets/documents/blogs/root-twrp-sm-g900f/SM-G900F-6.0.1.zip)