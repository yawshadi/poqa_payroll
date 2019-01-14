<style>
tr, td{
  padding:2px
}

</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/taskmenu.php' ; ?>


<div class="content-wrapper">
  <div style='padding-left:20px; color:#7F400B'><h3>ACTIVE TASK</h3></div>
  <hr/>

    <div class="container-fluid main_container">



      <div id='placeholder' style='margin-top:-30px'>

      <div class="row" style="margin-bottom:20px">

      <div class="col-lg-12 col-md-12 col-sm-12">
        <a href="#">
        <div class="card">
        <div class="container">
         <br/>
         <table class='table table-bordered table-striped apptables'>
           <thead>
           <tr style="font-size:15px; font-weight:700">
             <td>Task</td>
             <td>Date Assigned</td>
             <td>Start Date</td>
             <td>End Date</td>
             <td>View</td>
           </tr>
          </thead>

           <?php

           print_r($data);

              foreach ($data['activetask'] as $get):
            ?>
           <tr>
             <td><?php echo $get['taskname'];  ?></td>
             <td><?php echo $get['dateassigned'];  ?></td>
             <td><?php echo $get['startdate'];  ?></td>
             <td><?php  echo $get['enddate'] ?></td>
             <td><a href="<?php echo URLROOT.'/task/evaluatetask/'.$get['taskid']  ?>">View</a></td>
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
