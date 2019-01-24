<?php

class Leavedays extends tableDataObject{

    const TABLENAME = 'leavedays';

    public static function getleavedays($daysid){
        global $payrolldb;
        $query = "SELECT * FROM leavedays WHERE daysid='$daysid'";
        $payrolldb->prepare($query);
       return $payrolldb->singleRecord();
     }

     public static function availabledays($employeeid){
         
     }
}