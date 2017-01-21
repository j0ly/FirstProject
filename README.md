# FirstProject

Cyber Security Base - Course Project I

A web application that has at least five different flaws from the OWASP top ten list! 

This project is done with PHP in a LAMP environment. 
Here are the installation instructions (just an example, other kind of LAMP environment will probably work too);

1)	Download and install VirtualBox; https://www.virtualbox.org/wiki/Downloads
2)	Download the “64 bit PC netinst.iso” Debian image from here; https://www.debian.org/distrib/
3)	Start Virtualbox and select “Machine / New…” from the menu.
4)	Give the new virtual machine a name and select “Linux” as Type, and “Debian (64-bit)” as Version. Continue and accept the default settings until finished.
5)	Right click the newly created virtual machine, and select “Settings…”.
6)	From “Network”, change “Attached to” = “Bridged Adapter”. *
7)	From “Storage”, highlight the CD, under “Controller: IDE”. From “Attributes” klick the second CD-image and “Choose Virtual Optical Disk File…”. Find the Debian image and attach it.
8)	Start the Virtual Machine.


The Debian installation:

1)	Inside the virtual machine, choose “Install” when Debian is started.
2)	Select your language, location, locales and keyboard.
3)	Enter hostname, domain name, root password and your personal user credentials, of your own choosing. 
4)	Partition the disk using the “Guided – use entire disk” alternative. Continue with the default values and suggestions, until you receive the “Write the changes to disk?” prompt. Then choose “Yes”!
5)	When configuring the package manager, choose the default values, and leave the proxy setting empty (unless you know that it’s needed).
6)	No need to participate in the package usage survey.
7)	Software to install: select “web server”, “SSH server” and “standard system utilities” a “desktop environment” and the “print server” is not needed)
8)	Install the GRUB boot loader on the master boot record, and choose “/dev/sda” in the next window.
9)	Finish the installation. 


The Project installation:

1)	Log in as root when the virtual machine has rebooted.
2)	Run “ifconfig” to see the IP-number of the virtual machine (eth0, inet addr: xxx).
3)	When you open that IP-address in a browser on the host you should now see the “Apache2 Debian Default Page”.
4)	Run the following commands inside the virtual machine:
aptitude update && aptitude upgrade
aptitude install mysql-server mysql-client (enter a root password for MySQL)
aptitude install php5 php5-mysql libapache2-mod-php5
aptitude install git
cd /var/www/html/
git init
git clone https://github.com/j0ly/firstproject.git
nano admin/config.ini (change the password to match your MySQL root password)
reboot
5)	Open http://yourserver/firstproject/admin/createdb.php in the browser to create the database (yourserver = the IP from step 2).



*) Important when connecting from the host, and running the OWASP ZAP there!
