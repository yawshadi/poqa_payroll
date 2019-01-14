<?php

class Grievance extends tableDataObject{

    const TABLENAME = 'grievance';

    public static function insertgrievanceusers($gid, $uid){
      global $payrolldb;
      $query = "INSERT INTO grievanceusers (gid,uid) values ($gid, $uid) ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
   }

   public static function getGrievance($employeeid){
     global $payrolldb;
     $query = "Select * from grievance where employeeid = $employeeid ";
     $payrolldb->prepare($query);
     $payrolldb->execute();
     return $payrolldb->resultSet();
  }


   public static function getCount($value){
     global $payrolldb;
     if($value == 'All'){
       $stmt = '';
     }
       $query = "Select count(*) as ct from grievance $stmt";
       $payrolldb->prepare($query);
       $payrolldb->execute();
       return  $payrolldb->fetchColumn();

  }

  public static function getgrievanceusers($id){
    global $payrolldb;
      $query = "Select * from grievanceusers where gid = $id ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
      return  $payrolldb->resultSet();
 }





}
