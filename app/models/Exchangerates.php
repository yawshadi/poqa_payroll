<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 3/10/2019
 * Time: 7:15 AM
 */

class Exchangerates extends tableDataObject
{
    const TABLENAME = 'exchangerates';

    public static function getrates(){
        global $payrolldb;
        $getrecords = "SELECT * from exchangerates" ;
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->singleRecord();
    }


}

