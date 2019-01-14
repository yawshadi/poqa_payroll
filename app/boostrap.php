<?php

// Including the configuration file
require_once 'config/config.php';
require_once 'config/config_env.php';


// Load everything we require via composer
require('../vendor/autoload.php');
require('../vendor/html2pdf/html2pdf.class.php');

//helper functions
require_once 'helpers/general_helper.php';
require_once 'helpers/email_helper.php';

//api helper functions
//require_once 'helpers/api_helper.php';

// Customer helper functions
//require_once 'helpers/customer_helper.php';

// General Helpers function
//require_once 'helpers/general_helper.php';

// if DEVMODE is true, require additional helpers
// if(DEVMODE == true){
//     require_once 'helpers/devhelpers.php';
// }

/*
 * Autoload Core Libraries
 *
 * Note: We are not using namespaces, so this will
 * blow up in our faces if we have any duplicate class
 * names! TODO: consider using namespaces!
 */
spl_autoload_register(function($class){

    $pathContorllers = APPROOT . '/controllers/' . $class . '.php';
    $pathLibs = APPROOT . '/libraries/' . $class . '.php';
    $pathModels = APPROOT . '/models/' . $class . '.php';
    $pathServices = APPROOT . '/service/' . $class . '.php';

    if (file_exists($pathContorllers)) {
        require_once $pathContorllers;
    } elseif (file_exists($pathLibs)) {
        require_once $pathLibs;
    } elseif (file_exists($pathModels )) {
        require_once $pathModels ;
    } elseif (file_exists($pathServices )) {
        require_once $pathServices ;

    }

});

/**
 * We are always going to need the database, so we are going to
 * create our database object here. It can then be referenced
 * in class member functions as "global $marketplacedb"
 */

$payrolldb = new Database();
//$client = new Google_Client();


// We also always need the session object, and need to create it before any output.
session_start();

?>
