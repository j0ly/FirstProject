# FirstProject

Cyber Security Base - Course Project I

The task was to create a web application that has at least five different flaws from the OWASP top ten list.
So be aware, this is simple and bad code with many vulnerabilities!

This project is done with PHP in a LAMP environment. 
Here are the installation instructions (just an example, other kind of LAMP environment using Apache, PHP and MySQL will most likely work too);

1.	Download and install VirtualBox on your personal computer (which can be Windows, OS X, Linux or Solaris); https://www.virtualbox.org/wiki/Downloads
2.	Download the “64 bit PC netinst.iso” Debian image from here; https://www.debian.org/distrib/
3.	Start Virtualbox and select “Machine / New…” from the menu.
4.	Give the new virtual machine a name and select “Linux” as Type, and “Debian (64-bit)” as Version. Continue and accept the default settings until finished.
5.	Right click the newly created virtual machine and select “Settings…”.
   * From “Network”, change “Attached to” = “Bridged Adapter”. 
   * From “Storage”, highlight the CD under “Controller: IDE”. From “Attributes” klick the CD-image and “Choose Virtual Optical Disk File…”. Find the Debian image and attach it.
8.	Start the virtual machine.


Debian installation:

1.	Inside the virtual machine, choose “Install” when Debian has started.
2.	Select your language, location, locales and keyboard.
3.	Enter hostname, domain name, root password and your personal user credentials of your own choosing. 
4.	Partition the disk using the “Guided – use entire disk” alternative. Continue with the default values and suggestions, until you receive the “Write the changes to disk?” prompt. Then choose “Yes”!
5.	When configuring the package manager, choose the default values, and leave the proxy setting empty (unless you know it’s needed).
6.	No need to participate in the package usage survey.
7.	Software to install: select “web server” and “standard system utilities” (nothing else is needed).
8.	Install the GRUB boot loader on the master boot record, and choose “/dev/sda” in the next window.
9.	Finish the installation. 


Project installation:

1.	Log in as root when the virtual machine has rebooted.
2.	Run “ifconfig” to see the IP-number of the virtual machine (eth0, inet addr: x.x.x.x).
3.	Run the following commands inside the virtual machine:
   * aptitude install mysql-server mysql-client - enter a root password for MySQL!
   * aptitude install php5 php5-mysql libapache2-mod-php5
   * aptitude install git
   * cd /var/www/html/
   * git init
   * git clone https://github.com/j0ly/firstproject.git
   * nano firstproject/admin/config.ini - change the password to match your MySQL root password!
   * reboot	
4.  Open http://yourserver/firstproject/admin/createdb.php in the browser, from the host*, to create the database (yourserver = the IP from step 2).

*) host = the computer/os running the VirtualBox virtual machine

### How to use:

* Open http://yourserver/firstproject/ in a browser, from the host.
* Sign-up some imagenary persons to the imagenary event, using imagenary credit-card numbers (no checking is done).
* Take note of the ticket-number if you want to test cancelling the sign-up.
* On the Admin page you can get a list of the people who have signed-up.
  * The credentials are: admin/password

#### For general instructions on how to improve software security, see:
* https://www.owasp.org/images/0/08/OWASP_SCP_Quick_Reference_Guide_v2.pdf
Regarding credit cards, there are many rules:
* https://www.pcisecuritystandards.org/pci_security/how


