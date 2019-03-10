<?php

class Payperiod extends tableDataObject{


    const TABLENAME = 'payrollperiod';

    public static  function getPayrollPeriod(){
        global $payrolldb;
        $getrecords = "select * from payrollperiod";

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static function getcronperiod(){

        global $payrolldb;
        $getrecords = "SELECT end, start FROM payrollperiod ORDER BY payrollperiodid DESC LIMIT 1 ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->singleRecord();
    }


    public static function getLastPayperiod($company){

       global $payrolldb;
       $getrecords = "SELECT end, start FROM payrollperiod  where company = '$company'  ORDER BY payrollperiodid DESC LIMIT 1 ";
       $payrolldb->prepare($getrecords);
       $payrolldb->execute();
       return $payrolldb->resultSet();
    }


   public static function getLastEndPayperiod($company){

    global $payrolldb;
    $getrecords = "SELECT end FROM payrollperiod  where company = '$company'  ORDER BY payrollperiodid DESC LIMIT 1 ";
    $payend = $payrolldb->prepare($getrecords);
    $payend = $payrolldb->fetchColumn();
    return $payend;

   }

    public static function getPayperiod(){

        global $payrolldb;
        $getrecords = "SELECT end, start FROM payrollperiod  ORDER BY payrollperiodid DESC LIMIT 1 ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static function comparePayPeriod($company){

      $dbdate = self::getLastEndPayperiod($company);
      $today = date('Y-m-d');
      $datediff = strtotime($dbdate) - strtotime($today);
      $days = floor($datediff / (60 * 60 * 24));
      return $days;

    }



}

?>
