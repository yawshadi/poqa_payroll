<?php

class Supportingdocuments extends tableDataObject{

  const TABLENAME = 'supportingdocs';


  public static  function getsupportingdocsbyfid($fid){
      global $payrolldb;
      $getrecords = "select * from  supportingdocs where fid = $fid ";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
      return $payrolldb->singleRecord();
  }

  public static  function getsupportingdocsbytaskid($taskid){
      global $payrolldb;
      $getrecords = "select * from  supportingdocs where taskid = $taskid ";
      $payrolldb->prepare($getrecords);
      $payrolldb->execute();
      return $payrolldb->resultSet();
  }

}

 ?>
