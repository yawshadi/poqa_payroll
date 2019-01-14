<?php

class Feedback extends tableDataObject{

    const TABLENAME = 'feedback';

    public static  function getfeedback($taskid, $uid){
        global $payrolldb;
        $getrecords = "select * from  feedback where taskid = $taskid and uid = $uid ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

    public static  function getfeedbackbyTaskId($taskid){
        global $payrolldb;
        $getrecords = "select * from  feedback where taskid = $taskid ";
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }

  }


  ?>
