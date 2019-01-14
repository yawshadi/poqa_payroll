<style >
tr, td{
  padding:2px
}
</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/taskmenu.php' ; ?>


<div class="content-wrapper">



     <div style='padding-left:20px; color:#7F400B'><h3>Task Profile</h3></div>
     <hr/>
    <div class="container-fluid main_container">

      <div id='placeholder' style='margin-top:-30px'>
      <form method="post">
      <div class="row" style="margin-bottom:20px">

      <div class="col-lg-12 col-md-12 col-sm-12">
        <a href="#">
        <div class="card">
        <div class="container">
          <br/>
        <h3>Task: <?php  echo strtoupper($data['details']->taskname)  ?></h3>
        ( <span>Assigned By: <?php  echo $data['manager'] ?></h3> )
          <br/>
          <br/>

          <div>

          </div>

        </div>
        </div>
        </a>
      </div>
    </form>

    </div>



      <div class="row" style="margin-bottom:20px">

        <!-- <?php  //echo '<pre>'; print_r($data)   ?> -->

      <div class="col-lg-6 col-md-6 col-sm-6">
        <h5 style='color:#800800'>Task Details</h5>


        <table class='table table-bordered'>
          <tr>
           <td width='20%'>Taskname</td>
           <td><?php  echo $data['details']->taskname  ?></td>
          </tr>

          <tr>
           <td width='20%'>Status</td>
           <td><?php if($data['taskstatus'] == 0){
               echo '<span style="color:orange">Active</span>';
           }elseif($data['taskstatus'] == 1){
               echo '<span style="color:green">Complete</span>';
           }elseif($data['taskstatus'] == 2){
               echo '<span style="color:red">Incomplete</span>';
           }
           ?></td>
          </tr>
          <tr>


          <tr>
           <td>Start Date</td>
           <td><?php  echo $data['details']->startdate  ?></td>
          </tr>

          <tr>
           <td>End Date</td>
           <td><?php  echo $data['details']->enddate  ?></td>
          </tr>

          <tr>
           <td>Description</td>
           <td><?php  echo $data['details']->description  ?></td>
          </tr>

        </table>

         <h5 style='color:#800800'>Task Document(s)</h5>
        <table class='table table-bordered'>
          <tr style="font-weight:700; font-size:15px">
            <td>Document</td>
            <td>Date</td>
            <td align='center'>Download</td>
          </tr>

          <?php
          foreach($data['doc'] as $get){
          ?>

          <tr>
            <td><?php echo  $get->name    ?></td>
            <td><?php echo  $get->docdate    ?></td>
            <td align='center'><a target='_blank' href='<?php echo URLROOT.'/uploads/'. $get->newname ?>'><i class='fa fa-download'></i> </a></td>
          </tr>
          <?php
            }
           ?>
        </table>

         <h5 style='color:green'>Assigned User(s)</h5>
        <table class='table table-bordered'>
          <?php
          foreach($data['asusers'] as $ass):
          ?>
          <tr>
           <td width='20%'><i class= 'fa fa-user'></i> <?php  echo $ass->firstname. ' '. $ass->surname. ' - '. $ass->role ?></td>
          </tr>
          <?php
          endforeach;
           ?>
        </table>

      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">

    <table>
      <tr>
       <td width='80%'><h5 style='color:#800800'>Your List of Feedbacks</h5></td>
      </tr>
    </table>

    <table class='table table-bordered'>
      <?php
      foreach($data['feedback'] as $fed):
      ?>
      <tr>
       <td> <?php  echo $fed->description ?></td>
       <td> <?php  echo $fed->feedbackdate ?></td>
       <td> <a href='#' class='morefeedback' fid = '<?php echo $fed->fid   ?>'> Read More </a></td>
      </tr>
      <?php
      endforeach;
       ?>
    </table>

      </div>

      </div>

      <div id="viewmodal" class="modal fade" role="dialog" style="z-index:9999999999999999999999999">
                <div class="modal-dialog" style="width:600px" role="document">

                    <div class="modal-content">
                        <div class="modal-body" id="ajaxcontainer" >

                        </div>
                    </div>
                </div>
     </div>



    </div>   <!-- End of Placeholder -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>

  <script type="text/javascript">
  var uroot = '<?php echo URLROOT.'/task/savedoc/'.$data['task']->id ?>';

  $('#subdoc').uploadifive({
      'buttonText'  : 'Browse for document to upload',
      'buttonClass' : 'uploadifive-button',
      'auto'        : true,
      'method'      : 'post',
      'multi'       : true,
      'width'       : 250,
      'uploadScript': uroot,
      'onUploadComplete' : function(file, data) {
            alert(data);
        }
   });


  </script>
