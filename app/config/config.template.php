<?php

// constant to allow additional includes, debug functions, whatever only on dev environments...
define ('DEVMODE', true);

// enable disabling of UI during maintenance
define ('MAINTENANCE', false);

// timezone, different on server
date_default_timezone_set('Europe/London');

//DB Configuartions
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');
 // Application Root
 define('APPROOT', dirname(dirname( __FILE__ )));

 dirname(dirname( __FILE__ ));
 // URL ROOT
 define('URLROOT', 'http://HOSTNAME/');
 //SITE NAME
 define('SITENAME', 'My Site');

 //Path for uploads
$uploadpath = APPROOT.'/'.'uploads/';
define('UPLOAD_PATH', $uploadpath);
 
?>