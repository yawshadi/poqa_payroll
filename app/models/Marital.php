<?php

class Marital extends tableDataObject{

    const TABLENAME ="marital";

    public static function maritaldata($randomnumber){

        global $payrolldb;
        $getrecords = "select * from marital where randomnumber = '$randomnumber' ";
        $payrolldb->prepare($getrecords);
        return $payrolldb->singleRecord();
    }
}