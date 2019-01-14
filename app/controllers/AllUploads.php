<?php

class AllUploads extends Controller{

	public function browse(){
		if(isset($_POST['searchuploads'])){
			$month = $_POST['month'];
			$year = $_POST['year'];
			$searchdate = $year.'-'.$month.'-'.'01';
			$uploadtype = $_POST['uploadtype'];

			if($uploadtype == 'Office 365 Global' ){
				$of  = new OfficePrice();
				$result = $of->listOffice365($searchdate);
				$data = ['officeobj'=>$result];
				$this->view('pages/uploads', $data);

			}elseif($uploadtype == 'Client Manager'){
				$cm  = new ClientManager();
				$result = $cm->listClientManager($searchdate);
				$data = ['clientobj'=>$result];
				print_r($result);
				//$this->view('pages/uploads', $data);
			}elseif($uploadtype == 'Google'){
				$go  = new Google();
				$result = $go->listGoogle($searchdate);
				$data = ['googleobj'=>$result];
				print_r($result);
				//$this->view('pages/uploads', $data);
			}

		}
		else{
			$this->view('pages/uploads');
		}

	}

	public function office365upload(){


		if(isset($_POST['uploads'])){

			$uploads = new Uploads();
			$uploads->filename = $_FILES['file_upload'];
			$response = $uploads->upLoadFile();

			// Reading of data into DB starts here
			if($response['status'] == 'SUCCESS'){
				$cs = new CSVxlsx();
				$cs->filename = $response['filename'];
				$cs->sheetname = 'EUR';
				$cs->effectivedate = $_POST['year'].'-'.$_POST['month'].'-'.'01';
				$cs->region = $_POST['pricetype'];
				$cs->faster = true;
				$cs->headerlines = 3;
				$mspriceArr = $cs->loadFile('0365');

				$count = OfficePrice::getOfficeCount($cs->effectivedate, $cs->region);
				$counter = $count[0]->officecount;

				if($counter > 0){
				  OfficePrice::flagAllForDelete($cs->effectivedate, $cs->region);
				}

				$countinserted = 0;

				foreach ($mspriceArr as $msprice){
					$newmsoprice = new OfficePrice();
					$datarow =& $newmsoprice->recordObject;

					$labels = array(
						"offerid",
						"offername",
						"validfrom",
						"validto",
						"licensetype",
						"secondarylicensetype",
						"purchaseunit",
						"customertype",
						"listprice",
						"erpprice",
						"effective_date",
						"region"
					);

					foreach($labels as $label){
						$datarow->$label = $msprice[$label];
					}

					if(!isset($lastvalidfrom) && trim($datarow->validfrom) != ''){
						$lastvalidfrom = $datarow->validfrom;
						$lastvalidto = $datarow->validto;
					}
					if(trim($datarow->validfrom == '') && isset($lastvalidfrom)){
						$datarow->validfrom = $lastvalidfrom;
						$datarow->validto = $lastvalidto;
					}

					if(trim($datarow->offerid) != '' || $datarow->offerid != null) {
						$newmsoprice->store();
						$countinserted++;
					}

					// TODO: either here or when we read the file, properly reject bad rows

					$result[] = $newmsoprice->recordObject;

				}

				// Deleting flagged Records
				if($counter > 0){ OfficePrice::deleteFlagged();	}
				/*
				 * Prince: Note that the deleteFlagged call needs to be
				 * OUTSIDE of the foreach loop. While it did not cause an
				 * error in the loop, it caused all flagged records
				 * to be deleted after the first insert!
				 */
				if(!$deleteflagged = OfficePrice::deleteFlagged()) {
					throw new frameworkError( "STOP - problem deleting flagged office prices" );
					// todo - handle this error! roll back last insert batch?
				}

				 $uploads->removeFile($response['filename']);

				 $data = ['priceObj'=>array_filter($result)];
				 $this->view('uploads/office365upload', $data);

			}
			else{
					 $errormessage = $response['message'];
					 $data = ['errormessage'=>$errormessage];
					 $this->view('uploads/office365upload', $data);
			}

		}

		// If the page loads for the first time
		else{
			$this->view('uploads/office365upload');
		}
	}



	public function clientmanagerupload(){
		if(isset($_POST['uploadclient'])){
			$uploads = new Uploads();
			$uploads->filename = $_FILES['file_upload'];
			$response = $uploads->upLoadFile();

			if($response['status'] == 'SUCCESS'){
				$cs = new CSVxlsx();
				$cs->filename = $response['filename'];
				$cs->effectivedate = $_POST['year'].'-'.$_POST['month'].'-'.'01';
				$cs->headerlines = 1;
				$clientobj = $cs->loadFile('generic');
				$count = ClientManager::getClientMangerCount($cs->effectivedate);
				$counter = $count[0]->clientcount;

				if($counter > 0){
					ClientManager::flagAllForDelete($cs->effectivedate);
				}


				foreach($clientobj as $key=>$value){

					//TODO : This will be done in the service class
					$company = $value[0];
					$computer = $value[1];
					$clientdata = new ClientManager();
					$datarow =& $clientdata->recordObject;

					$datarow->company = trim($company);
					$datarow->hostname = trim($computer);
					$datarow->effective_date = $cs->effectivedate;
					$clientdata->store();
					$result[] = $clientdata->recordObject;
				}


				// removing file after data has been retrieved
				$uploads->removeFile($response['filename']);

				// Deleting flagged Records
				if($counter > 0){ ClientManager::deleteFlagged();	}

				$data = ['clientdata'=>$result];

				$this->view('uploads/clientmanagerupload', $data);
			}

			 else{
				    $errormessage = $response['message'];
					  $data = ['errormessage'=>$errormessage];
				    $this->view('uploads/clientmanagerupload', $data);
			 }

		}

		else{
			$this->view('uploads/clientmanagerupload');
		}
	}
	public function googleupload(){
		if(isset($_POST['googleuploads'])){
			$uploads = new Uploads();
			$uploads->filename = $_FILES['file_upload'];
			$response = $uploads->upLoadFile();

	     	if($response['status'] == 'SUCCESS'){
				$cs = new CSVxlsx();
				$cs->filename = $response['filename'];
				$cs->effectivedate = $_POST['year'].'-'.$_POST['month'].'-'.'01';
				$cs->headerlines = 10;
				$googleobj = $cs->loadFile('generic');
				$count = Google::getGoogleCount($cs->effectivedate);
				$counter = $count[0]->googlecount;

				if($counter > 0){
					Google::flagAllForDelete($cs->effectivedate);
				}


				foreach($googleobj as $key=>$value){

					//TODO : This will be done in the service class

					$product =  'apps.commehr.de';
					$domainname = $value[0];
					$ordername =  $value[1];
					//$product = $value[1];
					$description = $value[2];
					$account = $value[3];
					$intervalvalue  = $value[4].' - '. $value[5];
					$quantity  = $value[6];
					$quantity = '' ? 0 : $quantity;
					$amount = str_replace('.','',$value[8]);
					$amount = str_replace(',','.',$amount);

					 //exit;

					$googledata = new Google();
					$datarow =& $googledata->recordObject;


					$datarow->domainname = trim($domainname);
					$datarow->ordername = trim($ordername);
					$datarow->accountnumber = trim($account);
					$datarow->product = trim($product);
					$datarow->description = trim($description);
					$datarow->intervalvalue = trim($intervalvalue);
					$datarow->quantity =  str_replace('&quot;', '', trim($quantity));
					$datarow->amount =  str_replace('&quot;', '', trim($amount));
					$datarow->effective_date = $cs->effectivedate;

					if(trim($datarow->domainname) != null){
						$googledata->store();
						$result[] = $googledata->recordObject;
					}

				}

				// removing file after data has been retrieved
				$uploads->removeFile($response['filename']);
				// Deleting flagged Records
				if($counter > 0){Google::deleteFlagged(); }

				$data = ['googledata'=>$result];
				$this->view('uploads/googleupload', $data);
			}
			else{
					 $errormessage = $response['message'];
					 $data = ['errormessage'=>$errormessage];
					 $this->view('uploads/googleupload', $data);
			}

		}else{
			$this->view("uploads/googleupload");
		}

	}







}

?>
