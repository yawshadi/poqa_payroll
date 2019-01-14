<?php

class Companies extends tableDataObject{


    const TABLENAME = 'company';

    public static function getCompany(){
        global $payrolldb;
        $getrecords = "select * from company where role is null  or role = '' ";

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static function getCompanybyName($name){
        global $payrolldb;
        $getrecords = "select companyid  from company where companyname = '$name' ";
        $companyid = $payrolldb->prepare($getrecords);
        $companyid = $payrolldb->fetchColumn();
        return $companyid;
    }

    public static function getCompanybyId($id){
        global $payrolldb;
        $getrecords = "select companyname  from company where companyid = '$id' ";
        $companyid = $payrolldb->prepare($getrecords);
        $companyid = $payrolldb->fetchColumn();
        return $companyid;
    }

    public static function getAgent($status){
        global $payrolldb;
        $stmt = $status ==  'pending' ? "status='pending'" : "status='approved'";
        $getrecords = "select * from company where role = 'Agent' and $stmt  ";
        $companyid = $payrolldb->prepare($getrecords);
        $companyid = $payrolldb->resultSet();
        return $companyid;
    }









}

?>
