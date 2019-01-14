<?php

class Transfer extends tableDataObject{

    const TABLENAME = 'transfer';

    public static function inserttransferusers($gid, $uid){
      global $payrolldb;
      $query = "INSERT INTO transferusers (tid,uid) values ($gid, $uid) ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
   }

   public static function getCount($value){
     global $payrolldb;
     if($value == 'All'){
       $stmt = '';
     }
       $query = "Select count(*) as ct from transfer $stmt";
       $payrolldb->prepare($query);
       $payrolldb->execute();
       return  $payrolldb->fetchColumn();

  }

  public static function gettransferusers($id){
    global $payrolldb;
      $query = "Select * from  transferusers where tid = $id ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
      return  $payrolldb->resultSet();

 }

 public static function getTransfers($employeeid){
   global $payrolldb;
   $query = "Select * from transfer where employeeid = $employeeid ";
   $payrolldb->prepare($query);
   $payrolldb->execute();
   return $payrolldb->resultSet();
}








}
