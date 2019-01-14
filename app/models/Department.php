<?php

class Department extends tableDataObject{


    const TABLENAME = 'department';

    public static  function getDepartment(){
        global $payrolldb;

        $getrecords = "select * from department";
    
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getDepartmentByCompany($company){
        global $payrolldb;

        $getrecords = "select * from department where company = '$company' and departmentname is not null ";
    
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }


}

?>