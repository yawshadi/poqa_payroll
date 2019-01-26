<?php

class Operations extends Controller{

     public function index (){

       $leavecount = Leave::getCount('All');
       $transfercount =  Transfer::getCount('All');
       $promotioncount =  Promotion::getCount('All');
       $disciplinecount =  Discipline::getCount('All');
       $grievancecount = Grievance::getCount('All');

       $data = ['leavecount'=> $leavecount, 'transfercount'=> $transfercount, 'promotioncount'=>$promotioncount, 'grievancecount'=>$grievancecount,
               'disciplinecount'=>$disciplinecount];

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
         $dt = new Leave($id);
         $opdata = $dt->recordObject;
         $opusers =  Leave::getleaveusers($id);
         $data = ['opdata'=>$opdata, 'opusers'=>$opusers];
         $this->view('operations/leaveprofile', $data);
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
     }

     public function grievanceform(){
        $empname  = $_POST['empname'];
        $empdata = Employee::searchemployeegeneral($empname);
        $empcount = Employee::searchemployeegeneralcount($empname);
        $usersdata = User::ListAll();

        $data = [ 'empdata'=>$empdata,  'empcount'=>$empcount, 'userdata'=>$usersdata];
        $this->view('operations/grievanceform', $data);

     }

     public function disciplineform(){
        $empname  = $_POST['empname'];
        $empdata = Employee::searchemployeegeneral($empname);
        $empcount = Employee::searchemployeegeneralcount($empname);
        $usersdata = User::ListAll();

        $data = [ 'empdata'=>$empdata,  'empcount'=>$empcount, 'userdata'=>$usersdata];
        $this->view('operations/disciplineform', $data);

     }

     public function promotionform(){
        $empname  = $_POST['empname'];
        $empdata = Employee::searchemployeegeneral($empname);
        $companyname  = $empdata->company;
        $empcount = Employee::searchemployeegeneralcount($empname);
        $usersdata = User::ListAll();
        $departments = Department::getDepartmentByCompany($companyname);


        $data = ['empdata'=>$empdata, 'empcount'=>$empcount, 'userdata'=>$usersdata, 'departmentdata'=>$departments];
        $this->view('operations/promotionform', $data);

     }

     public function transferform(){
       $empname  = $_POST['empname'];
       $empdata = Employee::searchemployeegeneral($empname);
       $companyname  = $empdata->company;
       $empcount = Employee::searchemployeegeneralcount($empname);
       $usersdata = User::ListAll();
       $departments = Department::getDepartmentByCompany($companyname);


       $data = ['empdata'=>$empdata, 'empcount'=>$empcount, 'userdata'=>$usersdata, 'departmentdata'=>$departments];
       $this->view('operations/transferform', $data);
     }


     public function leaveform(){
        $employeeid  = $_POST['employeeid'];
        $empdata = Employee::getEmployeesById($employeeid)[0];
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


     public function leave(){
       $grievancedata = Leave::ListAll();
         if(isset($_POST['submitleave'])){
            $grievancedata = Leave::ListAll();
           $reportedby  = $_POST['reportedby'];
           $reportedbycc = $_POST['reportedbycc'];
           array_push($reportedbycc, $reportedby);

           $description = $_POST['description'];
           $employeeid  = $_POST['employeeid'];

           $uploads = new Uploads();
      		 $uploads->filename = $_FILES['leavedoc'];
      		 $uploadresponse = $uploads->upLoadFile();
      		 $filename =  $uploadresponse['filename'];

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

           if($gv->store()){

            $lid = $gv->recordObject->lid;

               foreach($reportedbycc as $uid){

                  $us = new User($uid);
                  $telephone = $us->recordObject->telephone;
                 // sendGrievanceText($telephone, 'leave request');
                  Leave::insertleaveusers($lid, $uid);
               }
           }

         
           Redirecting::location('operations/leave');
         }

         else{
         $data = ['grievancedata'=>$grievancedata];
         $this->view('operations/leave', $data);
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
        $list[]=array("title"=>$employeename,"start"=>$get->startdate,"end"=>$get->endate,"id"=>$get->lid,"icon"=>"calendar");
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

     public function try(){
     print_r( Leavedays::availabledays('656',date('Y')));
     }
}
