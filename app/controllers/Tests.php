<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 12/7/2017
 * Time: 3:03 PM
 */

class Tests extends Controller {



    public function test(){

     //$paycon = PayrollRecurrent::getRecurrentPayroll($company, $department);
    //  $t = Payperiod::getLastPayperiod('CHEC');
    //  $diff = Payperiod::comparePayPeriod('CHEC');
    //  echo $t;
    //  echo '<br/>';
    //  echo $diff;


     $lastpayperiod= Supportingdocuments::getsupportingdocsbyfid(26);
     print_r($lastpayperiod);
     // echo $payend = $lastpayperiod[0]->end;
     // echo  $paystart = $lastpayperiod[0]->start;


    }


    public function em(){
    //echo   sendEmail(SENDER_EMAIL, 'odurusphp@gmail.com', 'Testing', 'Test', 'Prince Oduro');
    	Employee::addchildren(1, 'name', '2015-09-09');
    }

    public function sms(){
      //sendTextMessage('0243029720', 'Test');
       $str = substr('0243029720', 1);
       $telephone = '233'.$str;
       echo $telephone;

    }



}
