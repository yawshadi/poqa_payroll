<?php

include('sendemail.php');
$sm =  new Sendpayslipemail();
$status = $sm->getDataToProcess();
echo SMTP_HOST;

print_r($status);


?>