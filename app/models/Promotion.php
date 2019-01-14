<?php

class Promotion extends tableDataObject{

    const TABLENAME = 'promotion';

    public static function insertpromotionusers($gid, $uid){
      global $payrolldb;
      $query = "INSERT INTO promotionusers (pid,uid) values ($gid, $uid) ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
   }

   public static function getCount($value){
     global $payrolldb;
     if($value == 'All'){
       $stmt = '';
     }
       $query = "Select count(*) as ct from promotion  $stmt";
       $payrolldb->prepare($query);
       $payrolldb->execute();
       return  $payrolldb->fetchColumn();

  }

  public static function getpromotionusers($id){
    global $payrolldb;
      $query = "Select * from promotionusers where pid = $id ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
      return  $payrolldb->resultSet();
 }

 public static function getPromotion($employeeid){
   global $payrolldb;
   $query = "Select * from promotion where employeeid = $employeeid ";
   $payrolldb->prepare($query);
   $payrolldb->execute();
   return $payrolldb->resultSet();
}





}
