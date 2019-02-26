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

     public static function getAssets($employeeid){
        global $payrolldb;
        $query = "Select * from assets where employeeid = $employeeid ";
        $payrolldb->prepare($query);
        $payrolldb->execute();
        return $payrolldb->resultSet();
     }

     public static function insertassetusers($aid, $uid){
      global $payrolldb;
      $query = "INSERT INTO assetusers (aid,uid) values ($aid, $uid) ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
   }

   public static function getassetusers($id){
    global $payrolldb;
    $query = "Select * from  assetusers where aid = $id ";
    $payrolldb->prepare($query);
    return  $payrolldb->resultSet();
 }
}