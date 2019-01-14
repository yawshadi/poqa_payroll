<?php
include('conn.php');
// date_default_timezone_set('Europe/Berlin');

logad($con,"Initiate object.php request");

 $customeraccount = (trim($_POST['customeraccount']));
 $sid= $_POST['sid'];
 $version = '3.0.0';
 $deleted = $_POST['deleted'];

 $update = $con->query("UPDATE adusers SET deleted = '$deleted' where SID = '$sid' ");
 $update = $con->query("UPDATE activedirectory SET deleted = '$deleted' where sid = '$sid' ");
 $insert = $con->query("INSERT INTO deletedobjects (sid, deleted) values ('$sid', '$deleted') ");

?>
