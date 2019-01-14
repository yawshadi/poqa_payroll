<?php

class Assignedtask extends tableDataObject {

    const TABLENAME = 'taskassignment';


    public static  function getassignedTask($taskid){
      global $payrolldb;
      $getrecords = "select taskusers.*,  users.*   from taskusers inner join users on
       taskusers.uid = users.uid  where taskusers.taskid = '$taskid' ";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
      return $payrolldb->resultSet();
    }

    public static  function getallactiveTask($uid){
      global $payrolldb;
      $getrecords = "select taskassignment.*,  task.*   from taskassignment inner join task on
       taskassignment.taskid = task.id where task.uid = $uid ";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
      return $payrolldb->resultSet();
    }

    public static  function getTaskCount($taskid){
      global $payrolldb;
      $getrecords = "Select count(*) as ct from  taskassignment  where taskid = $taskid ";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
      return $payrolldb->fetchColumn();
    }

    public static  function updateAssignment($taskid, $rating, $status, $comment){
      global $payrolldb;
      $updaterecords = "UPDATE taskassignment SET taskstatus = $status,  rating = $rating, review='$comment' where taskid = $taskid ";
      $payrolldb->prepare($updaterecords);
      $payrolldb->execute();
    }

    public static  function getTaskByUser($uid){
      global $payrolldb;
      $getrecords = "select taskassignment.*,  users.uid, task.*  from taskassignment inner join users on
       taskassignment.uid = users.uid inner join task on  taskassignment.taskid = task.id
       where taskassignment.uid = '$uid' ";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
      return $payrolldb->resultSet();
    }

    public static  function getTaskstatus($taskid){
      global $payrolldb;
      $getrecords = "select taskstatus from  taskassignment where taskid = $taskid ";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
      return $payrolldb->fetchColumn();
    }

    public static  function getTaskrating($taskid){
      global $payrolldb;
      $getrecords = "select rating from  taskassignment where taskid = $taskid ";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
      return $payrolldb->fetchColumn();
    }

    public static function addtaskusers($taskid, $uid){
      global $payrolldb;
      $getrecords = "insert into taskusers (taskid, uid) values ($taskid, $uid)";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
    }

    public static function gettaskuserscount($taskid, $uid){
      global $payrolldb;
      $getrecords = "Select count(*) as ct  from taskusers where taskid = $taskid and uid = $uid ";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
      return $payrolldb->fetchColumn();
    }

    // public static  function getTaskByAssignee($uid){
    //   global $payrolldb;
    //   $getrecords = "select  users.*  from taskassignment inner join users on
    //    taskassignment.uid = users.uid inner join task on  taskassignment.taskid = task.id
    //    where taskassignment.assignee = '$uid' ";
    //   $payrolldb->prepare($getrecords);
    //   $payrolldb->execute();
    //   return $payrolldb->singleRecord();
    // }

}


?>
