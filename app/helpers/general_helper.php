<?php


function months(){
    $mtharr  = array('Jan'=>'01', 'Feb'=>'02',
    'Mar'=>'03','Apr'=>'04', 'May'=>'05', 'Jun'=>'06', 'Jul'=>'07','Aug'=>'08',
    'Sep'=>'09', 'Oct'=>'10', 'Nov'=>'11', 'Dec'=>'12');
    return $mtharr;
}


function payround($item){
 return number_format(round($item,2),2);
}



function getYear(){
    for($y=2015; $y<=date('Y'); $y++){
        $years[] = $y;
    }
    return $years;
}


function sendTextMessage($telephone, $title){

  $key="c4b012085cf6c914e538";
  $altelephone = substr($telephone, 1);
  $mestelephone = '233'.$altelephone;
  $message = 'You have been assigned a task labelled '.$title. '.'.
             'Please verify and work on it. Thank you';
  $message=urlencode($message);
  $sender_id = 'LABOR POWER';
  $url="https://apps.mnotify.net/smsapi?key=$key&to=$mestelephone&msg=$message&sender_id=$sender_id";
  $result=file_get_contents($url);

}


function sendGrievanceText($telephone, $title){

  $key="c4b012085cf6c914e538";
  $altelephone = substr($telephone, 1);
  $mestelephone = '233'.$altelephone;
  $message = 'You have received an employee '.$title. ' . Thank you';
  $message=urlencode($message);
  $sender_id = 'LABOR POWER';
  $url="https://apps.mnotify.net/smsapi?key=$key&to=$mestelephone&msg=$message&sender_id=$sender_id";
  $result=file_get_contents($url);

}


function receiveTextMessage($telephone, $title){

  $key="c4b012085cf6c914e538";
  $altelephone = substr($telephone, 1);
  $mestelephone = '233'.$altelephone;
  $message = 'Feedback on task '.$title. '. Please log in to your account and verify'.
             'Thank you';
  $message=urlencode($message);
  $sender_id = 'LABOR POWER';
  $url="https://apps.mnotify.net/smsapi?key=$key&to=$mestelephone&msg=$message&sender_id=$sender_id";
  $result=file_get_contents($url);

}




function sendcredentials($telephone, $username, $password){

  $key="c4b012085cf6c914e538";
  $altelephone = substr($telephone, 1);
  $mestelephone = '233'.$altelephone;
  $message = 'Use this credentials tolog in. Username:' . $username. ' password: ' .$password;
             'Thank you';
  $message=urlencode($message);
  $sender_id = 'LABOR POWER';
  $url="https://apps.mnotify.net/smsapi?key=$key&to=$mestelephone&msg=$message&sender_id=$sender_id";
  $result=file_get_contents($url);

}


?>
