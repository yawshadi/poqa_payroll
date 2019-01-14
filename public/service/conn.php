<?php
try{
    $con = new PDO('mysql:host=mpbeta.mysql.database.azure.com;dbname=marketplace;', 'marketplacedb@mpbeta', '75iE_dJHH6');
    // $con = new PDO('mysql:host=localhost;dbname=fal; port:3306', 'fal', 'fal');
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e){
    die("Error connecting to database");
}




function logad($con,$message = "No message provided to log function?",$logdiag = null){
    if($logdiag === null){
        $logdiag = serialize($_POST) ?: 'no post';
    }
    $logInsQ = "insert into systemlog (logcategory,user,logmessage,diagnostic)
					values ('debug','AD API',:message,:logdiag)";

    $doit = $con->prepare($logInsQ);

    $doit->bindParam(':message',$message);
    $doit->bindParam(':logdiag',$logdiag);

    if(!$result = $doit->execute()){
        die(print_r(["<pre>tried to log, couldn't ($logInsQ)",$con->errorInfo()],true));
    }
    return "Logged";
}

// logging here spams the logs. We know it works, though.
// logad($con,"XX: Connection to /public/service - see diagnostic and following requests for details!");


