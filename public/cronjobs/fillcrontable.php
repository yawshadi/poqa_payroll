<?php

include('sendemail.php');
$sm =  new Sendpayslipemail();
$sm->storeDataForCron();



?>