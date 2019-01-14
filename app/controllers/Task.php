<?php

class Task extends Controller {

    public function taskdashboard(){

       $tdata = Tasks::getindividualTasklist('All', $_SESSION['uid']);


       // Assigned by user
       //$totaltask = Tasks::gettotaltask('User', $_SESSION['uid']);
       $totaltask = Tasks::individualtaskstatictics($_SESSION['uid'], 'All');
       $uncompleted  = Tasks::individualtaskstatictics($_SESSION['uid'], 'Incomplete');
       $completed  = Tasks::individualtaskstatictics($_SESSION['uid'], 'Complete');

       //Master Total Assiggemnets
       $masterdata = Tasks::listAll();
       $totaltaskmaster =  Tasks::gettotaltask('Master');
       $assignedtaskmaster = Tasks::mastertaskstatictics('All');
       $uncompletedmaster  = Tasks::mastertaskstatictics('Incomplete');
       $completedmaster  = Tasks::mastertaskstatictics('Complete');

       // Assigned to user
       $atotaltask = Tasks::getUserAssignedTaskcount('All', $_SESSION['uid']);
       $acompleted = Tasks::getUserAssignedTaskcount('Complete', $_SESSION['uid']);
       $auncompleted = Tasks::getUserAssignedTaskcount('Incomplete', $_SESSION['uid']);

       $notifications  = Tasks::getUserAssignedTask('All', $_SESSION['uid']);

       $data = ['task'=>$tdata, 'totaltask'=>$totaltask, 'completed'=>$completed,
                'uncompleted'=>$uncompleted, 'notifications'=>$notifications,
                'masterdata'=>$masterdata , 'totaltaskmaster'=>$totaltaskmaster,
                'assignedtaskmaster'=>$assignedtaskmaster, 'uncompletedmaster'=>$uncompletedmaster,
                'completedmaster'=>$completedmaster,  'acompleted'=>$acompleted,
                'auncompleted'=>$auncompleted, 'atotaltask'=>$atotaltask
              ];
  	   $this->view('pages/taskdashboard', $data);
  	}

    public function create(){
       $tdata = Tasks::getindividualTasklist('All', $_SESSION['uid']);
       $data = ['task'=>$tdata];
        if(isset($_POST['savetask'])){

          $tk = new Tasks();
          $tdata =& $tk->recordObject;
          $tdata->uid = $_SESSION['uid'];
          $tdata->taskname = $_POST['taskname'];
          $tdata->startdate = $_POST['startdate']. ' '.$_POST['starttime'] ;
          $tdata->enddate = $_POST['endate']. ' '.$_POST['endtime'] ;
          $tdata->description = $_POST['description'];
          $tdata->taskcode = uniqid();
          if($tk->store()){
            $tdata = Tasks::getindividualTasklist('All', $_SESSION['uid']);
            $data = ['task'=>$tdata];
          $this->view('pages/createtask', $data);
          }
        }else{
           $this->view('pages/createtask', $data);
        }
    }

    public function edittask($taskid){
       $tk = new Tasks($taskid);
       $task = $tk->recordObject;
       $doc = Document::getDocument($taskid);

       if(isset($_POST['updatetask'])){

         $tk = new Tasks($taskid);
         $tdata =& $tk->recordObject;
         $tdata->taskname = $_POST['taskname'];
         $tdata->startdate = $_POST['startdate'];
         $tdata->enddate = $_POST['endate'];
         $tdata->description = $_POST['description'];
         $tk->store();

         $task = $tk->recordObject;
         $data = ['task' => $task, 'doc'=> $doc ];
         $this->view('pages/edittask', $data);

       }else{
         $data = ['task' => $task, 'doc'=> $doc ];
         $this->view('pages/edittask', $data);
       }

    }

    public function history(){
       $task = Tasks::getindividualTasklist($_SESSION['uid']);
       $data = ['task' => $task];
       $this->view('pages/history', $data);

    }

    public function assign(){
       $task = Tasks::getindividualTasklist('All', $_SESSION['uid']);

       if(isset($_POST['assigntask'])){
         $taskid = $_POST['taskid'];
         $tkusers = $_POST['chktask'];

         $ts = new Assignedtask();
        // $ts->recordObject->uid = $uid ;
         $ts->recordObject->taskid = $taskid ;
         $ts->recordObject->dateassigned = date('Y-m-d') ;
         $ts->recordObject->assignee = $_SESSION['uid'];
         $ts->recordObject->status = 0;
         $taskusercount = Assignedtask::getTaskCount($taskid);
         if($taskusercount == 0){
         $ts->store();
         }


         foreach($tkusers as $uid){

           $usercount = Assignedtask::gettaskuserscount($taskid, $uid);

           $us = new User($uid);
           $email = $us->recordObject->email;
           $telephone  = $us->recordObject->telephone;

           $tk = new Tasks($taskid);
           $taskname = $tk->recordObject->taskname;

           $subject = 'New Task Assigned';
           $message = 'Dear, '. $us->recordObject->firstname. '<br/>'.
           'You have assigned a new task with title '. '<b>'.strtoupper($taskname).'</b>'.'<br/>'.
           'Please login to '. URLROOT;

           if($usercount == 0){
             Assignedtask::addtaskusers($taskid, $uid);
             sendEmail(SENDER_EMAIL, $email, $subject, $message, 'Labour Power');
             sendTextMessage($telephone, $taskname);
           }


         }


         $tk = new Tasks($taskid);
         $details = $tk->recordObject;
         $users = User::ListAll();
         $doc = Document::getDocument($taskid);
         $asusers = Assignedtask::getassignedTask($taskid);
         $taskstatus  = Assignedtask::getTaskstatus($taskid);
         $data = ['task' => $task, 'details'=>$details, 'users'=>$users, 'doc'=>$doc, 'asusers'=>$asusers, 'taskstatus'=> $taskstatus];
         $this->view('pages/assigntask', $data);
         //exit;
       }


       if(isset($_POST['searchtask'])){
          $taskid = $_POST['taskid'];
          $tk = new Tasks($taskid);
          $details = $tk->recordObject;
          $users = User::ListAll();
          $doc = Document::getDocument($taskid);
          $asusers = Assignedtask::getassignedTask($taskid);
          $taskstatus  = Assignedtask::getTaskstatus($taskid);
          $data = ['task' => $task, 'details'=>$details, 'users'=>$users, 'doc'=>$doc, 'asusers'=>$asusers, 'taskstatus'=> $taskstatus];
          $this->view('pages/assigntask', $data);
       }else{
          $data = ['task' => $task];
          $this->view('pages/assigntask', $data);
       }

    }

    public function savedoc($taskid){

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
         $doc->taskid = $taskid;
         $docdata->store();


      }else{
        echo 'Error uploading document';
      }

    }

    public function savesupporting($taskid){

      $filedata = $_FILES['Filedata'];
      $uploads = new Uploads();
      $uploads->filename = $_FILES['Filedata'];
      $supportingdocs = $_POST['supportingdocs'];
      $uploadresponse = $uploads->upLoadFile($supportingdocs);
      if($uploadresponse['status'] == 'SUCCESS'){
         $docname = $uploadresponse['filename'];
         $docdata = new Supportingdocuments();
         $size = $_FILES['Filedata']['size'];
         $type = $_FILES['Filedata']['type'];
         $name = $_FILES['Filedata']['name'];
         $docdate = date('Y-m-d');
         $doc =&   $docdata->recordObject;
         $doc->filename = $docname;
         $doc->type = $type;
         $doc->size = $size;
         $doc->uid = $_SESSION['uid'];
         $doc->taskid = $taskid;
         $docdata->store();

      }else{
        echo 'Error uploading document';
      }


    }


    public function assignmentdetails($taskid){

      $tk = new Tasks($taskid);
      $details = $tk->recordObject;
      $users = User::ListAll();
      $doc = Document::getDocument($taskid);
      $supportdoc = Supportingdocuments::getsupportingdocsbytaskid($taskid);
      $asusers = Assignedtask::getassignedTask($taskid);

      $assigneeid  = $tk->recordObject->uid;
      $as = new User($assigneeid);
      $roleassigner = $as->recordObject->role;
      $roletelephone = $as->recordObject->telephone;

      $listfeedback  = Feedback::getfeedback($taskid, $_SESSION['uid']);
      $taskstatus  = Assignedtask::getTaskstatus($taskid);
      $taskrating  = Assignedtask::getTaskrating($taskid);

      if(isset($_POST['submitfeedback'])){
       $ndoc = Document::getDocument($taskid);
       $asusers = Assignedtask::getassignedTask($taskid);
       $assigneeid  = $tk->recordObject->uid;
       $feedback = $_POST['feedback'];
       $fd = new Feedback();
       $fd->recordObject->uid =  $_SESSION['uid'];
       $fd->recordObject->description =  $feedback;
       $fd->recordObject->taskid = $taskid;
       $fd->recordObject->feedbackdate =  date('Y-m-d');
       $fd->store();

      $listfeedback  = Feedback::getfeedback($taskid, $_SESSION['uid']);
      $taskstatus  = Assignedtask::getTaskstatus($taskid);
      $taskrating  = Assignedtask::getTaskrating($taskid);
      $supportdoc = Supportingdocuments::getsupportingdocsbytaskid($taskid);

      $tks = new Tasks($taskid);
      $taskname = $tks->recordObject->taskname;
      receiveTextMessage($roletelephone, $taskname);

      $message = 'Feedback sucessfully sent. Thank you';

      $data = ['details'=>$details, 'users'=>$users, 'doc'=>$ndoc, 'asusers'=>$asusers, 'manager'=>$roleassigner,
               'feedback'=>$listfeedback, 'taskstatus'=>$taskstatus,  'rating'=>$taskrating, 'supportingdoc'=>$supportdoc, 'message'=>$message];

      $this->view('pages/assignmentdetails', $data);


      }else{

       $data = ['details'=>$details, 'users'=>$users, 'doc'=>$doc, 'asusers'=>$asusers, 'manager'=>$roleassigner,
                'feedback'=>$listfeedback, 'taskstatus'=>$taskstatus,  'rating'=>$taskrating, 'supportingdoc'=>$supportdoc, 'message'=>''];
       $this->view('pages/assignmentdetails', $data);
       }

     }

     public function activetask(){
       $activetask = Assignedtask::getallactiveTask($_SESSION['uid']);

       foreach($activetask as $get){

          $dateassigned =  $get->dateassigned;
          $taskid = $get->taskid;
          $taskid = $get->taskid;
          $tk = new Tasks($taskid);
          $taskname = $tk->recordObject->taskname;
          $startdate = $tk->recordObject->startdate;
          $enddate = $tk->recordObject->enddate;
          $adata[]  = ['dateassigned'=>$dateassigned, 'taskid'=>$taskid, 'startdate'=>$startdate,
          'enddate'=>$enddate, 'taskname'=>$taskname];

       }
       $data = ['activetask'=>$adata];
       $this->view('pages/activetask', $data);
     }

     public function evaluatetask($taskid){
       $tk = new Tasks($taskid);
       $details = $tk->recordObject;
       $doc = Document::getDocument($taskid);
       $asusers = Assignedtask::getassignedTask($taskid);
       $supportingdoc = Supportingdocuments::getsupportingdocsbytaskid($taskid);

       $listfeedback  = Feedback::getfeedbackbyTaskId($taskid);
       $taskstatus  = Assignedtask::getTaskstatus($taskid);
       $taskrating  = Assignedtask::getTaskrating($taskid);


         if(isset($_POST['takeaction'])){

           $doc = Document::getDocument($taskid);
           $asusers = Assignedtask::getassignedTask($taskid);

           $listfeedback  = Feedback::getfeedbackbyTaskId($taskid);

           $rating = $_POST['rating'];
           $status  = $_POST['status'];
           $comment = $_POST['comment'];

          if($status == 'Complete'){
            $action = 1;
          }elseif ($status == 'Incomplete') {
            $action = 2;
          }

          $tk = new Tasks($taskid);
          $details = $tk->recordObject;

          $taskstatus  = Assignedtask::getTaskstatus($taskid);
          $taskrating  = Assignedtask::getTaskrating($taskid);
          $supportdoc = Supportingdocuments::getsupportingdocsbytaskid($taskid);

          Assignedtask::updateAssignment($taskid, $rating, $action, $comment);
          $message = 'Task successfully processed';

          $data = ['details'=>$details, 'doc'=>$doc, 'asusers'=>$asusers,
          'feedback'=>$listfeedback, 'taskstatus'=>$taskstatus, 'rating'=>$taskrating, 'message' => $message, 'supportingdoc'=> $supportingdoc];

          $this->view('pages/evaluatetask', $data);

         }else{

           $message = '';
           $data = ['details'=>$details, 'doc'=>$doc, 'asusers'=>$asusers, 'feedback'=>$listfeedback,
                     'taskstatus'=>$taskstatus,  'rating'=>$taskrating, 'message' => $message, 'supportingdoc'=> $supportingdoc ];
           $this->view('pages/evaluatetask', $data);
         }
     }

     public function mastertaskstatisticslist($status){
         $listdata = Tasks::getmasterTasklist($status);
         $data = ['status'=>$status, 'listdata'=>$listdata];
         $this->view('pages/tasklist', $data);
     }

     public function individualstatisticslist($status){
         $listdata = Tasks::getindividualTasklist($status, $_SESSION['uid']);

         $data = ['status'=>$status, 'listdata'=>$listdata];
         $this->view('pages/itasklist', $data);
     }

     public function userassignedtask(){
        $listdata = Tasks::getUserAssignedTask($status, $_SESSION['uid']);
     }


     public function taskprofile($taskid){

       $tk = new Tasks($taskid);
       $details = $tk->recordObject;
       $users = User::ListAll();
       $doc = Document::getDocument($taskid);
       $asusers = Assignedtask::getassignedTask($taskid);

       $assigneeid  = $tk->recordObject->uid;
       $as = new User($assigneeid);
       $roleassigner = $as->recordObject->role;

       $listfeedback  = Feedback::getfeedbackbyTaskId($taskid);

       $taskstatus  = Assignedtask::getTaskstatus($taskid);
       $taskrating  = Assignedtask::getTaskrating($taskid);


        $data = ['details'=>$details, 'users'=>$users, 'doc'=>$doc, 'asusers'=>$asusers, 'manager'=>$roleassigner,
                 'feedback'=>$listfeedback, 'taskstatus'=>$taskstatus,  'rating'=>$taskrating ];

        $this->view('pages/taskprofile', $data);

      }

      public function taskassignedyou($status){
        $listdata = Tasks::getUserAssignedTask($status, $_SESSION['uid']);

        $data = ['status'=>$status, 'listdata'=>$listdata ];
        $this->view('pages/tasklist', $data);
      }



}

 ?>
