<?php
include('conn.php');

logad($con,"Initiate adusers.php request");

// date_default_timezone_set('Europe/Berlin');

$AccountExpirationDate=$_POST['AccountExpirationDate'];
if (isset($_POST['badPwdCount'])) {
    $badPwdCount = $_POST['badPwdCount'];
} elseif (isset($_POST['badPwdCount_'])){
    $badPwdCount = $_POST['badPwdCount_'];
}
$badPasswordTime=$_POST['badPasswordTime'];

//TODO : Escappe strings
$Company = ($_POST['Company']);
$CanonicalName = ($_POST['CanonicalName']);
$Departtment = ($_POST['Departtment']);
$DisplayName= ($_POST['DisplayName']);
$DistinguishedName= ($_POST['DistinguishedName']);
$EmailAddress = ($_POST['EmailAddress']);
$GivenName = ($_POST['GivenName']);
$SamAccountName=($_POST['SamAccountName']);
$Surname= ($_POST['Surname']);
$Name= ($_POST['Name']);
$customeraccount = trim($_POST['customeraccount']);

/////////////////////////////////////////////////////////////


$Enabled=$_POST['Enabled'];
$Created =$_POST['Created'];
$LastLogonDate=$_POST['LastLogonDate'];
$isDeleted=$_POST['isDeleted'];
$LastBadPasswordAttempt=$_POST['LastBadPasswordAttempt'];
$lastLogon=$_POST['lastLogon'];

$Modified=$_POST['Modified'];
$modifyTimeStamp=$_POST['modifyTimeStamp'];

$PasswordExpired=$_POST['PasswordExpired'];

$PasswordLastSet=$_POST['PasswordLastSet'];
$PasswordNeverExpires=$_POST['PasswordNeverExpires'];
$PasswordNotRequired=$_POST['PasswordExpired'];

$SID= $_POST['SID'];

$datetime = date('Y-m-d H:i:s');

$username = $_POST['username'];
$password = $_POST['password'];

$agent = $_POST['agent'];
$publicip = $_POST['publicip'];
$version  = (isset($_POST['version']) ? $_POST['version'] : '3.0.0');
$logonCount = '';


if($username == 'Commehr' && $password == 'Commehr@2017&&'){


    $countQ = "Select count(*) as todaycount  from adusers where adreport like '%$customeraccount%' and sid = '$SID'";

    $getcount = $con->query($countQ) or die (print_r($con->errorInfo(),true));
    $ct= $getcount->fetch(PDO::FETCH_OBJ);
    $todaycount = $ct->todaycount;



    if($todaycount == 0){

        $insQ = "
      	INSERT INTO adusers (Name,GivenName,Surname,EmailAddress,SamAccountName,SID,DisplayName,DistinguishedName,
        Company,Departmant,Created,Lastlogon,CanonicalName,
        LastLogonDate,logonCount,modifyTimeStamp,
      	PasswordExpired,PasswordLastSet,PasswordNeverExpires,PasswordNotRequired,AccountExpirationDate,badPwdCount,
      	badPasswordTime, adreport, reportdate, agent, publicip, version, enabled) values ('$Name', '$GivenName',
        '$Surname', '$EmailAddress',
      	'$SamAccountName', '$SID', '$DisplayName', '$DistinguishedName', '$Company', '$Departtment', '$Created',
      	'$lastLogon', '$CanonicalName', '$LastLogonDate', '$logonCount', '$modifyTimeStamp', '$PasswordExpired',
      	'$PasswordLastSet', '$PasswordNeverExpires', '$PasswordNotRequired', '$AccountExpirationDate', '$badPwdCount',
      	'$badPasswordTime', '$customeraccount', '$datetime', '$agent', '$publicip', '$version', '$Enabled') ";

        $insertadusers = $con->query($insQ);


    }

    else{

        $updateadusers = $con->query("UPDATE adusers SET Name='$Name',GivenName='$GivenName',Surname='$Surname',
        EmailAddress='$EmailAddress',SamAccountName='$SamAccountName',SID='$SID',DisplayName='$DisplayName',
        DistinguishedName='$DistinguishedName',Company='$Company', Departmant='$Departtment',Created='$Created',
        Lastlogon='$lastLogon', CanonicalName='$CanonicalName', LastLogonDate='$LastLogonDate',
        logonCount='$logonCount',modifyTimeStamp='$modifyTimeStamp',
      	PasswordExpired='$PasswordExpired',PasswordLastSet='$PasswordLastSet',
      	PasswordNeverExpires='$PasswordNeverExpires',PasswordNotRequired='$PasswordNotRequired',
      	AccountExpirationDate='$AccountExpirationDate',badPwdCount='$badPwdCount',
      	badPasswordTime='$badPasswordTime', reportdate='$datetime', agent = '$agent', publicip = '$publicip',
      	version='$version', enabled = '$Enabled' where adreport like '%$customeraccount%' and SID = '$SID' ");

    }


}



?>
