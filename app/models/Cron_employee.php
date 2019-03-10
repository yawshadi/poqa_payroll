<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 3/3/2019
 * Time: 9:57 AM
 */

class Cron_employee extends tableDataObject
{
   const  TABLENAME = 'cron_employee';

    public static  function getcount($basicid){
        global $payrolldb;
        $getrecords = "SELECT count(*) as ct from cron_employee where  basicid = $basicid ";
        $payrolldb->prepare($getrecords);
        return $payrolldb->fetchColumn();
    }

    public static  function getcronemployee($basicid){
        global $payrolldb;
        $getrecords = "SELECT * from cron_employee where  basicid = $basicid ";
        $payrolldb->prepare($getrecords);
        return $payrolldb->resultSet();
    }

}