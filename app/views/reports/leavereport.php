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
.btn{
  border-radius:0px !important;
  margin-top:2px;
}

</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">



  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-md-6">
          <h1 style='color:#FB6600; font-weight:700' class="page-title">Leave Report for <?= date('Y') ?></h1>

        </div>
        <div class="col-md-6">
          <button onclick="window.print()"class='btn btn-primary pull-right'>Download</button>

        </div>
   </div>

      <hr/>

<div class="row" style="margin-bottom:20px">

      <div class="col-lg-12 col-md-12 col-sm-12">

      <div class='card'>
      <div class="container">
      <br/>
      <div>
      <table  class='table table-bordered table-condensed' style='font-size:12px'>
      <tr>
          <td colspan="5" align='center' style='font-weight:700'>LEAVE DEDUCTIONS FOR <?= date('Y')?> </td>
        </tr>
      <?php
      $x=0; 
      foreach(Employee::listAll() as $employee):
      ?>
      <tr>
      <td style="padding-top:<?=($x==0)?'40px !important':'' ?>"> <?= $employee->fullname ?></td>
      <td style="text-transform:capitalize;padding-top:<?=($x==0)?'40px !important':'' ?>"><?= $employee->location ?></td>
      <td>
      <table  style='font-size:12px; color:#000' class='table table-bordered'>
        <tr style="font-weight:bold;display:<?=($x==0)?'':'none' ?>">
          <td>Leave entitled to </td>
          <td>Dates on Leave(From) </td>
          <td>Dates on Leave (To)</td>
          <td>Total No. of days applied</td>
          <td>Outstanding days</td>
        </tr>
        <?php
        $i=1;
        $leavedata = Leave::getLeave($employee->basic_id);
        if(sizeof($leavedata) > 0):
         foreach($leavedata as $get):
        ?>
        <tr>
        <td width='15%' <?= ($i==1)?"rowspan=".sizeof($leavedata):"style=display:none"?>><?php echo $employee->accumulatedleave ?></td>
          <td width='15%'><?php echo $get->startdate  ?></td>
          <td width='15%'><?php echo $get->endate  ?></td>
          <td width='15%'><?php  echo $get->actualdays  ?></td>
          <td width='15%' <?= ($i==1)?"rowspan=".sizeof($leavedata):"style=display:none"?>><?php echo Leavedays::availabledays($employee->basic_id,date('Y')) ?></td>
        </tr>
        <?php
        $i++; 
        endforeach; 
        else:
        ?>

        <tr>
         <td width='15%'><?php echo $employee->accumulatedleave ?></td>
          <td width='15%'>-</td>
          <td width='15%'>-</td>
          <td width='15%'>-</td>
          <td width='15%'><?php echo Leavedays::availabledays($employee->basic_id,date('Y')) ?></td>
        </tr>
        <?php endif; ?>
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
