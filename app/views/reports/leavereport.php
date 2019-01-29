<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/report.php' ; ?>


<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
}

.vas{
  font-weight: 700;
  font-size: 12px;
}

</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">



  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title">Leave Report for <?= date('Y') ?></h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>


      <?php //require APPROOT .'/views/inc/dash.php' ; ?>


      </div>



<div class="row" style="margin-bottom:20px">

      <div class="col-lg-12 col-md-12 col-sm-12">

      <div class='card'>
      <div class="container">
      <br/>
      <div>

      <table  class='table table-bordered table-condensed' style='font-size:12px'>
      <tr>
          <td colspan="5" align='center' style='font-weight:700'>LEAVES REQUEST </td>
        </tr>
      <?php
      $x=0; 
      foreach(Employee::listAll() as $employee):
      ?>
      <tr>
      <td> <?= $employee->fullname ?></td>
      <td>
      <table  style='font-size:12px; color:#000' class='table table-bordered'>
        <tr style="display:<?=($x==0)?'':'none' ?>">
          <td>Leave entitled to </td>
          <td>Dates on Leave(From) </td>
          <td>Dates on Leave (To)</td>
          <td>Total No. of days applied</td>
          <td>Outstanding days</td>
        </tr>
        <?php
        $i=1;
        $leavedata = Leave::getLeave($employee->basic_id);
         foreach($leavedata as $get):
        ?>
        <tr>
        <td <?= ($i==1)?"rowspan=".sizeof($leavedata):"style=display:none"?>><?php echo $employee->accumulatedleave ?></td>
          <td><?php echo $get->startdate  ?></td>
          <td><?php echo $get->endate  ?></td>
          <td><?php  echo $get->actualdays  ?></td>
          <td <?= ($i==1)?"rowspan=".sizeof($leavedata):"style=display:none"?>><?php echo Leavedays::availabledays($employee->basic_id,date('Y')) ?></td>
        </tr>
        <?php
        $i++; 
        endforeach; 
        ?>
      </table>
      
      
      </td>
      </tr>
    <?php 
    $x++;
    endforeach;
    ?>
      </table>
   
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>

      <div class="row" style="margin-bottom:20px"> </div>
    </div>   <!-- End of Placeholder -->

    </div>
    </div>
    <?php require APPROOT .'/views/inc/footer.php'  ?>
