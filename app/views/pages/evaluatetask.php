<style>
tr, td{
  padding:2px
}

</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/taskmenu.php' ; ?>


<div class="content-wrapper">
  <div style='padding-left:20px; color:#7F400B'><h3>TASK EVALUATION</h3></div>
  <hr/>



    <div class="container-fluid main_container">

      <div id="viewmodal" class="modal fade" role="dialog" style="z-index:9999999999999999999999999">
                <div class="modal-dialog" style="width:600px" role="document">

                    <div class="modal-content">
                        <div class="modal-body" id="ajaxcontainer" >

                        </div>
                    </div>
                </div>
     </div>


      <div id='placeholder' style='margin-top:-30px'>

        <div class="col-lg-12 col-md-12 col-sm-12">
          <a href="#">
          <div class="card">
          <div class="container">
            <br/>
          <h3>Task: <?php  echo strtoupper($data['details']->taskname)  ?></h3>

            <div>

            </div>

          </div>
          </div>
          </a>
        </div>

      <div class="row" style="margin-top:20px">

      <?php //echo '<pre/>'; print_r($data)  ?>


      <div class="col-lg-6 col-md-6 col-sm-6">
        <?php if($data['message'] != ''){  ?>
          <div class='alert alert-success'><?php echo $data['message']  ?></div>
        <?php  }  ?>
        <a href="#">
        <div class="card0">
        <div class="container">

         <br/>
         <h3>Task Details</h3>
         <form method="post">
         <table class='table table-bordered'>

           <tr>
             <td>Task Status</td>
             <td style='font-size:18px; font-weight:700'><?php if($data['taskstatus'] == 0){
                 echo '<span style="color:orange">Active</span>';
             }elseif($data['taskstatus'] == 1){
                 echo '<span style="color:green">Complete</span>';
             }elseif($data['taskstatus'] == 2){
                 echo '<span style="color:red">Incomplete</span>';
             }
             ?>

           </td>
           </tr>

           <tr>
             <td>Rating</td>
             <td>  <div class="progress" style="height: 10px;">
               <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?php  echo $data['rating'].'%'   ?>"
              aria-valuemin="0" aria-valuenow="<?php  echo $data['rating'] ?>" aria-valuemax="100"></div>
               </div></td>
           </tr>

           <tr>
             <td>Start Date</td>
             <td><?php echo $data['details']->startdate   ?></td>
           </tr>
           <tr>
             <td>End Date</td>
             <td><?php echo $data['details']->enddate   ?></td>
           </tr>

           <tr>
             <td>Description</td>
             <td><?php echo $data['details']->description   ?></td>
           </tr>
           <tr>
             <td>Status</td>
             <td>
              <select class='form-control' name = 'status' required>
                <option value=''>Pick Status</option>
                <option>Complete</option>
                <option>Incomplete</option>
              </select>
             </td>
           </tr>
           <tr>
             <td>Rating</td>
             <td>
               <select class='form-control' name='rating' required>
                 <option value="">Pick Rating</option>
                 <option>10</option>
                 <option>20</option>
                 <option>30</option>
                 <option>40</option>
                 <option>50</option>
                 <option>60</option>
                 <option>70</option>
                 <option>80</option>
                 <option>90</option>
                 <option>100</option>
               </select></td>
           </tr>

           <tr>
             <td>Leave a Comment</td>
             <td><textarea name='comment' rows='5' class='form-control'> </textarea></td>
           </tr>

           <tr>
             <td></td>
             <td><button class='btn btn-danger' type="submit" name='takeaction' style='font-size:12px'
                <?php  if($data['taskstatus'] == 1 ){ echo "disabled='disabled' "; }  ?>
               > Take Action </button></td>
           </tr>

         </table>


       </form>

        </div>
        </div>
        </a>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6">
        <a href="#">
        <div class="cardd">
        <div class="container">
         <br/>
          <h3>Feedback(s)</h3>
         <table class='table table-bordered'>
           <?php
           foreach($data['feedback'] as $fed):
           ?>
           <tr>
            <td> <?php  echo substr($fed->description, 0, 40). ' --- ' ?></td>
            <td> <?php  echo $fed->feedbackdate ?></td>
            <td> <a href='#' class='morefeedback' fid = '<?php echo $fed->fid   ?>'> Read More </a></td>
           </tr>
           <?php
           endforeach;
            ?>
         </table>

         <h5 style='color:green'>Supporting Document(s)</h5>
        <table class='table table-bordered'>
          <tr style="font-weight:700; font-size:15px">
            <td>Document</td>
            <td align='center'>Download</td>
          </tr>

          <?php
          foreach($data['supportingdoc'] as $get){
          ?>

          <tr>
            <td><?php echo  $get->filename    ?></td>
            <td align='center'><a target='_blank' href='<?php echo URLROOT.'/uploads/'. $get->filename ?>'><i class='fa fa-download'></i> </a></td>
          </tr>
          <?php
            }
           ?>
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
         <td width='20%'><i class= 'fa fa-user'></i> <?php  echo $ass->firstname. ' '. $ass->surname.' -  '. $ass->role  ?></td>
        </tr>
        <?php
        endforeach;
         ?>
      </table>


        </div>
        </div>
        </a>
      </div>


    </div>   <!-- End of Placeholder -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
