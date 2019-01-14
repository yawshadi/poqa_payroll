<?php

class Branches extends tableDataObject{


    const TABLENAME = 'branches';

    public static  function getBranches(){
        global $payrolldb;
        $getrecords = "select * from  branches";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }


}

?>