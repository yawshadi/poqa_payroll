<?php

class Discipline extends tableDataObject{

    const TABLENAME = 'discipline';

    public static function insertdisciplineusers($did, $uid){
      global $payrolldb;
      $query = "INSERT INTO disciplineusers (did,uid) values ($did, $uid) ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
   }


   public static function getCount($value){
     global $payrolldb;
     if($value == 'All'){
       $stmt = '';
     }
       $query = "Select count(*) as ct from discipline $stmt";
       $payrolldb->prepare($query);
       $payrolldb->execute();
       return  $payrolldb->fetchColumn();

  }

  public static function getdisciplineusers($id){
     global $payrolldb;
      $query = "Select * from disciplineusers where did = $id ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
      return  $payrolldb->resultSet();
 }

 public static function getDiscipline($employeeid){
   global $payrolldb;
   $query = "Select * from discipline where employeeid = $employeeid ";
   $payrolldb->prepare($query);
   $payrolldb->execute();
   return $payrolldb->resultSet();
}




}
