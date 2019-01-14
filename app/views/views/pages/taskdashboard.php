<style>
tr, td{
  padding:2px
}

</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/taskmenu.php' ;
$n = new User($_SESSION['uid']);
$role =  $n->recordObject->role;
 ?>
<div class="content-wrapper">


    <div class="container-fluid main_container">


      <div id='placeholder' style='margin-top:-50px'>

      <?php
      if($role == 'Administrator'){
      require APPROOT .'/views/inc/analysisbar.php' ;
      }
      ?>

      <div class="row" style="margin-bottom:20px">

      <div class="col-lg-6 col-md-6 col-sm-6">
        <a href="#">
        <div class="card">
        <div class="container">
         <br/>
         <?php
         if($role == 'Administrator' || $role == 'Head of Admin' ||  $role == 'HR Manager'  ){
         require APPROOT .'/views/inc/ianalysis.php' ;
         }
        ?>

        <table class='table table-bordered table-striped apptables'>

          <thead>
          <tr style="font-size:15px; font-weight:700">
            <td>Task</td>
            <td>Start Date</td>
            <td>End Date</td>
          </tr>
        </thead>

          <?php
             foreach ($data['task'] as $get):
           ?>
          <tr>
            <td><a href='<?php echo URLROOT.'/task/taskprofile/'. $get->id;  ?>'><?php echo $get->taskname  ?></a></td>
            <td><?php echo $get->startdate  ?></td>
            <td><?php echo $get->enddate  ?></td>
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
        <?php
        if($role == 'Administrator'){
        ?>
       <div id='bar-chart'> </div>
       <?php
        }
       ?>

      <?php
        if($role !== 'Administrator'){
         require APPROOT .'/views/inc/ass.php' ;
       }

       ?>
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

    Morris.Bar({
      element: 'bar-chart',
      data: [
      { y: 'Total', a: <?php  echo  $data['totaltaskmaster']   ?> },
      { y: 'Active', a: <?php  echo  $data['assignedtaskmaster']   ?> },
      { y: 'Incomplete', a: <?php  echo  $data['uncompletedmaster']   ?> },
      { y: 'Complete', a: <?php  echo  $data['completedmaster']   ?> }

      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Quantity'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      barColors: function (row, series, type) {
      //console.log("--> "+row.label, series, type);
      if(row.label == "Complete") return "#11772D";
      else if(row.label == "Incomplete") return "#483D41";
      else if(row.label == "Active") return "#fec04c";
      else if(row.label == "Total") return "#DE561E";
      }
    });

  </script>
