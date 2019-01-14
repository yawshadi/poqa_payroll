<?php

class Pages extends Controller{

	public $loggedInUser;

	public function index($message = null){

		/*
		 * rewrite of login 25-2-2018 - moving all logic here to libraries/MarketplaceSession
		 */

		if(isset($_POST['login'])){
			if(!$dologin = new MarketplaceSession($_POST)){
				$this->view('pages/index',['message' => 'An unknown error occured!']);
			} else {
				$this->loggedInUser = $dologin->loginuser;
				$this->dispatch();
			}
		} elseif(isset($this->loggedInUser)) {
			$this->dispatch();
		} else {
			$this->view('pages/index');
		}
	}

	public function dispatch(){
		if(!isset($this->loggedInUser)){
			die("Error: attempt to dispatch with no \$loggedInUser");
		} else {
			$adminroles = ['administrator', 'Super administrator'];
			if($this->loggedInUser->hasRole($adminroles)){
				redirect('pages/dashboard');
			} elseif ($this->loggedInUser->hasRole('customer')){
				redirect('pages/client');
			} else {
				Core::unauthorized("Could not find user role for " . $this->loggedInUser->recordObject->email);
			}
		}
		die("Unknown error in pages dispatcher");
	}

	public function logout(){
		unset($this->loggedInUser);
		session_destroy();
		header("Location: /");
	}

	public function dashboard(){

		// Guard will immediately 403 if the user does NOT have these roles.
		new Guard($this->loggedInUser,['administrator','Super administrator']);

		$this->view( 'pages/dashboard' );

	}

	// Customers list Controller
	public function customers(){

		new Guard($this->loggedInUser,'administrator');

		$customers = Customer::listCustomers();
		$customerdata = ['records'=> $customers];
		$this->view('customers/customers', $customerdata);


	}

	public function client($othercompanyid = null){

		new Guard($this->loggedInUser,'customer');

		$customerinfo = $this->loggedInUser;
		$customerdata = $customerinfo->getUserCompanies('primary');
		$companyname = $customerdata->companyname;
		if($othercompanyid == null){
			$cid =  User::companySession($customerdata->cid);
		}else{
			$cid = $othercompanyid;
		}

		$othercustomers = $customerinfo->getUserCompanies('secondary');
		$allcustomerdata = new Customer($cid);
		$allcustomerinfo = $allcustomerdata->recordObject;

		$clientdata = ['companyname'=>$companyname, 'othercustomers'=>$othercustomers, 'customerdata'=>$allcustomerinfo];

		$this->view('pages/client', $clientdata);
	}


	// Add New Customer
	public function addnewcustomer(){

		new Guard($this->loggedInUser,'administrator');

		$this->view('customers/addnewcustomer');
		if(isset($_POST['savecustomer'])){

			$customerdata = new Customer();
			$customerdata->recordObject->companyname = $_POST['companyname'];;
			$customerdata->recordObject->commid = $_POST['commid'];
			$customerdata->recordObject->bitdefendername = $_POST['bitdefendername'];
			$customerdata->recordObject->monitoringname = $_POST['hostname'];
			$customerdata->recordObject->antispamname = $_POST['antispam'];
			$customerdata->recordObject->clientmanagername =  $_POST['clientmanagerid'];
			$customerdata->recordObject->tenantid =  $_POST['tenantid'];
			$customerdata->recordObject->discount = $_POST['microsoftdiscount'];
			$customerdata->recordObject->arrayGoogleid = $_POST['googledomain'];
			$result = $customerdata->store();

			if(is_object($result) == true){

				$successinfo = 'Customer successfully added';
				$messagedata = ['success'=> $successinfo];
				$this->view('customers/addnewcustomer', $messagedata);
			}
		}

	}

	// Edit Customer
	public function editcustomer(){

		new Guard($this->loggedInUser,'administrator');
		$customers = Customer::listCustomers();
		$customerdata = ['records'=> $customers];

		$this->view( 'customers/editcustomer', $customerdata );
	}



	// Settings Controller
	public function settings(){
		new Guard($this->loggedInUser,'administrator');
		$administrators = User::getUsersWithRole('administrator');

		// prepare our customer data before the view. Dealing with roles locked or deleted here for status.
		foreach($administrators as $admin){
			$radmin = new User($admin->uid);
			if($radmin->hasRole('deleted')){
				$radmin->recordObject->displaystatus = 'deleted';
			} elseif($radmin->hasRole('locked')){
				$radmin->recordObject->displaystatus = 'locked';
			} else {
				$radmin->recordObject->displaystatus = 'Active';
			}
			$adminsout[] = $radmin->recordObject;
		}

		$customerdata = ['records'=> $adminsout];
		$this->view('pages/settings', $customerdata);

	}

	// This controller handles all subscriptions
	public function subscriptions($type,$customerid){

		new Guard($this->loggedInUser,'administrator');
		// Calling Subscriptions API Methods
		$list = MicrosoftSubscriptions::listCustomerMicrosoftSubscriptions($type, $customerid);
		$licence = MicrosoftSubscriptions::getAvailableMicrosoftLicense('AppUserGlobal', $customerid);

		$microsoftsubdata = ['subscriptions'=>$list, 'userlicence'=>$licence];

		$this->view( 'pages/subscriptions', $microsoftsubdata );
	}

	// This controller list all google subscriptions
	public function googlesubscriptions($googleid){

		new Guard($this->loggedInUser,'administrator');

		$goo = new GoogleSubscriptions(new Google_CLient);
		$subscriptions = $goo->googleSubscription($googleid);

		//Caliing Google Subscriptions
		// TODO: Google Exception handling
		$googlesubdata = ['googlesubscriptions'=>$subscriptions];

		$this->view( 'pages/googlesubscriptions', $googlesubdata );
	}


	public function reports(){
		new Guard($this->loggedInUser,'administrator');
		$this->view('pages/reports');
	}


	public function contract(){
		new Guard($this->loggedInUser,'administrator');

		$this->view( 'pages/contract' );

	}

	public function payment(){

		new Guard($this->loggedInUser,'administrator');

		$paydata = Payment::getPaymentData();
		$paymentinfo =  ['paymentdata'=> $paydata];
		$this->view('pages/payment', $paymentinfo);

		if(isset($_POST['addpayment'])){

			$paymentname = $_POST['paymentname'];
			$paymentmode = $_POST['paymentmode'];
			$paymentgroup = $_POST['paymentgroup'];

			$paymentdata = new Payment();
			$datarow =& $paymentdata->recordObject;
			$datarow->paymentname = $paymentname;
			$datarow->paymentgroup = $paymentgroup;
			$datarow->paymentmode = $paymentmode;
			$paymentdata->store();

			$paydata = Payment::getPaymentData();
			$paymentinfo = ['paymentdata'=> $paydata];
			$this->view('pages/payment', $paymentinfo);

		}


	}
}



?>
