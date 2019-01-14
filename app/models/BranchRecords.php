<?php

class BranchRecords extends tableDataObject{


    const TABLENAME = 'branchrecords';

    public static  function getBranchRecords(){
        global $payrolldb;
        $getrecords = "select * from  branchrecords";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function deleteBranchRecords($startdate, $endate){
        global $payrolldb;
        $getrecords = "delete from branchrecords where startdate = '$startdate' and endate='$endate' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
    }

    public static  function getBranchRecordsByDate($startdate){
        global $payrolldb;
        $getrecords = "Select * from branchrecords where startdate like '%$startdate%'  ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getBranchMonthlyRecordsByDate($startdate){
       
        global $payrolldb;
        $getrecords = "Select branchname,
         sum(midweek) as midweek, sum(welfare) as welfare, sum(tithe) as tithe,
         sum(expenses) as expenses, sum(harvest) as harvest, sum(offering) as offering
         from branchrecords where startdate like '%$startdate%' group by branchname ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();

    }


}

?>