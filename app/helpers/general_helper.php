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



function sendNotification($telephone, $message){

    $key="c4b012085cf6c914e538";
    $altelephone = substr($telephone, 1);
    $mestelephone = '233'.$altelephone;
    $message=urlencode($message);
    $sender_id = 'VAMED';
    $url="https://apps.mnotify.net/smsapi?key=$key&to=$mestelephone&msg=$message&sender_id=$sender_id";
    $result=file_get_contents($url);

}




function preparepaysliphtml($enddate, $fullname, $position, $ssnitnumber, $accountnumber, $branch,
                            $basicsalary, $staffssnit, $transportvehiclemaintenance, $rentallowance,
                            $grossincome, $standardovertime, $teamdevelopment,
                            $satsunholovertime, $totalbonus,$taxrelief, $taxableincome, $paye,
                            $whtonstandardovertime,$whtonsatsunholovertime, $bonustax, $totaltaxpayable,
                            $staffwelfare, $vamedwelfarenetsalary)
{

    $bankdetails  = $accountnumber. ' - '.$branch;

    $dataforemail =  "<table>
    <tr>
      <td><h1>VAMED Engineering GmbH</h1> </td>
      <td width='179' rowspan='2'> <img src='cid:vamed_logo' /></td>
    </tr>
    <tr>
      <td>Ghana Branch Office</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr style='font-weight:700'>
      <td>PAYSLIP</td>
      <td>$enddate</td>
    </tr>
    </table>
     <p></p>
  
    <table>
    <tr>
     <td width=150>Staff Name:</td>
     <td>$fullname</td>
    </tr>
    <tr>
     <td>Position:</td>
     <td>$position</td>
    </tr>

    <tr>
     <td>Social Sec. No:</td>
     <td>$ssnitnumber</td>
    </tr>

    <tr>
     <td>BBG Details:</td>
     <td>$bankdetails</td>
    </tr>

    </table>

    <hr/>
    <p></p>

    <table>

    <tr style='font-weight:700; font-size:15px'>
     <td width='300'>Basis for Calculation</td>
     <td>Total (GHs)</td>
    </tr>

    <tr style='color:#00ACE5; font-weight:700'>
     <td colspan=2>Income</td>
    </tr>


    <tr>
     <td>Basic Salary</td>
     <td>$basicsalary</td>
    </tr>

    <tr>
     <td>5.5% Staff SSNIT Contribution</td>
     <td>$staffssnit</td>
    </tr>

    <tr>
        <td>Transport Allowance</td>
        <td>$transportvehiclemaintenance</td>
    </tr>

    <tr>
        <td>Rent Allowance</td>
        <td>$rentallowance</td>
    </tr>

    <tr  style='background:#00ACE5; font-size:20px; color:#fff'>
        <td>Gross Income</td>
        <td>$grossincome</td>
    </tr>

    <tr>
     <td colspan='2'>
     <br/></td>
    </tr>

    <tr  style='color:#00ACE5; font-weight:700'>
     <td colspan=2>Bonuses</td>
    </tr>
    <tr>
     <td>50% Standard Overtime</td>
     <td>$standardovertime</td>
    </tr>
    <tr>
     <td>Team Development & Weekend Bonus</td>
      <td>$teamdevelopment</td>
    </tr>
    <tr>
     <td>Saturdays, Sundays, & Public Holidays Overtime	</td>
      <td>$satsunholovertime</td>
    </tr>
    <tr style='background:#00ACE5; font-size:15px; color:#fff'>
     <td>Total Bonuses</td>
        <td>$totalbonus</td>
    </tr>

    <tr>
     <td colspan=2><br/></td>
    </tr>

    <tr  style='color:#00ACE5; font-weight:700'>
     <td colspan=2>Deductions</td>
    </tr>
    <tr>
     <td>Tax Relief</td>
         <td>$taxrelief</td>
    </tr>
    <tr>
     <td>Taxable Income</td>
      <td>$taxableincome</td>
    </tr>
    <tr>
     <td>PAYE Tax Payable </td>
         <td>$paye</td>
    </tr>
    <tr>
     <td>WHT on Overtime</td>
      <td>$whtonstandardovertime</td>
    </tr>
    <tr>
     <td>WHT on Excess Overtime</td>
        <td>$whtonsatsunholovertime</td>
    </tr>

    <tr>
     <td>Bonus Tax</td>
         <td>$bonustax</td>
   </tr>


    <tr>
     <td>Total Tax Payable</td>
         <td> $totaltaxpayable</td>
    </tr>

    <tr>
     <td>Staff Welfare Association Contribution</td>
         <td >$staffwelfare</td>
    </tr>

    <tr>
     <td colspan=2></td>
    </tr>

    <tr  style='background:#00ACE5; font-size:15px; color:#fff'>
    <td>Net Amount Payable to Staff Account</td>
        <td> $vamedwelfarenetsalary</td>
    </tr>
  </table>";

    return $dataforemail;

}


?>
