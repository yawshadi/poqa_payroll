<?php

class Leavedays extends tableDataObject{

    const TABLENAME = 'leavedays';

    public static function getleavedays($daysid){
        global $payrolldb;
        $query = "SELECT * FROM leavedays WHERE daysid='$daysid'";
        $payrolldb->prepare($query);
       return $payrolldb->singleRecord();
     }

     public static function totalleave(){
        global $payrolldb;
        $query = "SELECT leavedays.leavedays FROM leavedays ";
        $payrolldb->prepare($query);
       return $payrolldb->fetchColumn();
     }

     public static function availabledays($employeeid,$year){
         
        global $payrolldb;
        $query = "SELECT sum(actualdays) as days FROM leaves WHERE employeeid='$employeeid' and year(reportdate)='$year'";
        $payrolldb->prepare($query);
        $l = $payrolldb->fetchColumn();

        $accumulated = Employee::getEmployeesById($employeeid)->accumulatedleave;
        $totalleave = self::totalleave();
        if($accumulated=='') {$totalleave = self::totalleave();}else{$totalleave = $accumulated; }
        $available = $totalleave - $l;
        if ($available < 0) $available = 0;
        return $available;
     }

     public static function entitlteddays($employeeid,$year){
         
        global $payrolldb;
        $query = "SELECT sum(actualdays) as days FROM leaves WHERE employeeid='$employeeid' and year(reportdate)='$year'";
        $payrolldb->prepare($query);
        $l = $payrolldb->fetchColumn();

        $accumulated = Employee::getEmployeesById($employeeid)->accumulatedleave;
        $totalleave = self::totalleave();
        if($accumulated==''|| empty($accumulated)) {$totalleave = self::totalleave();}else{$totalleave = $accumulated; }
        $available = $totalleave + $l;
       
        return $available;
     }
}