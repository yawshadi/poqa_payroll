<?php

class Holiday extends tableDataObject{

    const TABLENAME = 'holiday';

    public static function getholidaybyid($holidayid){
        global $payrolldb;
        $query = "SELECT * FROM holiday WHERE holidayid='$holidayid'";
        $payrolldb->prepare($query);
       return $payrolldb->singleRecord();
     }

     public static function holidays(){
        global $payrolldb;
        $query = "SELECT holidaydate FROM holiday";
        $payrolldb->prepare($query);
       foreach($payrolldb->resultSet() as $l){
            $holiday[]=$l->holidaydate;
       }
       return $holiday;
     }
}