<style >
tr, td{
  padding:2px
}
</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/operationsmenu.php' ; ?>


<div class="content-wrapper">



     <div style='padding-left:20px; color:#7F400B'><h3></h3></div>
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
        <h3>Sent From: <?php
         $em = new Employee($data['opdata']->employeeid);
         echo   $employeename  =   $em->recordObject->fullname;
          ?></h3>
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
        <h5 style='color:#800800'>Details</h5>


        <table class='table table-bordered'>

          <tr>
           <td width='30%'>Status</td>
           <td style='font-size:15px; font-weight:700'><?php if($data['opdata']->status == ''){
               echo '<span style="color:orange">Pending</span>';
           }elseif($data['opdata']->status == 'Approve'){
               echo '<span style="color:green">Approved</span>';
           }elseif($data['opdata']->status == 'Decline'){
               echo '<span style="color:red">Declined</span>';
           }
           ?></td>
          </tr>
          <tr>


          <tr>
           <td>Report Date</td>
           <td><?php  echo $data['opdata']->reportdate  ?></td>
          </tr>

          <tr>
           <td>Department Requested</td>
           <td><?php  echo $data['opdata']->department  ?></td>
          </tr>

          <tr>
           <td>Position Requested</td>
           <td><?php  echo $data['opdata']->position  ?></td>
          </tr>

          <tr>
           <td>Description</td>
           <td><?php  echo $data['opdata']->description  ?></td>
          </tr>
        </table>

         <h5 style='color:#800800'>Attached Document</h5>
        <table class='table table-bordered'>

          <tr>

            <td><a target='_blank' href='<?php echo URLROOT.'/uploads/'. $data['opdata']->filename ?>'>
              <i class='fa fa-download'></i> Download file </a></td>
          </tr>

        </table>



      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">

        <h5 style='color:green'>Copied User(s)</h5>
       <table class='table table-bordered'>
         <?php
         foreach($data['opusers'] as $ass):

           $us = new User($ass->uid);
           $firstname = $us->recordObject->firstname;
           $surname = $us->recordObject->surname;
           $role = $us->recordObject->role;
         ?>
         <tr>
          <td width='20%'><i class= 'fa fa-user'></i> <?php  echo $firstname. ' '. $surname. ' - '. $role ?></td>
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
