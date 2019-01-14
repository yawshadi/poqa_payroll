<style >
tr, td{
  padding:2px
}
</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/taskmenu.php' ; ?>


<div class="content-wrapper">

     <div style='padding-left:20px; color:#7F400B'><h3>Create a New Task</h3></div>
     <hr/>
    <div class="container-fluid main_container">

      <div id='placeholder' style='margin-top:-20px'>



      <div class="row" style="margin-bottom:20px">

      <div class="col-lg-6 col-md-6 col-sm-6">
        <a href="#">
        <div class="card">
        <div class="container">
         <br/>
         <table class='table table-bordered table-striped apptables'>
           <thead>
           <tr style="font-size:15px; font-weight:700">
             <td>Task</td>
             <td>Start Date</td>
             <td>End Date</td>
             <td>Edit</td>
             <td>Delete</td>
           </tr>
         </thead>

           <?php
              foreach ($data['task'] as $get):
            ?>
           <tr>
             <td><?php echo $get->taskname  ?></td>
             <td><?php echo $get->startdate  ?></td>
             <td><?php echo $get->enddate  ?></td>
             <td><a href='<?php echo URLROOT.'/task/edittask/'.$get->id ?>'><i class='fa fa-pencil'> </i></a></td>
             <td><a href='#' class='deletetask' taskid = '<?php echo $get->id   ?>'><i class='fa fa-trash-o'> </i></a></td>
           </tr>
           <?php
            endforeach;
            ?>
         </table>

        </div>
        </div>
        </a>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6">
      <a href="#">
      <div class="card">
      <div class="container">
        <form  method='post' >
        <table  class='table table-bordered table-condensed' style='font-size:12px'>

        <tr>
        <td>Task Name</td>
        <td colspan="2"><input type="text" class="form-control" name="taskname" required  /></td>
       </tr>

       <tr>
        <td>Start Date</td>
        <td><input type="text" class="form-control" name="startdate" id='from' required >
          <td><input type="text" class="form-control time" name="starttime" id='starttime' required  placeholder='Select time'></td>
        </td>
       </tr>

       <tr>
        <td>End Date</td>
        <td><input type="text" class="form-control" name="endate" id='to' required /></td>
          <td><input type="text" class="form-control time" name="endtime" id='endtime' required placeholder="select time" ></td>
       </tr>

       <tr>
        <td>Description</td>
        <td colspan="2"><textarea type="text" name='description' class="form-control"></textarea></td>
       </tr>


       <tr>
        <td></td>
        <td colspan="2"><button name='savetask' type='submit' class='btn btn-warning'>Save Task</button></td>
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
  <script type='text/javascript'>
  $('#starttime').timepicker({ 'timeFormat': 'H:i:s' });
  $('#endtime').timepicker({ 'timeFormat': 'H:i:s' });

  </script>
