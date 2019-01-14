<?php

class Reports extends tableDataObject{

  public static  function total_full_present($company, $department, $position, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select total_full_present from  payrollfixed where company='$company' and department='$department'
        and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function basic_salary($company, $department, $position, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select basic_salary from  payrollfixed where company='$company' and department='$department'
        and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function transport_allowance($company, $department, $position, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select transport_allowance from  payrollfixed where company='$company' and department='$department'
        and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function gross($company, $department, $position, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select gross from  payrollfixed where company='$company' and department='$department'
        and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function weekday_hourly_rate($company, $department, $position, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select weekday_hourly_rate from  payrollfixed where company='$company' and department='$department'
        and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function weekday_overtime_rate($company, $department, $position, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select weekday_overtime_rate from  payrollfixed where company='$company' and department='$department'
        and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function holiday_overtime_rate($company, $department, $position, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select holiday_overtime_rate from  payrollfixed where company='$company' and department='$department'
        and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function night_shift_allowance($company, $department, $position, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select night_shift_allowance from  payrollfixed where company='$company' and department='$department'
        and position='$position' and (startdate = '$startdate' and enddate = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }





   public static  function getpayrollrecurrent($basic_id, $startdate, $enddate){
          global $payrolldb;
          $getrecords = "select * from  payrollrecurrent where basic_id='$basic_id'
          and (paystart = '$startdate' and payend = '$enddate') ";
          $value = $payrolldb->prepare($getrecords);
          $value  = $payrolldb->singleRecord();
          return $value;
    }



    public static  function paye($basic_id, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select paye from  payrollrecurrent where basic_id='$basic_id'
        and (paystart = '$startdate' and payend = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function otherallowances($basic_id, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select otherallowances from payrollrecurrent where basic_id='$basic_id'
        and (paystart = '$startdate' and payend = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function otherdeductions($basic_id, $startdate, $enddate){
        global $payrolldb;
        $getrecords = "select otherdeductions from  payrollrecurrent where basic_id='$basic_id'
        and (paystart = '$startdate' and payend = '$enddate') ";
        $value = $payrolldb->prepare($getrecords);
        $value  = $payrolldb->fetchColumn();
        return $value;
    }

    public static  function fixedpayrolldata($company, $department, $position){
        global $payrolldb;
        $getrecords = "SELECT * FROM position WHERE company = '$company' AND department = '$department' AND positionname  = '$position' ";
        $payrolldb->prepare($getrecords);
        $value  = $payrolldb->singleRecord();
        return $value;
    }




}

?>
