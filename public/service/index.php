<?php
include('conn.php');

// Disabling timezone manipulation as it messes with the systemlog
// date_default_timezone_set('Europe/Berlin');

logad($con,"Initiate index.php request");

/*
 * this is heavy-handed but we are going to give it a go -
 * trim all post vars...
 */
foreach ($_POST as $key => $value){
    $_POST[$key] = trim($value);
}

if(isset($_POST['description'])){
    $description =  $_POST['description'];
}

if(isset($_POST['sam'])){
    $sam = str_replace('$', '', $_POST['sam']);
}

if(isset($_POST['lastlogondate'])){

    $lastlogondate = $_POST['lastlogondate'];
    if($lastlogondate != '' ){
        $logdate = str_replace('/', '-', $lastlogondate);
        $logdate = date('Y-m-d H:i:s', strtotime($logdate));
    }

}

//$logdate = '2018-01-01 12:00:00';

if(isset($_POST['sam'])){ $operatingsystem = $_POST['operatingsystem']; }
if(isset($_POST['hostname'])){ $hostname = $_POST['hostname'] ; }
if(isset($_POST['operatingsysystemversion'])){ $operatingsysystemversion = $_POST['operatingsysystemversion']; }
if(isset($_POST['servicepack'])){ $servicepack = $_POST['servicepack'];}
$datetime = date('Y-m-d H:i:s');

if(isset($_POST['username'])) { $username = $_POST['username']; }
if(isset($_POST['password'])) { $password = $_POST['password']; }

//TODO : Escpae special characters
if(isset($_POST['customeraccount'])){
    $customeraccount = $_POST['customeraccount'];
}

$datefilter = date('Y-m-d H');
if(isset($_POST['count'])){ $count = $_POST['count']; }

if(isset($_POST['ipaddress'])){ $ipaddress = $_POST['ipaddress'];}
if(isset($_POST['publicip'])){ $publicip = $_POST['publicip']; }
$version  = (isset($_POST['version']) ? $_POST['version'] : '3.0.0');

if(isset($_POST['sid'])){ $sid = $_POST['sid'];}
if(isset($_POST['created'])){ $created = $_POST['created'];}
if(isset($_POST['logoncount'])){ $logoncount  = $_POST['logoncount'];}
if(isset($_POST['ipv4'])){ $ipv4 = $_POST['ipv4'];}
if(isset($_POST['agent'])){ $agent = $_POST['agent']; }

/*
 * Here is another really awful band-aid:
 * go through all of $_POST, check for the existence
 * of variables named by parameter, and set them, if not.
 */
foreach($_POST as $key=>$val){
    if(!isset($$key)){
        $$key = trim($val);
    }
}


$gcq = "Select count(*) as todaycount from activedirectory where adreport like '%" . $customeraccount . "%'
	and accountname = '$sam' ";

if(!$getcount = $con->query($gcq)){
    logad($con,
        "ERROR: Failed in getcount, see diagnostic",
        serialize([
            "PDO Error info" => $con->errorInfo(),
            "Query" => $gcq,
            "POST" => $_POST
        ]));
} else {
    logad($con,"getcount query ran without errors");
}
$ct = $getcount->fetch(PDO::FETCH_OBJ);
$todaycount = $ct->todaycount;

// $username = 'Commehr';
// $password = 'Commehr@2017&&';


if($username == 'Commehr' && $password == 'Commehr@2017&&'){

    if($todaycount == 0){

        //$logdate = '2018-01-01 12:00:00';
        $inserdata = $con->query("INSERT INTO activedirectory (accountname,description,hostname,lastlogon,operatingsystem,
  servicepack,hotfix,opversion,reportime,adreport,localipaddress, publicipaddress, version, agent,
	sid, ipv4, created, logoncount) values
  ('$sam', '$description', '$hostname', '$logdate', '$operatingsystem', '$servicepack', '$hotfix',
 '$operatingsysystemversion','$datetime', '$customeraccount', '', '$publicip', '$version',
  '$agent', '$sid', '$ipv4', '$created', '$logoncount') ");
        if(!$inserdata) { print_r($con->errorInfo()); }

    }

    else{
        //$logdate = '2018-01-01 12:00:00';
        $updatedata = $con->query("UPDATE activedirectory SET accountname='$sam', description='$description', hostname='$hostname',
	lastlogon='$logdate',operatingsystem='$operatingsystem',servicepack='$servicepack',hotfix='$hotfix',
	opversion='$operatingsysystemversion', reportime='$datetime', adreport='$customeraccount',
	publicipaddress='$publicip', version='$version', agent = '$agent',
	sid = '$sid', ipv4='$ipv4', created='$created', logoncount = '$logoncount'
	where adreport like '%$customeraccount%'  and accountname = '$sam' ");
        if(!$updatedata) { print_r($con->errorInfo()); }

    }

}


?>
