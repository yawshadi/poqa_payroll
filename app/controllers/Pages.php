<?php

class Pages extends Controller{



	public function index(){

		if(isset($_POST['login'])){

			$email = $_POST['email'];
			$password = md5($_POST['password']);

			$usercount = User::userlogin($email, $password);

			if($usercount > 0){
				$info = User::userinfo($email);
				$status = $info->status;
				$role = $info->role;
				$uid = $info->uid;
				$cid = $info->companyid;

				if($status == 'Active' && $role == 'Administrator' ){
				$_SESSION['uid'] = $uid;
				header('Location:'.URLROOT.'/pages/dashboard');
			  }
				if($status == 'Active' && $role == 'HR Manager' ){
				$_SESSION['uid'] = $uid;
				header('Location:'.URLROOT.'/pages/dashboard');
			  }
				if($status == 'Active' && $role == 'Payroll Manager' ){
				$_SESSION['uid'] = $uid;
				header('Location:'.URLROOT.'/pages/dashboard');
				}
				if($status == 'Active' && $role == 'Site Manager' ){
				$_SESSION['uid'] = $uid;
				header('Location:'.URLROOT.'/pages/dashboard');
				}
				if($status == 'Active' && $role == 'Head of Admin' ){
				$_SESSION['uid'] = $uid;
				header('Location:'.URLROOT.'/pages/dashboard');
				}
				if($status == 'Active' && $role == 'Managing Director' ){
				$_SESSION['uid'] = $uid;
				header('Location:'.URLROOT.'/pages/dashboard');
				}
				if($status == 'Active' && $role == 'Accounts Officer' ){
					$_SESSION['uid'] = $uid;
					header('Location:'.URLROOT.'/pages/dashboard');
					}

				if($status == 'Active' && $role == 'Data Entry Clerk' ){
				$_SESSION['uid'] = $uid;
				header('Location:'.URLROOT.'/pages/visaemployees');
				}

				if($status == 'Active' && $role == 'Expatriate' ){
				$_SESSION['uid'] = $uid;
				$_SESSION['cid'] = $cid;
				header('Location:'.URLROOT.'/pages/visamasterlist');
				}

				if($status == 'Active' && $role == 'Agent' ){
				$_SESSION['uid'] = $uid;
				$_SESSION['cid'] = $cid;
				header('Location:'.URLROOT.'/pages/visamasterlist');
				}

			}else{
				$message = ['message'=>'Incorrect email or password'];
				$this->view('pages/index', $message);
			}
		}else{
		$this->view('pages/index');
		}

	}

	public function logout(){
		$uid = $_SESSION['uid'];
    session_unset($uid);
		header('Location:'.URLROOT.'/pages');
 	}



	public function dashboard(){
		 new Guard();
     $uid = $_SESSION['uid'];
		 $notifications = Assignedtask::getTaskByUser($uid);
	   $this->view('pages/dashboard', $notifications);
	}

	public function profile(){
		 new Guard();
		 $uid = $_SESSION['uid'];
		 $us = new User($uid);
		 $udata  = $us->recordObject;
		 $data = ['userdata'=>$udata];
		 $this->view('pages/profile', $data);
	}

	public function payperiod(){

		if(isset($_POST['addperiod'])){

		$prdata = new Payperiod();
		$datarow =&  $prdata->recordObject;
		$datarow->company = $_POST['company'];
		$datarow->start = $_POST['paystart'];
		$datarow->end = $_POST['payend'];
		$prdata->store();



		 $empdata =  Employee::getEmployees();


			foreach($empdata as $get){
			$basicid = $get->basic_id;
			$company = $get->company;
			$department = $get->department;
			$position = $get->position;

			$count = PayrollRecurrent::getRecurrentCheck($_POST['paystart'], $_POST['payend'], $basicid);

			if($count == 0){
			$edata = new PayrollRecurrent();
			$datarow =&  $edata->recordObject;
			$datarow->company = $company;
			$datarow->paystart = $_POST['paystart'];
			$datarow->payend= $_POST['payend'];
			$datarow->basic_id = $basicid;
			$datarow->department = $department;
			$datarow->position = $position;
			$edata->store();
			}

		 }


		$paydata = Payperiod::getPayrollPeriod();
		$comdata =  Companies::getCompany();
		$alldata =  ['Companies'=>$comdata, 'payperiod'=>$paydata];
		$this->view('pages/payperiod', $alldata);

		}else{

			$paydata = Payperiod::getPayrollPeriod();
			$comdata =  Companies::getCompany();
			$alldata =  ['Companies'=>$comdata, 'payperiod'=>$paydata];
			$this->view('pages/payperiod', $alldata);
		}

	}

	public function branchconfig(){

		$comdata =  Branches::getBranches();

		if(isset($_POST['sendbranch'])){
		$start = $_POST['start'];
		$end  = $_POST['end'];
		$attendance = $_POST['attendance'];
		$offering = $_POST['offering'];
		$tithe = $_POST['tithe'];
		$offering = $_POST['welfare'];
		$midweek = $_POST['midweek'];
		$harvest = $_POST['harvest'];
		$expenses = $_POST['expenses'];
		$welfare = $_POST['welfare'];
		$branchname = $_POST['branchname'];

		BranchRecords::deleteBranchRecords($start, $end);

		foreach($attendance as $key=>$value){

			$attendance = $value;
			$offer = $offering[$key];
			$ex = $expenses[$key];
			$tit = $tithe[$key];
			$harv = $harvest[$key];
			$mid = $midweek[$key];
			$wel = $welfare[$key];
			$brn  = $branchname[$key];


			$brndata = new BranchRecords();
			$datarow =& $brndata->recordObject;
			$datarow->branchname = $brn;
			$datarow->attendance = $attendance;
			$datarow->offering = $offer;
			$datarow->midweek = $mid;
			$datarow->welfare = $wel;
			$datarow->harvest = $harv;
			$datarow->tithe = $tit;
			$datarow->expenses = $ex;
			$datarow->startdate = $start;
			$datarow->endate = $end;
			$brndata->store();

		}

		$comdata =  Branches::getBranches();

		$message = 'Data successfully saved';

 		$alldata =  ['branchdata'=>$comdata, 'message'=>$message];
		$this->view('config/branchconfig', $alldata);

		}else{
		$alldata =  ['branchdata'=>$comdata];
		$this->view('config/branchconfig', $alldata);
		}

	}

	public function branches(){

		 $comdata =  Branches::getBranches();


		 if(isset($_POST['addbranch'])){

		   $branch = $_POST['branch'];
		   $brdata = new Branches();
		   $datarow = & $brdata->recordObject;
		   $datarow->branchname = $branch;

		   $brdata->store();

		   $comdata =  Branches::getBranches();
		   $this->view('pages/branches',  $comdata );

		 }else{
		 $this->view('pages/branches',  $comdata );
		 }

	}

	public function recurrent(){

	  $comdata =  Companies::getCompany();
	  $alldata =  ['companies'=>$comdata];

	  if(isset($_POST['getallemployees'])){

		$company = $_POST['company'];
		$department = $_POST['department'];

		$lastpayperiod = Payperiod::getLastPayperiod($_POST['company']);
		echo $startdate = $lastpayperiod[0]->start;
		echo $endate = $lastpayperiod[0]->end;

		$empdata = PayrollRecurrent::getRecurrentPayroll($company, $department, $startdate, $endate);
		$alldata =  ['companies'=>$comdata, 'employeedata'=>$empdata];
        $this->view('config/recurrent',  $alldata );

	  }else{
	  $this->view('config/recurrent',  $alldata );
	  }

	}

	public function officerrecurrent(){

 	  $comdata =  Companies::getCompany();
 	  $alldata =  ['companies'=>$comdata];

 	  if(isset($_POST['getallemployees'])){

 		$company = $_POST['company'];
 		$department = $_POST['department'];

 		$lastpayperiod = Payperiod::getLastPayperiod($_POST['company']);
 		$startdate = $lastpayperiod[0]->start;
 		$endate = $lastpayperiod[0]->end;

 		$empdata = PayrollRecurrent::getRecurrentPayroll($company, $department, $startdate, $endate, 'Officer');
 		$alldata =  ['companies'=>$comdata, 'employeedata'=>$empdata];

    $this->view('config/officerecurrent',  $alldata );

 	  }else{
 	  $this->view('config/officerecurrent',  $alldata );
 	  }

 	}

	public function employees(){

		$comdata =  Companies::getCompany();
		$empdata =  Employee::getEmployees();
		$bkdata =  Bank::getBanks();
		$alldata =  ['companies'=>$comdata, 'employees'=>$empdata, 'banks'=>$bkdata];

		if(isset($_POST['addemployee']) == 'Add'){


			$empdata = new Employee();
			$datarow = & $empdata->recordObject;
			$datarow->firstname = $_POST['firstname'];
			$datarow->surname = $_POST['lastname'];
			$datarow->othernames = $_POST['othernames'];
			$datarow->telephone = $_POST['telephone'];
			$datarow->email = $_POST['email'];
			$datarow->location = $_POST['location'];
			$datarow->idtype = $_POST['idtype'];
			$datarow->idnumber = $_POST['idnumber'];
			$datarow->bankname = $_POST['bankname'];
			$datarow->accountnumber = $_POST['accountnumber'];
			$datarow->branch = $_POST['branch'];
			$datarow->ssnitnumber = $_POST['ssnitnumber'];
			$datarow->gaurantor = $_POST['gname'];
			$datarow->gaurantor_telephone = $_POST['gtelephone'];
			$datarow->fullname = $_POST['firstname'].' '. $_POST['lastname'];
			$datarow->dateofbirth = $_POST['dob'];
			$datarow->department = $_POST['department'];
			$datarow->position = $_POST['position'];
			$datarow->staffid = $_POST['staffid'];
			$datarow->hiredate = $_POST['hiredate'];
			$datarow->probationstart = $_POST['probationstart'];
			$datarow->probationend = $_POST['probationend'];
			$datarow->company = $_POST['company'];
			$datarow->tinnumber = $_POST['tinnumber'];
			$datarow->tiernumber = $_POST['tierno'];

			$datarow->nationality = $_POST['nationality'];
			$datarow->academictitle = $_POST['academictitle'];
			$datarow->contractallocation = $_POST['contractallocation'];
			$datarow->contractstart = $_POST['contractstart'];
			$datarow->contractend = $_POST['contractend'];
			$datarow->entrydate = $_POST['entrydate'];
			$datarow->exitdate = $_POST['exitdate'];
			$datarow->gender = $_POST['gender'];
			$datarow->category = $_POST['category'];
			$datarow->basicsalary = $_POST['basicsalary'];
			$datarow->randomnumber = $_POST['randomnumber'];
			$datarow->maritalstatus = $_POST['maritalstatus'];


			$empdata->store();
			$basicid = $datarow->basic_id;

			$lastpayperiod = Payperiod::getLastPayperiod($_POST['company']);
			$payend = $lastpayperiod[0]->end;
			$paystart = $lastpayperiod[0]->start;

			$redata = new PayrollRecurrent();
			$rerow = & $redata->recordObject;
			$rerow->company = $_POST['company'];
			$rerow->department = $_POST['department'];
			$rerow->basic_id =  $basicid;
			$rerow->paystart =  $paystart;
			$rerow->payend =  $payend;
			$redata->store();

		}

	    $this->view('pages/employee', $alldata);
	}

	public function visaemployees(){

		$cid = $_SESSION['cid'];
		$co = new Companies($cid);
		$company  = $co->recordObject->companyname;

		$comdata =  Companies::getCompany();
		$empdata =  Employee::getvisaemployees($company);
		$bkdata =  Bank::getBanks();

		$n = new User($_SESSION['uid']);
		$role = $n->recordObject->role;

		$alldata =  ['companies'=>$comdata, 'employees'=>$empdata, 'banks'=>$bkdata, 'company'=>$company, 'role'=>$role ];

		$this->view('pages/visaemployee', $alldata);
	}



	public function bankcodes(){
		$bankdata =  Bank::getBankCodes();
		$alldata =  ['banks'=>$bankdata];

		if(isset($_POST['addbank'])){
			$bk = new Bank();
			$bk->recordObject->bankcode = $_POST['bankcode'];
			$bk->recordObject->bankname = $_POST['bankname'];
			$bk->recordObject->branchcode = $_POST['branchcode'];
			$bk->recordObject->branch = $_POST['branchname'];
			$bk->store();
			$this->view('pages/bankcodes', $alldata);
		}else{
			$this->view('pages/bankcodes', $alldata);
		}

	}

	public function Companies(){

    if(isset($_POST['addcompany'])){

			$companydata = new Companies();
			$companydata->recordObject->companyname = $_POST['companyname'];
			$companydata->store();

			$comdata =  Companies::getCompany();
			$this->view('pages/company', $comdata) ;

	   }else{
		 $comdata = Companies::getCompany();
		 $this->view('pages/company', $comdata);
	 }


	}

	public function departments(){

		$comdata =  Companies::getCompany();
		$depdata =  Department::getDepartment();
		//$alldata = ['companies'=>$comdata, 'departments'=>$depdata];

		if(isset($_POST['addepartment'])){

		$depdata = new Department();
		$datarow =&  $depdata->recordObject;
		$datarow->company = $_POST['companyname'];
		$datarow->departmentname = $_POST['departmentname'];
		$datarow->departmentcode = $_POST['departmentcode'];
		$depdata->store();

		$comdata =  Companies::getCompany();
		$depdata =  Department::getDepartment();

		$alldata = ['Companies'=>$comdata, 'departments'=>$depdata];
		$this->view('pages/departments', $alldata) ;

		}else{
			// $comdata =  Companies::getCompany();
			// $depdata =  Department::getDepartment();
			$alldata = ['companies'=>$comdata, 'departments'=>$depdata];
			$this->view('pages/departments', $alldata);
		}


	}


	public function positions(){

		$comdata =  Companies::getCompany();
		$depdata =  Department::getDepartment();
		$posdata =  Position::getPosition();
		$alldata = ['companies'=>$comdata, 'departments'=>$depdata, 'positions'=> $posdata];

		if(isset($_POST['addposition'])){

		$psdata = new Position();
		$datarow =&  $psdata->recordObject;
		$datarow->company = $_POST['company'];
		$datarow->department = $_POST['department'];
		$datarow->positionname = $_POST['position'];
		$psdata->store();

		$comdata =  Companies::getCompany();
		$depdata =  Department::getDepartment();
		$posdata =  Position::getPosition();
		$alldata = ['companies'=>$comdata, 'departments'=>$depdata, 'positions'=> $posdata];

		$this->view('pages/positions', $alldata) ;

		}else{
			$comdata =  Companies::getCompany();
			$depdata =  Department::getDepartment();
			$posdata =  Position::getPosition();
			$alldata = ['companies'=>$comdata, 'departments'=>$depdata, 'positions'=> $posdata];

			$this->view('pages/positions', $alldata);
		}


	}


	public function editemployee($employeeid){

		$comdata =  Companies::getCompany();
		$allempdata =  Employee::getEmployees();
		$bkdata =  Bank::getBanks();
		$empdata = Employee::getEmployeesById($employeeid);

		if(isset($_POST['updateemployeebtn'])){

			$empdata = new Employee($employeeid);
			$datarow = & $empdata->recordObject;
			$datarow->firstname = $_POST['firstname'];
			$datarow->surname = $_POST['lastname'];
			$datarow->othernames = $_POST['othernames'];
			$datarow->telephone = $_POST['telephone'];
			$datarow->email = $_POST['email'];
			$datarow->location = $_POST['location'];
			$datarow->idtype = $_POST['idtype'];
			$datarow->idnumber = $_POST['idnumber'];
			$datarow->bankname = $_POST['bankname'];
			$datarow->accountnumber = $_POST['accountnumber'];
			$datarow->branch = $_POST['branch'];
			$datarow->ssnitnumber = $_POST['ssnitnumber'];
			$datarow->gaurantor = $_POST['gname'];
			$datarow->gaurantor_telephone = $_POST['gtelephone'];
			$datarow->fullname = $_POST['firstname'].' '. $_POST['lastname'];
			$datarow->dateofbirth = $_POST['dob'];
			$datarow->department = $_POST['department'];
			$datarow->position = $_POST['position'];
			$datarow->staffid = $_POST['staffid'];
			$datarow->hiredate = $_POST['hiredate'];
			$datarow->probationstart = $_POST['probationstart'];
			$datarow->probationend = $_POST['probationend'];
			$datarow->company = $_POST['company'];
			$datarow->tinnumber = $_POST['tinnumber'];
			$datarow->tiernumber = $_POST['tierno'];

			$datarow->nationality = $_POST['nationality'];
			$datarow->academictitle = $_POST['academictitle'];
			$datarow->contractallocation = $_POST['contractallocation'];
			$datarow->contractstart = $_POST['contractstart'];
			$datarow->contractend = $_POST['contractend'];
			$datarow->entrydate = $_POST['entrydate'];
			$datarow->exitdate = $_POST['exitdate'];
			$datarow->gender = $_POST['gender'];
			$datarow->category = $_POST['category'];
			$datarow->basicsalary = $_POST['basicsalary'];
			$datarow->randomnumber = $_POST['randomnumber'];
			$datarow->maritalstatus = $_POST['maritalstatus'];

			$empdata->store();



			$comdata =  Companies::getCompany();
			$allempdata =  Employee::getEmployees();
			$bkdata =  Bank::getBanks();
			$empdata = Employee::getEmployeesById($employeeid);
			$alldata =  ['companies'=>$comdata, 'employees'=>$empdata, 'allemployees'=>$allempdata,  'banks'=>$bkdata];

			$this->view('pages/employedit', $alldata );

		}


		$alldata =  ['companies'=>$comdata, 'employees'=>$empdata, 'allemployees'=>$allempdata,  'banks'=>$bkdata];
		$this->view('pages/employedit', $alldata );
	}

	public function updateemployee(){



	}




	public function manageusers(){

		$alluserdata =  User::getUsers();
		$this->view( 'pages/manageusers', $alluserdata);
	}


	public function adduser(){

		$alluserdata =  User::getUsers();

		if(isset($_POST['adduser'])){

			$usercount = User::checkUserExist($_POST['email']);

			if($usercount == 0){

            $userdata = new User();
            $datarow =&  $userdata->recordObject;
            $datarow->username = $_POST['email'];
            $datarow->email = $_POST['email'];
            $datarow->lastname = $_POST['lastname'];
            $datarow->firstname =  $_POST['firstname'];
						$datarow->password = User::encryptPassword($_POST['password']);
						$datarow->status = 1;
						$datarow->accesslevel = 2;
            $datarow->datecreated = date('Y-m-d');
		      	$userdata->store();


			$alluserdata =  User::getUsers();
			$dataresponse  = ['customerdata'=>$alluserdata, 'response'=>'User successfully addded', 'class'=>'aler alert-success'];
			$this->view( 'pages/adduser', $dataresponse);

			}else{
				$alluserdata =  User::getUsers();
				$dataresponse  = ['customerdata'=>$alluserdata, 'response'=>'Error adding User. Email may exist already', 'class'=>'aler alert-danger'];
				$this->view( 'pages/adduser', $dataresponse );

			}



		}else{
		$dataresponse  = ['customerdata'=>$alluserdata];
		$this->view( 'pages/adduser', $dataresponse);
		}

	}

	public function createuser(){

			  if(isset($_POST['adduser'])){
					$comdata =  Companies::getCompany();
          $email = $_POST['email'];
			  	$usercount = User::checkUserExist($email);
	        if($usercount == 0){
				  $password = User::encryptPassword($_POST['password']);
				  $userdata = new User();
				  $userdata->recordObject->firstname = $_POST['firstname'];
				  $userdata->recordObject->surname = $_POST['lastname'];
				  $userdata->recordObject->telephone = $_POST['telephone'];
				  $userdata->recordObject->email = $_POST['email'];
				  $userdata->recordObject->pw = $password;
				  $userdata->recordObject->role = $_POST['role'];
					$userdata->recordObject->login = $_POST['email'];
					$userdata->recordObject->status = 'Active';
					$userdata->recordObject->companyid = $_POST['company'] ;
					$userdata->recordObject->parent = $_POST['parent'] ;
				  $userdata->store();

				  $message = 'User Successfully Enrolled';
				  $messagedata = ['messagedata'=>$message, 'class'=>'alert alert-success', 'companies'=>$comdata];
				  $this->view( 'users/addadmin', $messagedata);
				}else {
					$message = 'Error Adding User';
				  $messagedata = ['messagedata'=>$message, 'class'=>'alert alert-danger', 'companies'=>$comdata];
				  $this->view( 'users/addadmin', $messagedata);
				}

			  }else{
				$comdata =  Companies::getCompany();
				$data = ['companies'=>$comdata];
			  $this->view('users/addadmin', $data);
			  }
	}


	public function userlist(){
		$allusers  = User::ListAll();
		$userdata = ['users'=> $allusers ];
		$this->view('users/userlist', $userdata);
	}

	public function edituser($userid){
		$userdata  = new User($userid);
		$userdata  = $userdata->recordObject;
		$udata = ['userdata'=>$userdata];

		 if(isset($_POST['updateuser'])){
			 $userdata  = new User($userid);
			 $alluserdata  = $userdata->recordObject;
			 $userdata->recordObject->firstname = $_POST['firstname'];
			 $userdata->recordObject->surname = $_POST['lastname'];
			 $userdata->recordObject->telephone = $_POST['telephone'];
			 $userdata->recordObject->email = $_POST['email'];
			 $userdata->recordObject->role = $_POST['role'];
			 $userdata->recordObject->login = $_POST['email'];
			 $userdata->recordObject->status = $_POST['status'];
			 $userdata->store();
       $udata = ['userdata'=>$alluserdata, 'message'=>'User successfully updated'];
       $this->view('users/edituser',  $udata);

		 }else{
			 $this->view('users/edituser', $udata);
		 }


	}


	public function savepassport($basicid,$did=null){

			$filedata = $_FILES['Filedata'];
			$filedoc = $_POST['filedoc'];
			$uploads = new Uploads();
			$uploads->filename = $_FILES['Filedata'];
			$uploadresponse = $uploads->upLoadFile($filedoc);
			if($uploadresponse['status'] == 'SUCCESS'){
				 $docname = $uploadresponse['filename'];
				 $docdata = new Document($did);
				 $size = $_FILES['Filedata']['size'];
				 $type = $_FILES['Filedata']['type'];
				 $name = $_FILES['Filedata']['name'];
				 $docdate = date('Y-m-d');
				 $doc =&   $docdata->recordObject;
				 $doc->name = $name;
				 $doc->newname = $docname;
				 $doc->type = $type;
				 $doc->size = $size;
				 $doc->doctype = 'passport';
				 $doc->docdate = $docdate;
				 $doc->basicid = $basicid;
				 $docdata->store();
			}else{
				echo 'Error uploading document';
			}

	}


	public function savesupporting($basicid){

			$filedata = $_FILES['Filedata'];
			$filedoc = $_POST['filedoc'];
			$uploads = new Uploads();
			$uploads->filename = $_FILES['Filedata'];
			$uploadresponse = $uploads->upLoadFile($filedoc);
			if($uploadresponse['status'] == 'SUCCESS'){
				 $docname = $uploadresponse['filename'];
				 $docdata = new Document();
				 $size = $_FILES['Filedata']['size'];
				 $type = $_FILES['Filedata']['type'];
				 $name = $_FILES['Filedata']['name'];
				 $docdate = date('Y-m-d');
				 $doc =&   $docdata->recordObject;
				 $doc->name = $name;
				 $doc->newname = $docname;
				 $doc->type = $type;
				 $doc->size = $size;
				 $doc->docdate = $docdate;
				 $doc->doctype = 'supporting';
				 $doc->basicid = $basicid;
				 $docdata->store();
			}else{
				echo 'Error uploading document';
			}

	}

	public function employeeprofile($basicid){
		$ba = new Employee($basicid);
		$basicdata  = $ba->recordObject;
		$passport = Document::getPassportbyBasicid($basicid);
		$supportdoc = Document::getSuportingbyBasicid($basicid);
		$data = ['basicdata'=>$basicdata, 'passport'=>$passport, 'supportingdoc'=>$supportdoc ];
		$this->view('pages/employeeprofile', $data);
	}

	public function visamasterlist(){
		$cid = $_SESSION['cid'];
		$co = new Companies($cid);
		$company  = $co->recordObject->companyname;

		$basicdata =  Employee::getvisaemployees($company);
		$data = ['basicdata'=>$basicdata ];
		$this->view('pages/visamasterlist', $data);
	}

	public function pdfprofile($basicid){
		$ba = new Employee($basicid);
		$basicdata  = $ba->recordObject;
		$passport = Document::getPassportbyBasicid($basicid);
		$supportdoc = Document::getSuportingbyBasicid($basicid);
		$data = ['basicdata'=>$basicdata, 'passport'=>$passport, 'supportingdoc'=>$supportdoc ];
		$this->view('pages/pdfprofile', $data);
	}

	public function visaemployeeedit($basicid){
		$ba = new Employee($basicid);
		$comdata =  Companies::getCompany();
		$basicdata  = $ba->recordObject;
		$passport = Document::getPassportbyBasicid($basicid);
		$supportdoc = Document::getSuportingbyBasicid($basicid);
		$data = ['basicdata'=>$basicdata, 'passport'=>$passport, 'supportingdoc'=>$supportdoc, 'companies'=>$comdata ];
		$this->view('pages/visaemployeeedit', $data);
	}


	public function updatesavepassport($did){

			$filedata = $_FILES['Filedata'];
			$uploads = new Uploads();
			$uploads->filename = $_FILES['Filedata'];
			$uploadresponse = $uploads->upLoadFile($filedoc);
			if($uploadresponse['status'] == 'SUCCESS'){
				 $docname = $uploadresponse['filename'];
				 $docdata = new Document($did);
				 $size = $_FILES['Filedata']['size'];
				 $type = $_FILES['Filedata']['type'];
				 $name = $_FILES['Filedata']['name'];
				 $docdate = date('Y-m-d');
				 $doc =&   $docdata->recordObject;
				 $doc->name = $name;
				 $doc->newname = $docname;
				 $doc->type = $type;
				 $doc->size = $size;
				 $doc->doctype = 'passport';
				 $doc->docdate = $docdate;
				 $doc->basicid = $basicid;
				 $docdata->store();
			}else{
				echo 'Error uploading document';
			}

	}


	public function updatesavesupporting($did){

			$filedata = $_FILES['Filedata'];
			$uploads = new Uploads();
			$uploads->filename = $_FILES['Filedata'];
			$uploadresponse = $uploads->upLoadFile($filedoc);
			if($uploadresponse['status'] == 'SUCCESS'){
				 $docname = $uploadresponse['filename'];
				 $docdata = new Document($did);
				 $size = $_FILES['Filedata']['size'];
				 $type = $_FILES['Filedata']['type'];
				 $name = $_FILES['Filedata']['name'];
				 $docdate = date('Y-m-d');
				 $doc =&   $docdata->recordObject;
				 $doc->name = $name;
				 $doc->newname = $docname;
				 $doc->type = $type;
				 $doc->size = $size;
				 $doc->docdate = $docdate;
				 $doc->doctype = 'supporting';
				 $doc->basicid = $basicid;
				 $docdata->store();
			}else{
				echo 'Error uploading document';
			}

	}

	public function fullprofile($employeeid = null){

		$em = new Employee($employeeid);
		$empdata = $em->recordObject;
		$grievancedata = Grievance::getGrievance($employeeid);
		$transferdata = Transfer::getTransfers($employeeid);
		$leavedata = Leave::getLeave($employeeid);
		$assetdata = Assets::getAssets($employeeid);
		$promotiondata = Promotion::getPromotion($employeeid);
		$disciplinedata = Discipline::getDiscipline($employeeid);
		$passport = Document::getPassportbyBasicid($employeeid);

		$data = ['empdata'=>$empdata, 'grievancedata'=>$grievancedata, 'leavedata'=>$leavedata,
		          'transferdata'=>$transferdata, 'promotiondata'=> $promotiondata,
							'disciplinedata'=>$disciplinedata, 'passport'=>$passport,'assetdata'=>$assetdata ];

		$this->view('pages/fullprofile', $data);


	}


	public function registration(){

				if(isset($_POST['registeragent'])){
					$com  = new Companies();

					$comsave =& $com->recordObject;


					$comsave->companyname = $_POST['company'];
					$comsave->companylogo = '';
					$comsave->principalactivity = $_POST['activity'];
					$comsave->telephone = $_POST['telephone'];
					$comsave->email = $_POST['email'];
					$comsave->country = $_POST['country'];
					$comsave->repname = $_POST['aname'];
					$comsave->reptelephone = $_POST['atelephone'];
					$comsave->manpower = $_POST['manpower'];
					$comsave->postaladdress = $_POST['postal'];
					$comsave->role = 'Agent';
					$comsave->status = 'pending';
					$com->store();

				  $companyid  = $comsave->companyid ;
					header('Location:'.URLROOT.'/pages/regupload/'.$companyid);

				}else{
			  	$this->view('pages/registration');
			}
	}

	public function regupload($companyid = null){
			$this->view('pages/regupload', $companyid);
	}

	public function regsuccess(){
			$this->view('pages/regsuccess');
	}

	public function savebusinessdocs($companyid){

		 $filedata = $_FILES['Filedata'];

		 $filedoc = $_POST['filedoc'];
		 $uploads = new Uploads();
		 $uploads->filename = $_FILES['Filedata'];
		 $uploadresponse = $uploads->upLoadFile($filedoc);

		 $docname = $uploadresponse['filename'];
		 $size = $_FILES['Filedata']['size'];
		 $type = $_FILES['Filedata']['type'];
		 $name = $_FILES['Filedata']['name'];
		 $docdate = date('Y-m-d');

		 $docdata = new Document();
		 $doc =&   $docdata->recordObject;
		 $doc->name = $name;
		 $doc->newname = $docname;
		 $doc->type = $type;
		 $doc->size = $size;
		 $doc->docdate = $docdate;
		 $doc->companyid = $companyid;
		 $docdata->store();

	}

	public function agents($status){
		 $compdata = Companies::getAgent($status);
		 $data = ['compdata'=>$compdata, 'status'=>$status];
		 $this->view('users/agent', $data);
	}

	public function companyprofile($companyid){
		 $com = new Companies($companyid);
		 $compdata = $com->recordObject;

		 $docdata = Document::getcompanydocument($companyid);

		 $data = ['compdata'=>$compdata, 'docdata'=>$docdata];
		 $this->view('users/companyprofile', $data);
	}

	public function designation(){
		$empdata =  Employee::getEmployees();

		$alldata =  ['employees'=>$empdata ];
    $this->view('pages/designation', $alldata);
	}


	public function searchemployee(){
		if(isset($_GET['term'])) $query=$_GET['term'];
        if(isset($_GET['request'])) $request=$_GET['request'];
        $employeejson=Employee::searchemployee($query,$request);
        $employeedata=[];
        foreach($employeejson as $get){

            $name = $get->firstname.' '.$get->surname;
            $employeeid = $get->basic_id;
            $employeedata[] = array("id"=>$employeeid,"name"=>$name);
        }
        echo json_encode($employeedata);
	}


public function marital(){
	$randomnumber = $_POST['randomnumber'];
	$maritaldata = Marital::maritaldata($randomnumber);
	if(!is_object($maritaldata)){
		$maritalid = null;
	}else{
		$maritalid = $maritaldata->maritalid;
	} 
	if(isset($_POST['mode'])){

		$marital = new Marital($maritalid);
		$doc =&   $marital->recordObject;
		$doc->spouse = $_POST['spouse'];
		$doc->spousecontact = $_POST['contact'];
		$doc->first = $_POST['first'];
		$doc->second = $_POST['second'];
		$doc->third = $_POST['third'];
		$doc->fourth = $_POST['fourth'];
		$doc->randomnumber = $randomnumber;
		$marital->store();
		
	}else{
		$viewdata = array("randomnumber"=>$randomnumber,"maritaldata"=>$maritaldata);
		$this->view('pages/maritalform',$viewdata);

	}
	}

	public function folder(){
		$randomnumber = $_POST['randomnumber'];
		$documents = Document::getemployeefolder($randomnumber);
		$viewdata = array("randomnumber"=>$randomnumber,"document"=>$documents);
		$this->view('pages/folderform',$viewdata);
	}

	public function folderupload(){
		$filedata = $_FILES['Filedata'];
		 $documentname = $_POST['filename'];
		 $randomnumber = $_POST['randomnumber'];
		 $uploads = new Uploads();
		 $uploads->filename = $_FILES['Filedata'];
		 $uploadresponse = $uploads->upLoadFile();

		 $docname = $uploadresponse['filename'];
		 $size = $_FILES['Filedata']['size'];
		 $type = $_FILES['Filedata']['type'];
		 $name = $_FILES['Filedata']['name'];
		 $docdate = date('Y-m-d');
		 $docdata = new Document();
		 $doc =&   $docdata->recordObject;
		 $doc->name = $name;
		 $doc->newname = $docname;
		 $doc->type = $type;
		 $doc->size = $size;
		 $doc->docdate = $docdate;
		 $doc->documentname = $documentname;
		 $doc->randomnumber = $randomnumber;
		 $docdata->store();
	}




	public function currency(){

        if(isset($_POST['updaterates'])){

            $pounds = $_POST['pounds'];
            $dollars = $_POST['dollars'];
            $euros = $_POST['euros'];

            $ex = new Exchangerates('1');
			$ex->recordObject->pounds = $pounds;
            $ex->recordObject->dollars = $dollars;
            $ex->recordObject->euros = $euros;
            $ex->store();

        	$data = ['pounds'=>$pounds, 'dollars'=>$dollars, 'euros'=>$euros];
            $this->view('pages/currency', $data);

		}else{

        	$ex = new Exchangerates('1');
        	$pounds = $ex->recordObject->pounds;
            $dollars = $ex->recordObject->dollars;
            $euros = $ex->recordObject->euros;

            $data = ['pounds'=>$pounds, 'dollars'=>$dollars, 'euros'=>$euros];
            $this->view('pages/currency', $data);
		}

	}


	public function editdepartment(){
		$departmentid  = $_POST['departmentid'];
		$dp = new Department($departmentid);
		$data  = $dp->recordObject;
		$this->view('pages/editdepartment', $data);
	}

    public function editposition(){
        $positionid  = $_POST['positionid'];
        $po = new Position($positionid);
        $postiondata  = $po->recordObject;
		$departmentdata = Department::listAll();
		$data = ['positiondata'=>$postiondata, 'departmentdata'=>$departmentdata];

        $this->view('pages/editposition', $data);
    }

    public function editbank(){
        $bankid  = $_POST['bankid'];
        $ba = new Bank($bankid);
        $bankdata  = $ba->recordObject;
        $data = ['bankdata'=>$bankdata];

        $this->view('pages/editbank', $data);
    }


}



?>
