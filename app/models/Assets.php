<?php

class Assets extends tableDataObject {

    const TABLENAME = 'assets';

    public static function getCount($value){
        global $payrolldb;
        if($value == 'All'){
          $stmt = '';
        }
          $query = "Select count(*) as ct from assets $stmt ";
          $payrolldb->prepare($query);
          $payrolldb->execute();
          return  $payrolldb->fetchColumn();
   
     }

}