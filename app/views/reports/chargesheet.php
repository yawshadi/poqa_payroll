<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/report.php' ; ?>
<?php
function payround($item){
return number_format(round($item,2),2);
}
?>


<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
}

</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">



  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title">CHARGES SHEET REPORT </h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>

      </div>



<div class="row" style="margin-bottom:20px">




      <div class="col-lg-12 col-md-12 col-sm-12">

      <div class='card'>
      <div class="container">
      <br/>
      <div align='center'>

      <form method='post'>

      <table  class='table table-bordered table-condensed apptables' style='font-size:12px'>

       <tr>
       <td>
       <select class='form-control' name='company' id='company'>
       <option>Select Company</option>
       <?php
       foreach($data['companies'] as $get):
       ?>
       <option><?php echo $get->companyname   ?></option>
       <?php
        endforeach;
       ?>

       </select></td>
       <td><select class='form-control' name='startdate'>
       <option>Payroll Start</option>
       <?php
       foreach($data['payperiod'] as $get):
       ?>
       <option value='<?php echo $get->start  ?>'><?php echo date('d-M-y', strtotime($get->start))  ?></option>
       <?php
        endforeach;
       ?>
       </select>
       </td>
       <td>
       <select class='form-control' name='enddate'>
       <option>Payroll End</option>
       <?php
       foreach($data['payperiod'] as $get):
       ?>
       <option value='<?php echo $get->end  ?>'><?php echo date('d-M-y', strtotime($get->end))  ?></option>
       <?php
        endforeach;
       ?>
       </select>

       </td>
       <td><button type='submit' name='chargesbtn' class='btn btn-warning'>Search</button></td>

      </tr>

      </table>
    </form>
    <br/>

    <?php if(isset($data['payrolldata'])): ?>

    <div style='width:100%; overflow-y:scroll; margin-top:10px'>

  <div><a style='font-size:10px' href='<?php echo URLROOT  ?>/excelreport/actualexcel/<?php echo $data['startdate'] ?>/<?php echo $data['enddate'] ?>/<?php echo urlencode($data['companyid']) ?>'
   class='btn btn-danger pull-right'>Download</a></div>
  <br/>
  <table class='table table-bordered table-condensed' >
  <tr>

    <td>Employee Name</td>
      <td>Department</td>
      <td>Position</td>
      <td>Total Full Present Hrs</td>
      <td>Basic Salary</td>
      <td>Transport Allowance</td>
      <td>Gross</td>
      <td>Weekday Hourly Rate</td>
      <td>Weekday Overtime Rate</td>
      <td>Holiday & Weekend Overtime Rate</td>
      <td>Night Shift Allowance</td>

      <td>Weekday Day Shift Hours</td>
      <td>Weeday  Night Shift Hours</td>
      <td>Weekday Overtime Hours</td>
      <td>Holiday & Weekend Overtime Hours</td>

      <td>Weekday Shift Basic</td>
     <td>Weekday Night Shift Basic</td>
     <td>Weekday Overtime Allowance</td>
     <td>Holiday and Weekend Overtime Allowance</td>
     <td>Night Shift Allowance</td>
     <td>T&T Actual Present </td>

    <td>Total Wage </td>
    <td>Total Overtime </td>
    <td>Overtime tax </td>
    <td>Other Allowance </td>
    <td>Other Deductions</td>

    <td>Overall Gross </td>
    <td>SSF Basic</td>
    <td>Total Actual Fees</td>
   <td>13% MGT Charges</td>
   <td>Vat ON MGT Charges</td>
   <td>To Company</td>


   </tr>
    <?php
    foreach($data['payrolldata'] as $key=>$get):

    ?>
    <tr>
      <td><?php echo $get['fullname']  ?></td>
      <td><?php echo $get['department']  ?></td>
      <td><?php echo $get['position']  ?></td>
      <td><?php echo $get['total_full_present']     ?></td>
      <td><?php echo $get['basic_salary']    ?></td>
      <td><?php echo $get['transport_allowance']     ?></td>
      <td><?php echo $get['gross']     ?></td>
      <td><?php echo $get['weekday_hourly_rate']    ?></td>
      <td><?php echo $get['weekday_overtime_rate']  ?></td>
      <td><?php echo $get['holiday_overtime_rate']   ?></td>
      <td><?php echo $get['night_shift_allowance']   ?></td>

      <td ><?php echo $get['weekday_dayshift']     ?></td>
      <td ><?php echo $get['weekday_nightshift']  ?></td>
      <td ><?php echo $get['weekday_overtime']   ?></td>
      <td ><?php echo $get['holiday_weekend_overtime'];   ?></td>

       <td><?php  echo payround($get['weekdayshiftbasic']);  ?></td>
       <td><?php  echo payround($get['weekdaynightshitbasic']) ?></td>
       <td><?php  echo payround($get['weekdayovertimeallowance']) ?></td>
       <td><?php  echo payround($get['holidayandweekovertimeallowance']) ?></td>
       <td><?php  echo payround($get['nightshiftallowance'])  ?></td>
       <td><?php  echo payround($get['transportactualpresent'])  ?> </td>

       <td><?php echo payround($get['totalwage']) ?></td>
       <td><?php echo payround($get['totalovertime']) ?></td>
       <td><?php echo payround($get['overtimetax']) ?></td>
       <td><?php echo payround($get['otherallowances'])   ?></td>
       <td><?php echo payround($get['otherdeductions']) ?></td>

       <td><?php  echo payround($get['overallgross']) ?></td>
       <td><?php  echo payround($get['ssfbasic']) ?></td>
       <td><?php  echo payround($get['actualfees']) ?></td>
       <td><?php  echo payround($get['mgtcharges']) ?></td>
       <td><?php  echo payround($get['vatmgtaxes']) ?> </td>
       <td><?php  echo payround($get['tocompany']) ?></td>

    </tr>
    <?php
    endforeach;
    ?>
   </table>

    </div>

    <?php
     endif;
   ?>


      </div>
     </div>
     </div>

      </div>


      </div>




      <!-- End of first upper row -->


      <div class="row" style="margin-bottom:20px">




      </div>
    </div>   <!-- End of Placeholder -->

    </div>
    </div>
    <?php require APPROOT .'/views/inc/footer.php'  ?>
