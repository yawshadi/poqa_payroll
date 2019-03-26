<?php

class Ajax extends Controller{


    public function departmentdata(){

        $compvalue = $_POST['compvalue'];

        $data = Department::getDepartmentByCompany($compvalue);
        $data =  json_encode ($data);
        print_r($data);

    }

    public function branchdata(){

        $bankname = $_POST['bankname'];

        $data = Bank::getBankBranch($bankname);
        $data =  json_encode ($data);
        print_r($data);

       }

    public function positiondata(){

       $compvalue = $_POST['compvalue'];
       $department = $_POST['department'];

       $data = Position::getPositionByDeparment($department, $compvalue);
       $data =  json_encode ($data);
       print_r($data);

    }

    public function deleteemployee(){

     $employeeid = $_POST['employeeid'];
     $empdelete = new Employee($employeeid);
     $empdelete->deleteFromDB();

    }

    public function deletedepartment(){

     $departmentid = $_POST['departmentid'];
     $depdelete = new Department($departmentid);
     $depdelete->deleteFromDB();

    }

    public function deleteholiday(){

      $holidayid = $_POST['holidayid'];
      $depdelete = new Holiday($holidayid);
      $depdelete->deleteFromDB();
 
     }

     public function deleteasset(){
      
            $assetid = $_POST['assetid'];
            $delete = new Assets($assetid);
            $delete->deleteFromDB();
       
           }

     public function deleteleavedays(){

      $daysid = $_POST['daysid'];
      $depdelete = new Leavedays($daysid);
      $depdelete->deleteFromDB();
 
     }

    public function deleteposition(){

     $posid = $_POST['posid'];
     $posdelete = new Position($posid);
     $posdelete->deleteFromDB();

    }

    public function deleteperiod(){

     $periodid = $_POST['periodid'];
     $posdelete = new PayPeriod($periodid);
     $posdelete->deleteFromDB();

    }

    public function deletebranch(){

     $branchid = $_POST['branchid'];
     $posdelete = new Branches($branchid);
     $posdelete->deleteFromDB();

    }

    public function deletecompany(){
        $companyid= $_POST['companyid'];
        $comdelete = new Companies($companyid);
        $comdelete->deleteFromDB();
    }

    public function deletecomp(){
        $serviceid = $_POST['serviceid'];
        $service = new ServicesData($serviceid);
        $service->deleteFromDB();
    }

    public function deletetask(){
        $taskid = $_POST['taskid'];
        $service = new Tasks($taskid);
        $service->deleteFromDB();
    }

    public function deletefolder(){
      $did = $_POST['did'];
      $service = new Document($did);
      $service->deleteFromDB();
  }

    public function feedbackresponse(){
      $fid  = $_POST['fid'];
      $fd  = new Feedback($fid);
      $feedbackdata  = $fd->recordObject;
      $data = ['feedback'=>$feedbackdata];
      $this->view('pages/feedbackresponse', $data);
    }

    public function switchcustomer(){
        $_SESSION['user_cid'] = $_POST['cid'];
        echo "session set";
        exit();
    }

    public function switchantispam(){
        $_SESSION['messagetype'] = $_POST['messagetype'];
    }

    public function updatepassword(){

      $uid  = $_POST['uid'];
      $us = new User($uid);
      $pass = md5($_POST['password']);
      $us->recordObject->pw = $pass;
      $us->store();

    }

    public function savevisaemploye($basicid = null){

      $empdata = new Employee($basicid);
      $datarow = & $empdata->recordObject;
      $datarow->firstname = $_POST['firstname'];
      $datarow->surname = $_POST['lastname'];
      $datarow->telephone = $_POST['telephone'];
      $datarow->fullname = $_POST['firstname'].' '. $_POST['lastname'];
      $datarow->dateofbirth = $_POST['dob'];
      $datarow->yearofbirth = $_POST['yearofbirth'];
      $datarow->profession = $_POST['profession'];
      $datarow->intendedprofession = $_POST['intendedprofession'];
      $datarow->passportnumber = $_POST['passportnumber'];
      $datarow->dateofpassportexpiry = $_POST['dateofpassportexpiry'];
      $datarow->dateofpassportissue = $_POST['dateofpassportissue'];
      $datarow->gender = $_POST['gender'];
      $datarow->height = $_POST['height'];
      $datarow->fathersname = $_POST['fathersname'];
      $datarow->mothersname = $_POST['mothersname'];
      $datarow->spousename = $_POST['spousename'];
      $datarow->dateofbirthofspouse = $_POST['spousedob'];
      $datarow->placeofbirthofspouse = $_POST['spouseplaceofbirth'];
      $datarow->telephoneofspouse = $_POST['spousetelephone'];
      $datarow->familyaddress = $_POST['familyaddress'];
      $datarow->numberofchildren = $_POST['numberofchildren'];
      $datarow->source = 'Visa';
      $datarow->company = $_POST['company'];
      $empdata->store();

      echo $basicid = $datarow->basic_id;

    }

    public function visacontinue($basicid){
      //$basicid  = $_POST['basicid'];
      $ba = new Employee($basicid);
      $data = $ba->recordObject;

      if(isset($_POST['visapplicantbtn'])){
        $nameofchild = $_POST['nameofchild'];
        $dobofchild = $_POST['dobofchild'];

        $comdata =  Companies::getCompany();
        $empdata =  Employee::getEmployees();
        $bkdata =  Bank::getBanks();
        $alldata =  ['companies'=>$comdata, 'employees'=>$empdata, 'banks'=>$bkdata];

        foreach($nameofchild as $key=>$n){
        		echo $name = $nameofchild[$key];
        		echo $dob = $dobofchild[$key];
        		Employee::addchildren($basicid, $name, $dob);
        	}
          exit;


        $this->view('pages/visaemployees', $data);

        }else{
        $this->view('pages/continuevisa', $data);
       }

    }

    public function recruit($basicid){
      $ru = new Employee($basicid);
      $ru->recordObject->visastatus = 1;
      $ru->store();
    }

    public function actiontransferpromo(){
      $actionid = $_POST['actionid'];
      $status = $_POST['status'];
      if($status == 'Transfer'){
        $ts = new Transfer($actionid);
        $data = $ts->recordObject;

      }elseif($status == 'Promotion'){
        $pr = new Promotion($actionid);
        $data = $pr->recordObject;
      }

      $adata  = ['pdata'=>$data, 'status'=>$status];

      $this->view('operations/promoaction', $adata);

    }

    public function actiongrievedis(){
      $actionid = $_POST['actionid'];
      $status = $_POST['status'];
      if($status == 'Grievance'){
        $ts = new Grievance($actionid);
        $data = $ts->recordObject;

      }elseif($status == 'Disciplinary'){
        $pr = new Discipline($actionid);
        $data = $pr->recordObject;
      }

      $adata  = ['pdata'=>$data, 'status'=>$status];

      $this->view('operations/actiongrievedisc', $adata);
    }



    public function actionleave(){
     $actionid = $_POST['actionid'];
     $lv = new Leave($actionid);
     $data = $lv->recordObject;
     $this->view('operations/leaveaction', $data);
    }


    public function promoupdate(){
      $actionid = $_POST['actionid'];
      $status = $_POST['status'];
      $action = $_POST['action'];
      $department = $_POST['department'];
      $position  = $_POST['position'];
      $employeeid = $_POST['employeeid'];
      if($status == 'Transfer'){
        $ts = new Transfer($actionid);
        $ts->recordObject->status = $action;
        $ts->recordObject->actiondate = date('Y-m-d');
        $ts->store();

      }elseif($status == 'Promotion'){
        $pr = new Promotion($actionid);
        $pr->recordObject->status = $action;
        $pr->recordObject->actiondate = date('Y-m-d');
        $pr->store();
      }

      if($action == 'Approve'){
        $em = new Employee($employeeid);
        $em->recordObject->department = $department;
        $em->recordObject->position = $position;
        $em->store();
      }
    }


    public function updategrievedis(){
      $actionid = $_POST['actionid'];
      $status = $_POST['status'];
      $action = $_POST['action'];
      if($status == 'Grievance'){
        $ts = new Grievance($actionid);
        $ts->recordObject->status = $action;
        $ts->recordObject->actiondate = date('Y-m-d');
        $ts->store();

      }elseif($status == 'Disciplinary'){
        $pr = new Discipline($actionid);
        $pr->recordObject->status = $action;
        $pr->recordObject->actiondate = date('Y-m-d');
        $pr->store();
      }
    }


    public function updateleave(){
      $actionid = $_POST['actionid'];
      $action = $_POST['action'];
      $ts = new Leave($actionid);
      $ts->recordObject->status = $action;
      $ts->recordObject->actiondate = date('Y-m-d');
      $ts->store();
    }

    public function approvecompany(){

      $companyid = $_POST['companyid'];
      $com  = new Companies($companyid);
      $telephone = $com->recordObject->telephone;
      $email = $com->recordObject->email;
      $com->recordObject->status = 'Approved';
      $com->store();

      $us  = new User();
      $us->recordObject->login = $email;
      $us->recordObject->email = $email;
      $us->recordObject->pw = md5($telephone);
      $us->recordObject->telephone = $telephone;
      $us->recordObject->companyid = $companyid;
      $us->recordObject->role = 'Agent';
      $us->recordObject->status = 'Active';
      $us->recordObject->parent = 'No';
      $us->store();

      sendcredentials($telephone, $email, $telephone);
    }

    public function updatedesignation(){
      $employeeid  = $_POST['employeeid'];
      $designation  = $_POST['designation'];

      $ba = new Employee($employeeid);
      $ba->recordObject->designation = $designation;
      $ba->store();

    }

    public function updatedepartment(){
        $departmentid = $_POST['departmentid'];
        $departmentname = $_POST['departmentname'];
        $departmentcode = $_POST['departmentcode'];

        $dp = new Department($departmentid);
        $dp->recordObject->departmentname = $departmentname;
        $dp->recordObject->departmentcode = $departmentcode;
        $dp->store();
        

        // update department in position
        Position::updatePositionbydepartment($departmentname);
    }

    public function updateposition(){
        $positionid = $_POST['positionid'];
        $departmentname = $_POST['departmentname'];
        $positionname = $_POST['positionname'];

        $dp = new Position($positionid);
        $dp->recordObject->department = $departmentname;
        $dp->recordObject->positionname = $positionname;
        $dp->store();

    }

    public function  updatebank(){

        $bankid  = $_POST['bankid'];
        $bankname = $_POST['bankname'];
        $bankcode  = $_POST['bankcode'];
        $branchname  = $_POST['branchname'];
        $branchcode = $_POST['branchcode'];

        $bk = new Bank($bankid);
        $bk->recordObject->bankname = $bankname;
        $bk->recordObject->bankcode = $bankcode;
        $bk->recordObject->branch = $branchname;
        $bk->recordObject->branchcode = $branchcode;
        $bk->store();

    }

}

?>
