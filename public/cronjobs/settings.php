<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 2/26/2019
 * Time: 9:44 AM
 */

require_once '../../app/config/config.php';
require_once '../../app/config/config_env.php';
require_once '../../app/helpers/general_helper.php';
require_once '../../app/helpers/email_helper.php';
require('../../vendor/autoload.php');


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


$payrolldb = new Database();



?>