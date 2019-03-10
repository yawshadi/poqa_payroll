<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 2/26/2019
 * Time: 10:02 AM
 */

class Cronpayslip extends tableDataObject
{

    const TABLENAME = 'cron_payslip';


    public static  function getcrondataToprocess($startdate, $enddate){
        global $payrolldb;
        $getrecords = "select * from  cron_payslip where
                       paystart = '$startdate' and payend = '$enddate' and status = 0  limit 0, 10 ";
        $payrolldb->prepare($getrecords);
        return $payrolldb->resultSet();
    }

    public static  function updateStatus($basicid, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "UPDATE cron_payslip SET status = 1  where
                       paystart = '$startdate' and payend = '$enddate' and basicid = $basicid ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
    }


    public static  function getcount($basicid, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "SELECT count(*) as ct from cron_payslip where
                       paystart = '$startdate' and payend = '$enddate' and basicid = $basicid ";
        $payrolldb->prepare($getrecords);
        return $payrolldb->fetchColumn();
    }




}