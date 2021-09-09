<?php

class Leave extends tableDataObject{

    const TABLENAME = 'leaves';

    public static function insertleaveusers($lid, $uid){
      global $payrolldb;
      $query = "INSERT INTO leaveusers (lid,uid) values ($lid, $uid) ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
   }

   public static function getCount($value){
     global $payrolldb;
     if($value == 'All'){
       $stmt = '';
     }
       $query = "Select count(*) as ct from leaves $stmt ";
       $payrolldb->prepare($query);
       $payrolldb->execute();
       return  $payrolldb->fetchColumn();

  }

  public static function getleaveusers($id){
      global $payrolldb;
      $query = "Select * from  leaveusers where lid = $id ";
      $payrolldb->prepare($query);
      $payrolldb->execute();
      return  $payrolldb->resultSet();
   }

   public static function getLeave($employeeid){
     global $payrolldb;
     $query = "Select * from leaves where employeeid = $employeeid ";
     $payrolldb->prepare($query);
     $payrolldb->execute();
     return $payrolldb->resultSet();
   }

   public static function LeaveEmp($year){
    global $payrolldb;
    $query = "SELECT * from basicinformation left join leaves on basicinformation.basic_id = leaves.employeeid WHERE Year(leaves.startdate) = '$year' order by basicinformation.basic_id asc  ";
    $payrolldb->prepare($query);
    $payrolldb->execute();
    return $payrolldb->resultSet();
  }

  public static function LeaveEmpAll(){
    global $payrolldb;
    $query = "SELECT * from basicinformation left join leaves on basicinformation.basic_id = leaves.employeeid  order by basicinformation.basic_id asc  ";
    $payrolldb->prepare($query);
    $payrolldb->execute();
    return $payrolldb->resultSet();
  }

}
