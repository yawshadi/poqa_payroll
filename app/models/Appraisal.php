<?php

class Appraisal extends tableDataObject {

    const TABLENAME = 'appraisal_answer';


    public static function section(){
        global $payrolldb;
        $query = "SELECT * FROM appraisal_section";
        $payrolldb->prepare($query);
        return $payrolldb->resultSet();
     }

     public static function sectionQuestions($sectionid){
        global $payrolldb;
        $query = "SELECT * FROM appraisal_question JOIN appraisal_section on appraisal_question.sectionid=appraisal_section.sectionid WHERE appraisal_question.sectionid=$sectionid";
        $payrolldb->prepare($query);
        return $payrolldb->resultSet();
     }

     public static function sectionFromQuestion($questionid){
        global $payrolldb;
        $query = "SELECT  sectionid as sectionid FROM appraisal_question WHERE questionid=$questionid";
        $payrolldb->prepare($query);
        return $payrolldb->fetchColumn();
     }

     public static function answerFromQuestion($questionid,$employeeid){
        global $payrolldb;
        $query = "SELECT  answer as answer FROM appraisal_answer WHERE questionid=$questionid and employeeid='$employeeid'";
        $payrolldb->prepare($query);
        return $payrolldb->fetchColumn();
     }

     public static function sectionResult($employeeid){
        global $payrolldb;
        $query = "SELECT count(sectionid) as totalsection, sum(answer) as totalanswer, sectionid,filename from appraisal_answer where employeeid='$employeeid' GROUP BY sectionid";
        $payrolldb->prepare($query);
        return $payrolldb->resultSet();
     }

     public static function appraisalList(){
        global $payrolldb;
        $query = "SELECT * from appraisal_answer join basicinformation on appraisal_answer.employeeid = basicinformation.basic_id GROUP BY appraisal_answer.employeeid";
        $payrolldb->prepare($query);
        return $payrolldb->resultSet();
     }
}