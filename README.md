# FirstProject

Cyber Security Base - Course Project I

The task was to create a web application that has at least five different flaws from the OWASP top ten list.
So be aware, this is simple and bad code with many vulnerabilities!

This project is done with PHP in a LAMP environment. 
Here are the **installation instructions**;

1.	Download and install VirtualBox on your computer (which can be Windows, OS X, Linux or Solaris); https://www.virtualbox.org/wiki/Downloads
2.	Download the “64 bit PC netinst.iso” Debian image from here; https://www.debian.org/distrib/
3.	Start Virtualbox and select “Machine / New…” from the menu.
4.	Give the new virtual machine a name and select “Linux” as Type, and “Debian (64-bit)” as Version. Continue and accept the default settings until finished.
5.	Right click the newly created virtual machine and select “Settings…”
   * From “Network”, change “Attached to” = “Bridged Adapter” 
   * From “Storage”, highlight the CD under “Controller: IDE”. From “Attributes” klick the CD-image and “Choose Virtual Optical Disk File…”. Find the Debian image and attach it.
8.	Start the virtual machine.


Debian installation:

1.	Inside the virtual machine, choose “Install” when Debian has started.
2.	Select your language, location, locales and keyboard.
3.	Enter hostname, domain name, root password and your personal user credentials of your own choosing. 
4.	Partition the disk using the “Guided – use entire disk” alternative. Continue with the default values and suggestions, until you receive the “Write the changes to disk?” prompt. Then choose “Yes”!
5.	When configuring the package manager, choose the default values, and leave the proxy setting empty (unless you know it’s needed).
6.	Choose whether you want to participate in the package usage survey or not.
7.	Software to install: “web server” and “standard system utilities” (nothing else is needed).
8.	Install the GRUB boot loader on the master boot record, and choose “/dev/sda” in the next window.
9.	Finish the installation. 


Project installation:

1.	Log in as root when the virtual machine has rebooted.
2.	Run “ifconfig” to see the IP-number of the virtual machine (eth0, inet addr: x.x.x.x).
3.	Run the following commands inside the virtual machine:
  * ``` aptitude install mysql-server mysql-client ``` - enter a root password for MySQL!
  * ``` aptitude install php5 php5-mysql libapache2-mod-php5 ```
  * ``` aptitude install git ```
  * ``` cd /var/www/html/ ```
  * ``` git init ```
  * ``` git clone https://github.com/j0ly/firstproject.git ```
  * ``` nano firstproject/admin/config.ini ``` - change the password to match your MySQL root password!
  * ``` reboot ```
4.  Open http://yourserver/firstproject/admin/createdb.php in the browser, from the host*, to create the database (yourserver = the IP from step 2).

*) host = the computer/os running the VirtualBox virtual machine

### How to use:

* Open http://yourserver/firstproject/ in a browser, from the host.
* Sign-up some imaginary persons to the imaginary event, using imaginary credit-card numbers (no checking is done).
* Take note of the ticket-number if you want to test cancelling the sign-up.
* On the Admin page you can get a list of the people who have signed-up.
  * The credentials are: **admin/password**

-----
### OWASP ZAP
Usage instructions:
1. Start OWASP ZAP and check the proxy port from the "Tools / Options... / Local Proxy" menu.
2. Start the browser and modify the proxy settings to match that port. The proxy server address should be 127.0.0.1.

-----
### Links

#### OWASP ZAP:
* https://www.owasp.org/index.php/OWASP_Zed_Attack_Proxy_Project

#### Advanced Cookie Manager, for Firefox:
* https://addons.mozilla.org/en-US/firefox/addon/cookie-manager/

#### How to activate SSL:
* https://debian-administration.org/article/349/Setting_up_an_SSL_server_with_Apache2
 
<br>

#### For general instructions on how to improve software security, see:
* https://www.owasp.org/images/0/08/OWASP_SCP_Quick_Reference_Guide_v2.pdf

#### Regarding credit cards, there are many requirements:
* https://en.wikipedia.org/wiki/Payment_Card_Industry_Data_Security_Standard
* https://www.pcisecuritystandards.org/pci_security/how

#### OWASP PHP Security Cheat Sheet: 
* https://www.owasp.org/index.php/PHP_Security_Cheat_Sheet

#### PSP security manual:
* http://php.net/manual/en/security.php

#### PHP security considerations in shared hosting environment:
* http://www.hostreview.com/blog/Technical_Support/articles/PHPSecurityinSharedEnvironment.html




