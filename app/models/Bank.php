<?php

class Bank extends tableDataObject{


    const TABLENAME = 'bankcodes';

    public static  function getBankCodes(){
        global $payrolldb;
        $getrecords = "select * from  bankcodes";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getBanks(){
        global $payrolldb;
        $getrecords = "select * from  bankcodes group by bankname";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getBankBranch($bankname){
        global $payrolldb;
        $getrecords = "select branch from bankcodes  where bankname =  '$bankname' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getbanksortcode($bankname, $branch){
        global $payrolldb;
        $getrecords = "select branchcode from bankcodes  where bankname =  '$bankname'  and branch = '$branch' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->fetchColumn();
    }


}

?>
