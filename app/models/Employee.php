<?php

class Employee extends tableDataObject{


    const TABLENAME = 'basicinformation';

    public static  function getEmployees(){
        global $payrolldb;
        $getrecords = "select * from  basicinformation where source is null ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getEmployeesByCompanyandDepartment($company, $department){
        global $payrolldb;
        $getrecords = "select * from  basicinformation  where company = '$company' and department = '$department' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getEmployeesByCompany($company){
        global $payrolldb;
        $getrecords = "select * from  basicinformation  where company = '$company' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getEmployeesByType($company){
        global $payrolldb;
        $getrecords = "select * from  basicinformation  where company = '$company' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getEmployeesById($id){
        global $payrolldb;
        $getrecords = "select * from  basicinformation  where basic_id = '$id' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->singleRecord();
    }


    public static  function addchildren($basicid, $name, $dob){
        global $payrolldb;
        $insertrecords = "INSERT into children (childname, dateofbirth, basic_id) values ('$name', '$dob', $basicid)  ";
        $payrolldb->prepare($insertrecords);
        $payrolldb->execute();

    }

    public static  function getvisaemployees($company = null){
        global $payrolldb;
        if($company == ''){
            $getrecords = "select * from  basicinformation where source = 'visa' ";
        }else{
        $getrecords = "select * from  basicinformation where source = 'visa'  and company = '$company' ";
         }
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }


    public static  function searchemployeegeneral($value){
        global $payrolldb;
        $getrecords = "select * from  basicinformation where  staffid = '$value' or telephone = '$value' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->singleRecord();
    }

    public static  function searchemployeegeneralcount($value){
        global $payrolldb;
        $getrecords = "select count(*) as ct  from  basicinformation where  staffid = '$value' or telephone = '$value' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->fetchColumn();
    }

    public static function searchemployee($query,$request)
    {
        global $payrolldb;
        if($request=='search') {
            $getrecords = "select * from basicinformation  where firstname like '$query%' or surname like '$query%' or staffid like '$query%' or telephone like '$query%'";
        }elseif ($request=='populate'){
            $getrecords = "select * from basicinformation  where basic_id ='$query'";
        }
        $payrolldb->prepare($getrecords);
        return $payrolldb->resultSet();
    }



    public static function getemployeebynationality($nationality){
        global $payrolldb;
        $getrecords = "select * from basicinformation where nationality = '$nationality' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static function getentrylist(){
        global $payrolldb;
        $getrecords = "select * from basicinformation where  entrydate != '' ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }


    public static function getexitlist(){
        global $payrolldb;
        $getrecords = "select * from basicinformation where  exitdate != '' " ;
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }



}

?>
