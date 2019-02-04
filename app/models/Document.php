<?php

class Document extends tableDataObject {

    const TABLENAME = 'document';

    public static  function getDocument($taskid){
        global $payrolldb;

        $getrecords = "select * from document where taskid = $taskid";

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getPassportbyBasicid($basicid){
        global $payrolldb;

        $getrecords = "select * from document where basicid = $basicid and doctype='passport' ";

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->singleRecord();
    }

    public static  function getSuportingbyBasicid($basicid){
        global $payrolldb;

        $getrecords = "select * from document where basicid = $basicid and doctype='supporting' " ;

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->singleRecord();
    }

    public static  function getcompanydocument($companyid){
        global $payrolldb;
        $getrecords = "select * from document where companyid = '$companyid' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getemployeefolder($randomnumber){
        global $payrolldb;
        $getrecords = "select * from document where randomnumber = '$randomnumber' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }


}

 ?>
