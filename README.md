# FirstProject

Cyber Security Base - Course Project I

The task was to create a web application that has at least five different flaws from the OWASP top ten list.
So be aware, this is simple and bad code with many vulnerabilities!

This project is done with PHP in a LAMP environment. 
Here are the **installation instructions**;

1.	Download and install VirtualBox on your computer (which can be Windows, OS X or Linux); 
    * https://www.virtualbox.org/wiki/Downloads
2.	Download the “64 bit PC netinst.iso” Debian image from here; 
    * http://cdimage.debian.org/debian-cd/current/amd64/iso-cd/debian-8.7.1-amd64-netinst.iso
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
  * ``` a2enmod ssl ```
  * ``` a2ensite default-ssl ```
  * ``` service apache2 reload ```
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
  * Here you will also receive a certificate warning as the server is using a self-signed certificate for the https-pages. Ignore the warning and continue (in Firefox; Advanced/Add Execption)!

-----
### OWASP ZAP
* https://www.owasp.org/index.php/OWASP_Zed_Attack_Proxy_Project

Prepare:

1. In OWASP ZAP, take note of the proxy port number which can be seen from the "Tools / Options... / Local Proxy" menu.
2. In the browser, modify the proxy settings to match that port. The proxy server address should be 127.0.0.1.

And use it:

### A2

Log in to the Admin-pages, look who have signed up, and click the "home" link. You're now back at the starting page, which don't use SSL. But as you can see with OWASP ZAP, the session-cookie is still in use;

![Zap2](https://github.com/j0ly/hello-world/blob/master/zap2.png)


### A6

After entering the requested information and pressing Submit on the SignUp page, you will see the (imaginary) credit card number here;

![Zap1](https://github.com/j0ly/hello-world/blob/master/zap1.png)

-----

### Advanced Cookie Manager, for Firefox:
* https://addons.mozilla.org/en-US/firefox/addon/cookie-manager/

![acm](https://github.com/j0ly/hello-world/blob/master/acm.png)



