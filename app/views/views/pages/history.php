<style >
tr, td{
  padding:2px
}
</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/taskmenu.php' ; ?>


<div class="content-wrapper">

  <div style='padding-left:20px; color:#7F400B'><h3>Task History</h3></div>
  <hr/>

    <div class="container-fluid main_container">

      <div id='placeholder' style='margin-top:-30px'>
        <?php //require APPROOT .'/views/inc/analysisbar.php' ; ?>
      <div class="row" style="margin-bottom:20px;">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <a href="#">
        <div class="card"
        <div class="container" style="padding:10px">
          <br/>
          <table class='table table-bordered table-striped apptables'>
            <thead>
            <tr style="font-size:15px; font-weight:700">
              <td>Task</td>
              <td>Start Date</td>
              <td>End Date</td>
              <td>Status</td>

            </tr>

          </thead>

            <?php
               foreach ($data['task'] as $get):
             ?>
            <tr>
              <td><?php echo $get->taskname  ?></td>
              <td><?php echo $get->startdate  ?></td>
              <td><?php echo $get->enddate  ?></td>
              <td><a href='#'>
                <?php  if (Assignedtask::getTaskstatus($get->id) == 1){
                         echo '<span class="badge badge-success" style="font-size:13px">Complete</span>';
                       }elseif (Assignedtask::getTaskstatus($get->id) == 0) {
                         echo '<span class="badge badge-warning" style="font-size:13px; color:#fff">Active</span>';
                       }elseif (Assignedtask::getTaskstatus($get->id) == 2) {
                         echo '<span class="badge badge-danger" style="font-size:13px; color:#fff">Incomplete</span>';
                       }elseif (Assignedtask::getTaskstatus($get->id) == '') {
                        echo '<span class="badge badge-warning" style="font-size:13px; color:#fff">Dormant</span>';
                       }
              ?>
              </a>
              </td>
            </tr>
            <?php
             endforeach;
             ?>
          </table>

          <div>

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
