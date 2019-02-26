<?php

class PayrollRecurrent extends tableDataObject{


    const TABLENAME = 'payrollrecurrent';


    public static  function getRecurrentPayroll($company, $department,$startdate, $enddate){
        global $payrolldb;

        $getrecords = "select payrollrecurrent.*,  basicinformation.*    from  payrollrecurrent
        inner join basicinformation on payrollrecurrent.basic_id = basicinformation.basic_id
         where payrollrecurrent.company='$company' and payrollrecurrent.department='$department'
        and (payrollrecurrent.paystart = '$startdate' and payrollrecurrent.payend = '$enddate') ";

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getRecurrentCheck($startdate, $enddate, $basicid){
        global $payrolldb;
        $getrecords = "select count(*) as count from  payrollrecurrent where basic_id = $basicid
        and (paystart = '$startdate' and payend = '$enddate') ";
        $count = $payrolldb->prepare($getrecords);
        $count = $payrolldb->fetchColumn();
        return $count;
    }

    public static  function getlistforcron($startdate, $enddate){
        global $payrolldb;

        $getrecords = "select * from  payrollrecurrent  where paystart = '$startdate' 
                       and payend='$enddate'  ";

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

}
