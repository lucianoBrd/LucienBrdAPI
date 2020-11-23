[adb-list-disks]: https://api.lucien-brd.com/assets/images/blogs/sd-card/adb-list-disks.webp "adb list-disks"

Your phone has a slot to put a micro SD card that will increase this memory. On the other hand, its use is quickly restrictive at the level of content displacement. 
If your phone natively offers in the settings an option that allows to merge the two memories, you just have to activate it. 

Otherwise, here is how to proceed for a device running on **Android 6 minimum** (Android does not support it in previous versions).

# Table of contents

1. Prerequisites
2. Merge internal memory with SD card memory
3. Download Links

# 1. Prerequisites

1. [Download](https://api.lucien-brd.com/assets/documents/blogs/sd-card/adb-setup-1.4.3.exe) and install the ADB application for your computer.
2. Activate:
   * Developer Mode: Settings > About the device > Type several times on the *build* number.
   * USB debugging: Settings > Development Options > USB debugging.

# 2. Merge internal memory with SD card memory

1. Open a command prompt and go to the installation directory :
   ```sh
    $ cd \adb
    ```
2. Connect your phone to the computer and type the following command to launch adb :
    ```sh
    $ adb shell
    ```
3. To know the name of your SD card, type the following command :
    ```sh
    $ sm list-disks
    ```

    ![adb list-disks][adb-list-disks]

    In my case, the name is ```disk:179,64```.
4. Finally, in order to merge the memories, type the following command by putting the name of your SD card :
    ```sh
    $ sm partition disk:179,64 private
    ```

# 3. Download Links

* [adb-setup-1.4.3.exe](https://api.lucien-brd.com/assets/documents/blogs/sd-card/adb-setup-1.4.3.exe)