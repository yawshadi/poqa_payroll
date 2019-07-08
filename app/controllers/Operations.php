<?php

class Operations extends Controller{

     public function index (){

       $assetcount = Assets::getCount('All');
       $leavecount = Leave::getCount('All');
       $transfercount =  Transfer::getCount('All');
       $promotioncount =  Promotion::getCount('All');
       $disciplinecount =  Discipline::getCount('All');
       $grievancecount = Grievance::getCount('All');
       $appraisal = sizeof(Appraisal::appraisalList());

       $data = ['assetcount'=>$assetcount,'leavecount'=> $leavecount, 'transfercount'=> $transfercount, 'promotioncount'=>$promotioncount, 'grievancecount'=>$grievancecount,
               'disciplinecount'=>$disciplinecount,'appraisalcount'=>$appraisal];

       $this->view('operations/odashboard', $data);
     }

     public function operationprofile($type, $id){

       if($type == 'Grievance'){
         $dt = new Grievance($id);
         $opdata = $dt->recordObject;
         $opusers =  Grievance::getgrievanceusers($id);
         $data = ['opdata'=>$opdata, 'opusers'=>$opusers];
         $this->view('operations/goperationprofile', $data);
       }

       if($type == 'Transfer'){
         $dt = new Transfer($id);
         $opdata = $dt->recordObject;
         $opusers =  Transfer::gettransferusers($id);
         $data = ['opdata'=>$opdata, 'opusers'=>$opusers];
         $this->view('operations/operationprofile', $data);
       }

       if($type == 'Leave'){
         if($id == 'undefined') {
           Redirecting::location('operations/operationsview/Leave');
         }
         $dt = new Leave($id);
         $opdata = $dt->recordObject;
         $opusers =  Leave::getleaveusers($id);
         $data = ['opdata'=>$opdata, 'opusers'=>$opusers];
         $this->view('operations/leaveprofile', $data);
       }

       if($type == 'assets'){
        $dt = new Assets($id);
        $opusers =  Assets::getassetusers($id);        
        $opdata = $dt->recordObject;
        $data = ['opdata'=>$opdata, 'opusers'=>$opusers];
        $this->view('operations/assetsprofile', $data);
      }

       if($type == 'Disciplinary'){
         $dt = new Discipline($id);
         $opdata = $dt->recordObject;
         $opusers =  Discipline::getdisciplineusers($id);
         $data = ['opdata'=>$opdata, 'opusers'=>$opusers];
         $this->view('operations/goperationprofile', $data);

       }

       if($type == 'Promotion'){
         $dt = new Promotion($id);
         $opdata = $dt->recordObject;
         $opusers =  Promotion::getpromotionusers($id);
         $data = ['opdata'=>$opdata, 'opusers'=>$opusers];
         $this->view('operations/operationprofile', $data);
       }


     }


     public function operationsview($status){
         if($status  == 'Grievance'){
           $listdata = Grievance::ListAll();
           $data = ['status'=>$status, 'listdata'=>$listdata];
           $this->view('operations/operationviews', $data);
         }

         if($status  == 'Transfer'){
           $listdata = Transfer::ListAll();
           $data = ['status'=>$status, 'listdata'=>$listdata];
           $this->view('operations/transferpromoview', $data);
         }

         if($status  == 'Leave'){
           $listdata = Leave::ListAll();
           $data = ['status'=>$status, 'listdata'=>$listdata];
           $this->view('operations/leaveview', $data);
         }

         if($status  == 'Disciplinary'){
           $listdata = Discipline::ListAll();
           $data = ['status'=>$status, 'listdata'=>$listdata];
           $this->view('operations/operationviews', $data);
         }

         if($status  == 'Promotion'){
           $listdata = Promotion::ListAll();
           $data = ['status'=>$status, 'listdata'=>$listdata];
           $this->view('operations/transferpromoview', $data);
         }
         if($status  == 'Assets'){
          $listdata = Assets::ListAll();
          $data = ['status'=>$status, 'listdata'=>$listdata];
          $this->view('operations/assetsview', $data);
        }

        if($status  == 'Appraisal'){
          $listdata = Appraisal::appraisalList();
          $data = ['status'=>$status, 'listdata'=>$listdata];
          $this->view('operations/appraisalview', $data);
        }
     }

     public function grievanceform(){
      $employeeid  = $_POST['employeeid'];
      $empdata = Employee::getEmployeesById($employeeid);
      $empcount = Employee::searchemployeegeneralcount($empdata->staffid);
        $usersdata = User::ListAll();

        $data = [ 'empdata'=>$empdata,  'empcount'=>$empcount, 'userdata'=>$usersdata];
        $this->view('operations/grievanceform', $data);

     }

     public function disciplineform(){
      $employeeid  = $_POST['employeeid'];
      $empdata = Employee::getEmployeesById($employeeid);
      $empcount = Employee::searchemployeegeneralcount($empdata->staffid);
        $usersdata = User::ListAll();

        $data = [ 'empdata'=>$empdata,  'empcount'=>$empcount, 'userdata'=>$usersdata];
        $this->view('operations/disciplineform', $data);

     }

     public function promotionform(){
      $employeeid  = $_POST['employeeid'];
      $empdata = Employee::getEmployeesById($employeeid);
      $empcount = Employee::searchemployeegeneralcount($empdata->staffid);
        $companyname  = $empdata->company;
        $usersdata = User::ListAll();
        $departments = Department::getDepartmentByCompany($companyname);


        $data = ['empdata'=>$empdata, 'empcount'=>$empcount, 'userdata'=>$usersdata, 'departmentdata'=>$departments];
        $this->view('operations/promotionform', $data);

     }

     public function assetsform(){
      $employeeid  = $_POST['employeeid'];
      $empdata = Employee::getEmployeesById($employeeid);
      $empcount = Employee::searchemployeegeneralcount($empdata->staffid);
        $companyname  = $empdata->company;
        $usersdata = User::ListAll();
        $departments = Department::getDepartmentByCompany($companyname);


        $data = ['empdata'=>$empdata, 'empcount'=>$empcount, 'userdata'=>$usersdata, 'departmentdata'=>$departments];
        $this->view('operations/assetsform', $data);

     }

     public function appraisalform(){
      $employeeid  = $_POST['employeeid'];
      $empdata = Employee::getEmployeesById($employeeid);
      $empcount = Employee::searchemployeegeneralcount($empdata->staffid);
        $companyname  = $empdata->company;
        $usersdata = User::ListAll();
        $departments = Department::getDepartmentByCompany($companyname);


        $data = ['empdata'=>$empdata, 'empcount'=>$empcount, 'userdata'=>$usersdata, 'departmentdata'=>$departments];
        $this->view('operations/appraisalform', $data);

     }

     public function transferform(){
      $employeeid  = $_POST['employeeid'];
      $empdata = Employee::getEmployeesById($employeeid);
      $empcount = Employee::searchemployeegeneralcount($empdata->staffid);
       $companyname  = $empdata->company;
       $usersdata = User::ListAll();
       $departments = Department::getDepartmentByCompany($companyname);


       $data = ['empdata'=>$empdata, 'empcount'=>$empcount, 'userdata'=>$usersdata, 'departmentdata'=>$departments];
       $this->view('operations/transferform', $data);
     }


     public function leaveform(){
        $employeeid  = $_POST['employeeid'];
        $empdata = Employee::getEmployeesById($employeeid);
        $empcount = Employee::searchemployeegeneralcount($empdata->staffid);
        $usersdata = User::ListAll();

        $data = [ 'empdata'=>$empdata,  'empcount'=>$empcount, 'userdata'=>$usersdata];
        $this->view('operations/leaveform', $data);

     }



     public function grievance(){
       $grievancedata = Grievance::ListAll();

         if(isset($_POST['submitgrievance'])){
           $reportedby  = $_POST['reportedby'];
           $reportedbycc = $_POST['reportedbycc'];
           array_push($reportedbycc, $reportedby);

           $subject = $_POST['subject'];
           $description = $_POST['description'];
           $employeeid  = $_POST['employeeid'];

           $uploads = new Uploads();
      		 $uploads->filename = $_FILES['grievancedoc'];
      		 $uploadresponse = $uploads->upLoadFile();
      		 $filename =  $uploadresponse['filename'];

           $gv  = new Grievance();
           $gv->recordObject->subject = $subject;
           $gv->recordObject->description = $description;
           $gv->recordObject->reportdate =  date('Y-m-d');
           $gv->recordObject->employeeid = $employeeid;
           $gv->recordObject->uid = $_SESSION['uid'];
           $gv->recordObject->recipientid = $reportedby;
           $gv->recordObject->filename = $filename;

           if($gv->store()){

            $gid = $gv->recordObject->gid;

               foreach($reportedbycc as $uid){

                  $us = new User($uid);
                  $telephone = $us->recordObject->telephone;
                  sendGrievanceText($telephone, 'grievance');
                  Grievance::insertgrievanceusers($gid, $uid);
               }
           }
           $data = ['grievancedata'=>$grievancedata];
           $this->view('operations/grievance', $data);
           exit;
         }

         else{
         $data = ['grievancedata'=>$grievancedata];
         $this->view('operations/grievance', $data);
       }

     }



     public function discipline(){
       $grievancedata = Discipline::ListAll();

         if(isset($_POST['submitdiscipline'])){
           $reportedby  = $_POST['reportedby'];
           $reportedbycc = $_POST['reportedbycc'];
           array_push($reportedbycc, $reportedby);

           $subject = $_POST['subject'];
           $description = $_POST['description'];
           $employeeid  = $_POST['employeeid'];

           $uploads = new Uploads();
      		 $uploads->filename = $_FILES['disciplinedoc'];
      		 $uploadresponse = $uploads->upLoadFile();
      		 $filename =  $uploadresponse['filename'];

           $gv  = new Discipline();
           $gv->recordObject->subject = $subject;
           $gv->recordObject->description = $description;
           $gv->recordObject->reportdate =  date('Y-m-d');
           $gv->recordObject->employeeid = $employeeid;
           $gv->recordObject->uid = $_SESSION['uid'];
           $gv->recordObject->recipientid = $reportedby;
           $gv->recordObject->filename = $filename;

           if($gv->store()){

            $did = $gv->recordObject->did;

               foreach($reportedbycc as $uid){

                  $us = new User($uid);
                  $telephone = $us->recordObject->telephone;
                  sendGrievanceText($telephone, 'discplinary complain');
                  Discipline::insertdisciplineusers($did, $uid);
               }
           }
           $data = ['grievancedata'=>$grievancedata];
           $this->view('operations/discipline', $data);
           exit;
         }

         else{
         $data = ['grievancedata'=>$grievancedata];
         $this->view('operations/discipline', $data);
       }

     }


     public function transfer(){
       $grievancedata = Transfer::ListAll();

         if(isset($_POST['submittransfer'])){
           $reportedby  = $_POST['reportedby'];
           $reportedbycc = $_POST['reportedbycc'];
           array_push($reportedbycc, $reportedby);

           $description = $_POST['description'];
           $employeeid  = $_POST['employeeid'];

           $uploads = new Uploads();
           $uploads->filename = $_FILES['transferdoc'];
           $uploadresponse = $uploads->upLoadFile();
           $filename =  $uploadresponse['filename'];

           $gv  = new Transfer();
           $gv->recordObject->description = $description;
           $gv->recordObject->reportdate =  date('Y-m-d');
           $gv->recordObject->employeeid = $employeeid;
           $gv->recordObject->uid = $_SESSION['uid'];
           $gv->recordObject->recipientid = $reportedby;
           $gv->recordObject->filename = $filename;
           $gv->recordObject->position = $_POST['position'];
           $gv->recordObject->department = $_POST['department'];


           if($gv->store()){

            $tid = $gv->recordObject->tid;

               foreach($reportedbycc as $uid){

                  $us = new User($uid);
                  $telephone = $us->recordObject->telephone;
                  sendGrievanceText($telephone, 'transfer request');
                  Transfer::inserttransferusers($tid, $uid);
               }
           }
           $data = ['grievancedata'=>$grievancedata];
           $this->view('operations/transfer', $data);
         }

         else{
         $data = ['grievancedata'=>$grievancedata];
         $this->view('operations/transfer', $data);
       }

     }

     public function promotion(){
       $grievancedata = Promotion::ListAll();

         if(isset($_POST['submitpromotion'])){
           $reportedby  = $_POST['reportedby'];
           $reportedbycc = $_POST['reportedbycc'];
           array_push($reportedbycc, $reportedby);

           $description = $_POST['description'];
           $employeeid  = $_POST['employeeid'];

           $uploads = new Uploads();
      		 $uploads->filename = $_FILES['promotiondoc'];
      		 $uploadresponse = $uploads->upLoadFile();
      		 $filename =  $uploadresponse['filename'];

           $gv  = new Promotion();
           $gv->recordObject->description = $description;
           $gv->recordObject->reportdate =  date('Y-m-d');
           $gv->recordObject->employeeid = $employeeid;
           $gv->recordObject->uid = $_SESSION['uid'];
           $gv->recordObject->recipientid = $reportedby;
           $gv->recordObject->filename = $filename;
           $gv->recordObject->position = $_POST['position'];
           $gv->recordObject->department = $_POST['department'];


           if($gv->store()){

            $pid = $gv->recordObject->pid;

               foreach($reportedbycc as $uid){

                  $us = new User($uid);
                  $telephone = $us->recordObject->telephone;
                  sendGrievanceText($telephone, 'promotion request');
                  Promotion::insertpromotionusers($pid, $uid);
               }
           }
           $data = ['grievancedata'=>$grievancedata];
           $this->view('operations/promotion', $data);
         }

         else{
         $data = ['grievancedata'=>$grievancedata];
         $this->view('operations/promotion', $data);
       }

     }



     public function assets(){
      $assetdata = Assets::ListAll();

        if(isset($_POST['submitasset'])){
          $reportedby  = $_POST['reportedby'];
          $description = $_POST['description'];
          $employeeid  = $_POST['employeeid'];
          $reportedbycc = $_POST['reportedbycc'];
          array_push($reportedbycc, $reportedby);

          $uploads = new Uploads();
          $uploads->filename = $_FILES['assetdoc'];
          $uploadresponse = $uploads->upLoadFile();
          $filename =  $uploadresponse['filename'];

          $gv  = new Assets();
          $gv->recordObject->description = $description;
          $gv->recordObject->reportdate =  date('Y-m-d');
          $gv->recordObject->employeeid = $employeeid;
          $gv->recordObject->uid = $_SESSION['uid'];
          $gv->recordObject->recipientid = $reportedby;
          $gv->recordObject->filename = $filename;
          $gv->recordObject->assetname = $_POST['assetname'];
          $gv->recordObject->assetquantity = $_POST['assetquantity'];

          if($gv->store()){
           $aid = $gv->recordObject->aid;
           foreach($reportedbycc as $uid){
              $us = new User($uid);
              $telephone = $us->recordObject->telephone;
              sendGrievanceText($telephone, 'Assets Assignment');
              Assets::insertassetusers($aid, $uid);
           }
          }

          $data = ['assetdata'=>$assetdata];
          //$this->view('operations/assets', $data);
          Redirecting::location('operations/Assets');
        }

        else{
        $data = ['assetdata'=>$assetdata];
        $this->view('operations/assets', $data);
      }

    }


    public function appraisal(){
      $assetdata = Appraisal::ListAll();

        if(isset($_POST['submitappraisal'])){


          $uploads = new Uploads();
          $uploads->filename = $_FILES['assetdoc'];
          $uploadresponse = $uploads->upLoadFile();
          $filename =  $uploadresponse['filename'];
          $employeeid  = $_POST['employeeid'];

          // print_r($_POST);
          foreach ($_POST as $question=>$answer){
            if(is_int($question)){
              $sectionid = Appraisal::sectionFromQuestion($question);

              $gv  = new Appraisal();
              $gv->recordObject->answer = $answer;
              $gv->recordObject->reportdate =  date('Y-m-d');
              $gv->recordObject->employeeid = $employeeid;
              $gv->recordObject->uid = $_SESSION['uid'];
              $gv->recordObject->questionid = $question;
              $gv->recordObject->filename = $filename;
              $gv->recordObject->sectionid = $sectionid;
    
              $gv->store();
            }
            // print_r($sectionid."=>".$question."=>".$answer);
          }
          Redirecting::location('operations/Appraisalresult/'.$employeeid);
        }

        else{
        $data = ['assetdata'=>$assetdata];
        $this->view('operations/appraisal', $data);
      }

    }

    public function appraisalresult($employeeid){

      $empdata = Employee::getEmployeesById($employeeid);
      $companyname  = $empdata->company;
      $departments = Department::getDepartmentByCompany($companyname);      
      $sectionresults = Appraisal::sectionResult($employeeid);
      $filename = $sectionresults[0]->filename;
      foreach ($sectionresults as $result){
          $sr[]=array($result->sectionid=>round($result->totalanswer/$result->totalsection) );
      }

      $sresult=array('0'=>'');
      foreach ($sr as $s){
          foreach ($s as $t=>$y){
              array_push($sresult,$y);
          }
      }
      $overall = round (array_sum($sresult)/(sizeof($sresult)-1),0);
      $data = ['filename'=>$filename,'empdata'=>$empdata,'departmentdata'=>$departments,'sectionresult'=>$sresult,'overall'=>$overall];

        $this->view('operations/appraisalresult', $data);
    }




     public function leave(){
       $grievancedata = Leave::ListAll();
         if(isset($_POST['submitleave'])){
            $grievancedata = Leave::ListAll();
           $reportedby  = $_POST['reportedby'];
           $reportedbycc = $_POST['reportedbycc'];
           array_push($reportedbycc, $reportedby);

           $description = $_POST['description'];
           $employeeid  = $_POST['employeeid'];
           $leavetype  = $_POST['leavetype'];

           $uploads = new Uploads();
      		 $uploads->filename = $_FILES['leavedoc'];
      		 $uploadresponse = $uploads->upLoadFile();
      		 $filename =  $uploadresponse['filename'];

           //return leavedays from the start and end dates excluding holiday and weekends
           $actualdays = Tools::datediff($_POST['startdate'],$_POST['endate']);

           

           $gv  = new Leave();
           $gv->recordObject->description = $description;
           $gv->recordObject->reportdate =  date('Y-m-d');
           $gv->recordObject->employeeid = $employeeid;
           $gv->recordObject->uid = $_SESSION['uid'];
           $gv->recordObject->receipientid = $reportedby;
           $gv->recordObject->filename = $filename;
           $gv->recordObject->startdate = $_POST['startdate'];
           $gv->recordObject->endate = $_POST['endate'];
           $gv->recordObject->actualdays = $actualdays;
           $gv->recordObject->leavetype = $leavetype;
           $gv->recordObject->status = "Approve";

           if($gv->store()){

            $lid = $gv->recordObject->lid;

               foreach($reportedbycc as $uid){

                  $us = new User($uid);
                  $telephone = $us->recordObject->telephone;
                  sendGrievanceText($telephone, 'leave request');
                  Leave::insertleaveusers($lid, $uid);
               }
           }

           //get the accumulated leave of the employee if any (else get the system leave days) and deduct the actual days from it
          /* $emp = new Employee($employeeid);
           $accumulated = $emp->recordObject->accumulatedleave;
           $emp->recordObject->accumulatedleave = $accumulated - $actualdays;
           $emp->store();*/
         
           Redirecting::location('operations/leave');
         }

         else{
         $data = ['grievancedata'=>$grievancedata];
         $this->view('operations/leave', $data);
       }

     }

     public function leaveedit($lid){
      if(isset($_POST['submitleave'])){
          
        $description = $_POST['description'];
        $employeeid  = $_POST['employeeid'];
        $lid = $_POST['leaveid'];
        $leavetype  = $_POST['leavetype'];


        //return leavedays from the start and end dates excluding holiday and weekends
        $actualdays = Tools::datediff($_POST['startdate'],$_POST['endate']);


        $uploads = new Uploads();
        $uploads->filename = $_FILES['leavedoc'];
        $uploadresponse = $uploads->upLoadFile();
        $filename =  $uploadresponse['filename'];


        $gv  = new Leave($lid);
        $gv->recordObject->description = $description;
        $gv->recordObject->reportdate =  date('Y-m-d');
        $gv->recordObject->employeeid = $employeeid;
        $gv->recordObject->filename = $filename;
        $gv->recordObject->startdate = $_POST['startdate'];
        $gv->recordObject->endate = $_POST['endate'];
        $gv->recordObject->actualdays = $actualdays;
        $gv->recordObject->leavetype = $leavetype;
        $gv->recordObject->status = "Approve";

        $gv->store();
        Redirecting::location('operations/leave');
        }else{
        $grievancedata = Leave::ListAll();
        $l = new Leave($lid);
        $leave = &$l->recordObject;
        $employeeid  = $leave->employeeid;
        $empdata = Employee::getEmployeesById($employeeid);
        $usersdata = User::ListAll();

        $data = [ 'empdata'=>$empdata,  'leavedata'=>$leave, 'userdata'=>$usersdata,'grievancedata'=>$grievancedata];
        $this->view('operations/leaveedit',$data);
        }
     }

     public function bookingform(){

      $this->view('operations/bookingform');
     }

     public function viewevent(){

    }

    public function holiday($holidayid=null){

      $holiday = Holiday::getholidaybyid($holidayid);

      if(isset($_POST['saveholidaybtn'])){
        $holidayname = $_POST['holidayname'];
        $holidaydate =$_POST['holidaydate'];
        $holidayid =$_POST['holidayid'];
        if($holidayid==''){
          $holidayid=null;
        }
        $gv  = new Holiday($holidayid);
        $gv->recordObject->holidayname = $holidayname;
        $gv->recordObject->holidaydate = $holidaydate;
        $gv->store();
      }

      $this->view('operations/holiday',$holiday);
     }

     public function holidaylist(){
      $holidays = Holiday::listAll();

      foreach($holidays as $holiday){
        $list[]=array("title"=>'(H) '.$holiday->holidayname,"start"=>$holiday->holidaydate,"end"=>$holiday->holidaydate);
       }
       echo json_encode($list);
     }


     public function leavelist(){
      $leavelist = Leave::listAll();

      foreach($leavelist as $get){
          $em = new Employee($get->employeeid);
          $employeename  =   $em->recordObject->fullname;
        $list[]=array("title"=>$employeename,"start"=>$get->startdate,"end"=>Tools::plusOneDay($get->endate),"id"=>$get->lid,"icon"=>"calendar");
       }
       echo json_encode($list);
     }

     public function leavedays($daysid=null){
      $leave = Leavedays::getleavedays($daysid);

      if(isset($_POST['saveleavedaysbtn'])){
        $leavedays = $_POST['leavedays'];
        $daysid =$_POST['daysid'];
        if($daysid==''){
          $daysid=null;
        }
        $gv  = new Leavedays($daysid);
        $gv->recordObject->leavedays = $leavedays;
        $gv->store();
      }

      $this->view('operations/leavedays',$leave);

     }

     public function leaveconfig(){

		$employeeid =  $_POST['employeeid'];
		$field = $_POST['field'];
		$value = $_POST['value'];

	  $recut = new Employee($employeeid);
		$recut->recordObject->$field = $value;
		$recut->store();
     }

     public function isleavevalid(){
      // $employeeid = $_POST['employeeid'];
       $startdate = $_POST['startdate'];
       $enddate = $_POST['enddate'];
       $available = $_POST['available'];
       $actualdays = Tools::datediff($_POST['startdate'],$_POST['enddate']);
       $a = $available - $actualdays;

       echo $a;
     }
}
