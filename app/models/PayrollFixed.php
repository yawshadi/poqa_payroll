<?php

class PayrollFixed extends tableDataObject{


    const TABLENAME = 'payrollfixed';


    public static  function getFixedPayroll($company, $department, $position, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select count(*) as count from  payrollfixed where company='$company' and department='$department'
        and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
        $count = $payrolldb->prepare($getrecords);
        $count = $payrolldb->fetchColumn();
        return $count;
    }


   public function getPayrollFixedId($company, $department, $position){
    global $payrolldb;
    $getrecords = "select payrollfixedid from  payrollfixed where  company='$company' and department='$department'
    and position='$position' ";
    $payrollfixedid = $payrolldb->prepare($getrecords);
    $payrollfixedid  = $payrolldb->fetchColumn();
    return $payrollfixedid;

   }


   public static  function getFixedValue($company, $department, $position, $startdate, $enddate){
    global $payrolldb;
    $getrecords = "select * from  payrollfixed where company='$company' and department='$department'
    and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
    $payrolldb->prepare($getrecords);
    $payrolldb->execute();
    return $payrolldb->resultSet();
}



}

?>
