<?php

class User extends tableDataObject{


    const TABLENAME = 'users';


    public static function encryptPassword($value){

        $password = md5($value);
        return $password;
    }

    public static  function getUsers(){
        global $payrolldb;
        $getrecords = "select * from users where accesslevel = '2' ";
         $payrolldb->prepare($getrecords);
         $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static function checkUserExist($email){
      global $payrolldb;
  		$getusercount = "select count(*) as usercount from users where email  = '$email'  ";
  		$count = $payrolldb->prepare($getusercount);
  		$usercount = $payrolldb->fetchColumn();
  		return $usercount;
	 }

   public static function userlogin($email, $password){
     global $payrolldb;
     $getusercount = "select count(*) as usercount from users where email  = '$email' and pw = '$password'  ";
     $count = $payrolldb->prepare($getusercount);
     $usercount = $payrolldb->fetchColumn();
     return $usercount;
  }

  public static function userinfo($email){
    global $payrolldb;
    $getusercount = "select *  from users where email  = '$email' ";
    $count = $payrolldb->prepare($getusercount);
    $usercount = $payrolldb->singleRecord();
    return $usercount;
 }





}

?>
