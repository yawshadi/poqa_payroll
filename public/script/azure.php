<?php

include('../conn/conn.php');

mysql_query("set names utf8");

$rid  = '284bb8e2-0121-4d80-adc6-ccc9085d87fb';
$cid = $_POST['cid'];

$pmth = "2017-12";


echo $from = $_POST['from'];
echo $to = $_POST['to'];
echo $comp = $_POST['comp'];



$getcustomers = mysql_query("Select * from  customers where cid = '$comp' ");
$get = mysql_fetch_array($getcustomers);
$customerid = $get['customerid'];
$tenantid = $get['tenantid'];
$company = $get['companyname'];
$customertoken = $get['token'];

/*

$delete  = mysql_query("Delete from accounts where offerid = 'MS-AZR-0145P' and date_created 
	between '$from' and '$to' and tenantid = '$tenantid' ");
	*/



/*
$delete  = mysql_query("Delete from billinglog where offerid='MS-AZR-0145P' and date_created 
	between '$from' and '$to'and customerid = '$customerid' ");
	*/
$gettoken = mysql_query("Select token from token  where  type='AD Token' ");
$t =  mysql_fetch_array($gettoken);
$token = 'Bearer'." ".$t['token'];


$url =  "https://api.partnercenter.microsoft.com/v1/customers/".$tenantid."/subscriptions";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_CAINFO, "cacert.pem");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_HTTPHEADER,
	array('Accept:application/json',
		'api-version: 2015-03-31',
		'Authorization:'.$token));
curl_setopt($ch, CURLOPT_HEADER, 0);

$response = curl_exec($ch);
$data = preg_replace('/[^(\x20-\x7F)]*/','',$response);

$obj= json_decode($data, TRUE);

for($i=0; $i<count($obj['items']); $i++){


	$parentid = $obj['items'][$i]['parent_subscription_id'];
	$offername = $obj['items'][$i]['offerName'];
	$qty = $obj['items'][$i]['quantity'];
	$status = $obj['items'][$i]['status'];
	$subid = $obj['items'][$i]['id'];
	$offerid  = $obj['items'][$i]['offerId'];
	$orderid = $obj['items'][$i]['orderId'];

	$etag = $obj['items'][$i]['etag'];
	$pid = $obj['items'][$i]['id'];
	$offeruri = substr($offer, 45, 40);


	if($offername == 'Microsoft Azure'){
		$subarray = array($subid);
		print_r($subarray);
	}

}


echo '<br/>';
//$today = date('Y-m-d');
echo $sid = $subarray[0];
//echo $sid = 'F485A8B9-DFD8-4ECC-8E20-2AE51B888903' ;
//F485A8B9-DFD8-4ECC-8E20-2AE51B88890
$offername == 'Microsoft Azure';

$nurl = "https://api.partnercenter.microsoft.com/v1/customers/".$tenantid."/subscriptions/".$sid."/utilizations/azure?start_time=".$from."&end_time=".$to."&granularity=Daily&show_details=True&size=1000";


// $url = "https://api.partnercenter.microsoft.com/v1/customers/".$tenantid."/subscriptions/".$subid."/utilizations/azure?start_time=2017-03-01&end_time=2017-03-20&granularity=Daily&show_details=True&size=100";


$chs = curl_init();
curl_setopt($chs, CURLOPT_URL, $nurl);
curl_setopt ($chs, CURLOPT_CAINFO, "cacert.pem");
curl_setopt($chs, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($chs, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chs, CURLOPT_HTTPHEADER,
	array(
		'Accept:application/json',
		'Content-type :application/json',
		'api-version: 2015-03-31',
		'Authorization:'.$token,
	));

curl_setopt($chs, CURLOPT_HEADER, 0);
$string = curl_exec($chs);
$ndata = preg_replace('/[^(\x20-\x7F)]*/','',$string);
$result = json_decode($ndata, true);

$robj= $result['items'];
// count($robj);
for($y=0; $y<count($robj); $y++){

	$start = substr($robj[$y]['usageStartTime'], 0,10);
	$end =  $robj[$y]['usageEndTime'];
	$meterid =  $robj[$y]['resource']['id'];
	$name =  $robj[$y]['resource']['name'];
	$qty =  $robj[$y]['quantity'];

	//$productname = 'Microsoft Azure'." - ". $name;
	// $billinguri = $name."-".$qty.$start;

	$getammount = mysql_query("Select amount, category, subcategory from prices where meterid = '$meterid' ");
	$am = mysql_fetch_array($getammount);
	$listedprice = $am['amount'];
	$category =  $am['category'];
	$subcategory =  $am['subcategory'];


	if( $category != ''){ $category = $am['category'].'-';}
	if( $category == ''){ $category = $am['category'];}

	if($subcategory != ''){ $subcategory = $am['subcategory'].'-';}
	if($subcategory == ''){ $subcategory = $am['subcategory'];}

	$productname = $category.' '.$subcategory.' '.$name;


	//echo $productname.'----------------------'.$id.'<br/>';


	// $insert = mysql_query("INSERT INTO billinglog (entitlement_id,offername,startdate,
	// endate,quantity,state,billinguri, customerid, company, subid, orderid, date_created,
	// offerid, mpnid, tenantid, listprice, erprice, time, parentid, meterid)
	//  values ('$subid', '$productname', '$start',
	// '$end', '$qty', 'Active', '$billinguri', '$customerid', '$company', '$sid',
	// '$orderid', '$start','MS-AZR-0145P', '1296226', '$tenantid',
	// '$listedprice', '$listedprice', '$time', '$parentid', '$meterid')") ;


}



$getaccount = mysql_query("select  * from billinglog
 where  date_created between '$from' and '$to' and  offerid = 'MS-AZR-0145P' and  tenantid = '$tenantid'
 group by  offername ");

while($ac = mysql_fetch_array($getaccount)){

	$acompany = $ac['company'];
	$adate = $ac['date_created'];

	$aoffername = $ac['offername'];
	$aofferid = $ac['offerid'];
	$atenantid = $ac['tenantid'];
	$acustomerid = $ac['customerid'];
	$astate = $ac['state'];
	$alistprice = $ac['listprice'];
	$aerprice =  $ac['erprice'];
	$aent = $ac['entitlement_id'];
	$asubid = $ac['subid'];
	$astartdate = $ac['startdate'];
	$aendate  = $ac['endate'];
	$atime = $ac['time'];
	$aorderid = $ac['orderid'];
	//$billinguri = $date.$quantity;
	$aparentid = $ac['parentid'];
	$ameterid = $ac['meterid'];

	$getquantity = mysql_query("Select sum(quantity) as sqty from billinglog where 
  date_created between '$from' and '$to' and  offerid = 'MS-AZR-0145P' and 
  company = '$acompany' and offername = '$aoffername'  ");
	$q = mysql_fetch_array($getquantity);
	$sumqty = $q['sqty'];


	$insert = mysql_query("INSERT INTO accounts (entitlement_id,offername,startdate,
						endate,quantity,state,billinguri, customerid, company, subid, orderid, date_created,
						offerid, mpnid, tenantid, listprice, erprice, time, parentid, accounttype, meterid) 
					      values ('$subid', '$aoffername', '$astartdate',
						'$aendate', '$sumqty', '$astate', '$billinguri', '$acustomerid', '$acompany', '$asubid', 
						'$aorderid', '$adate','MS-AZR-0145P', '1296226', '$atenantid', 
						'$alistprice', '$alistprice', '$atime', '$aparentid', 'Azure', '$ameterid')") or throw new frameworkError(mysql_error());




}


//echo $sid;

$getsub = mysql_query("Select * from billinglog where subid = '$sid' 
and offerid = 'MS-AZR-0145P' and date_created like '%$pmth%' order by date_created");

// group by offername, meterid");

?>




<table class='table table-bordered'>
    <tr id='myTable'>
        <td>Offer Name</td>
        <td>Quantity</td>
        <td>Date</td>

    </tr>

    <tr>
		<?php
		while($sub = mysql_fetch_array($getsub))
		{

		$datecreated = $sub['date_created'];
		$oname =   $sub['offername'];
		$ocomp =   $sub['offername'];
		$quantity = $sub['quantity'];
		/*
					   $getquantity = mysql_query("Select sum(quantity) as sqty from billinglog where
		  date_created between '$from' and '$to' and  offerid = 'MS-AZR-0145P' and
		  company = '$ocomp' and offername = '$oname'  ");
		  $q = mysql_fetch_array($getquantity);
		  $sumqty = $q['sqty'];*/

		?>

        <td><?php echo  $sub['offername']   ?></td>
        <td><?php echo $quantity   ?></td>
        <td><?php echo $sub['date_created'];   ?></td>


    </tr>
	<?php
	}
	?>


</table>






