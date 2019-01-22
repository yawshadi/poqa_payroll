<?php

class Holiday extends tableDataObject{

    const TABLENAME = 'holiday';

    public static function getholidaybyid($holidayid){
        global $payrolldb;
        $query = "SELECT * FROM holiday WHERE holidayid='$holidayid'";
        $payrolldb->prepare($query);
       return $payrolldb->singleRecord();
     }
}