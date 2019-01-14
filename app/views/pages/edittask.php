<style >
tr, td{
  padding:2px
}
</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/taskmenu.php' ; ?>


<div class="content-wrapper">

     <div style='padding-left:20px; color:#7F400B'><h3>Edit Task</h3></div>
     <hr/>
    <div class="container-fluid main_container">

      <div id='placeholder' style='margin-top:-30px'>

      <div class="row" style="margin-bottom:20px">

      <div class="col-lg-6 col-md-6 col-sm-6">
        <a href="#">
        <div class="card">
        <div class="container">
          <br/>
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

            <table class='table table-bordered'>
            <tr>
              <td>Add document(s)</td>
              <td><input type="file" name="filedoc" id="filedoc" style="font-size:10px" /></td>
            </tr>
          </table>
          <div>

          </div>

        </div>
        </div>
        </a>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6">
      <a href="#">
      <div class="card">
      <div class="container">
        <br/>
        <form  method='post' >
        <table  class='table table-bordered table-condensed' style='font-size:12px'>

        <tr>
        <td>Task Name</td>
        <td><input type="text" class="form-control" name="taskname" value='<?php  echo $data['task']->taskname  ?>'   /></td>
       </tr>

       <tr>
        <td>Start Date</td>
        <td><input type="text" id='from' class="form-control" name="startdate" value='<?php  echo $data['task']->startdate  ?>' ></td>
       </tr>

       <tr>
        <td>End Date</td>
        <td><input type="text" id='to' class="form-control" name="endate" value='<?php  echo $data['task']->enddate  ?>' /></td>
       </tr>

       <tr>
        <td>Description</td>
        <td><textarea type="text" name='description' rows='5' class="form-control"><?php  echo $data['task']->description  ?></textarea></td>
       </tr>




       <tr>
        <td></td>
        <td><button name='updatetask' type='submit' style='font-size:10px' class='btn btn-warning'>Update Task</button></td>
       </tr>

       </table>
     </form>

       </div>
      </div>
      </div>
      </a>
      </div>

    </div>   <!-- End of Placeholder -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>

  <script type="text/javascript">
  var uroot = '<?php echo URLROOT.'/task/savedoc/'.$data['task']->id ?>';


  $('#filedoc').uploadifive({
      'buttonText'  : 'Browse for document to upload',
      'buttonClass' : 'uploadifive-button',
      'auto'        : true,
      'method'      : 'post',
      'multi'       : true,
      'width'       : 250,
      'uploadScript': uroot,
      'onUploadComplete' : function(file, data) {
          window.location.href = '<?php echo URLROOT.'/task/edittask/'.$data['task']->id   ?>'
        }
   });


  </script>
