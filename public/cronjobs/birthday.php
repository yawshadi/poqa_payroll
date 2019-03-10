<?php

include('settings.php');

class PersonalNootifications{


    public function createcrontable(){

        $getallemployees =  Employee::listAll();

        foreach ($getallemployees as $get){

            $basicid  = $get->basic_id;
            $dateofbirth = $get->dateofbirth;
            $probationend  = $get->probationend;

            $count = Cron_employee::getcount($basicid);

            if($count > 0) {
                $ce = new Cron_employee();
                $ce->recordObject->basicid = $basicid;
                $ce->recordObject->dateofbirth = $dateofbirth;
                $ce->recordObject->probationend = $probationend;
                $ce->recordObject->dateofbirthstatus = 0;
                $ce->recordObject->probationstatus = 0;
                $ce->store();
            }
        }


        return $crondata = Cron_employee::listAll();


    }


    public  function processcron(){


        $crondata = $this->createcrontable();

        $today  = date('Y-m-d');

        foreach ($crondata as $get){

            $dateofbirth = $get->dateofbirth;
            $basicid  = $get->basicid;
            $probationend  = $get->probationend;

            $emp = new Employee($basicid);
            $fullname = $emp->recordObject->fullname;
            $employeecode = $emp->recordObject->staffid;

            $systemdate = date('m-d', strtotime($today));
            $dob = date('m-d', strtotime($dateofbirth));

            if($systemdate == $dob){
                $message = "Today is the birthday of $fullname with employeeid of $employeecode. Thank you";
                sendNotification(VAMED_TELEPHONE, $message);
            }


            if($today == $probationend){
                $message = "Today is the end of probation  of $fullname with employeeid of $employeecode. Thank you";
                sendNotification(VAMED_TELEPHONE, $message);
            }


        }
    }

}

 $pn = new PersonalNootifications();

 $pn->processcron();





?>