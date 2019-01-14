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

</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">



  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> MAIN PAYROLL REPORT </h1>
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
       <select class='form-control' name='company' id='company' required>
       <option>Select Company</option>
       <?php
       foreach($data['companies'] as $get):
       ?>
       <option><?php echo $get->companyname   ?></option>
       <?php
        endforeach;
       ?>

       </select></td>
       <td><select class='form-control' name='startdate' required>
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
       <select class='form-control' name='enddate' required>
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

       <td>
       <select class='form-control' name='payrolltype' required>
       <option value=''>Type of Payroll</option>
       <option value='Casual'>Casual</option>
       <option value='Officer'>Officer</option>
       </select>

       </td>

       <td><button type='submit' name='mainpayrollbtn' class='btn btn-warning'>Search</button></td>

      </tr>

      </table>
    </form>
    <br/>

  <?php if(isset($data['payrolltype'] )) {   ?>

  <?php if($data['payrolltype'] == 'Casual'){   ?>

  <?php if(isset($data['payrolldata'])){ ?>

  <div style='width:100%; overflow-y:scroll; margin-top:10px'>

  <div><a style='font-size:10px' href='<?php echo URLROOT  ?>/excelreport/actualexcel/<?php echo $data['startdate'] ?>/<?php echo $data['enddate'] ?>/<?php echo urlencode($data['companyid']) ?>'
   class='btn btn-danger pull-right'>Download</a></div>
  <br/>
  <table class='table table-bordered table-condensed' >
  <tr>
      <td>ID</td>
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
    <td>SSF (5.5%)</td>
    <td>Taxable</td>
    <td>PAYE</td>
    <td>Total Tax</td>
    <td>Total Deductions</td>
    <td>Net Pay</td>
    <td>SSNIT Company (13%)</td>
    <td>Total Cost Of Salary</td>

   </tr>
    <?php
    foreach($data['payrolldata'] as $key=>$get):

    ?>
    <tr>
      <td><?php echo $get['basic_id']  ?></td>
      <td><?php echo $get['fullname']  ?></td>
      <td><?php echo $get['department']  ?></td>
      <td><?php echo $get['position']  ?></td>
      <td><?php echo $get['total_full_present']     ?></td>
      <td><?php echo payround($get['basic_salary'])   ?></td>
      <td><?php echo payround($get['transport_allowance'])     ?></td>
      <td><?php echo payround($get['gross'])    ?></td>
      <td><?php echo payround($get['weekday_hourly_rate'])   ?></td>
      <td><?php echo payround($get['weekday_overtime_rate'])  ?></td>
      <td><?php echo payround($get['holiday_overtime_rate'])   ?></td>
      <td><?php echo payround($get['night_shift_allowance'])   ?></td>

      <td ><?php echo payround($get['weekday_dayshift'])     ?></td>
      <td ><?php echo payround($get['weekday_nightshift'])  ?></td>
      <td ><?php echo  payround($get['weekday_overtime'])   ?></td>
      <td ><?php echo  payround($get['holiday_weekend_overtime']);   ?></td>

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
       <td><?php  echo payround($get['ssfemp']); ?></td>
       <td><?php  echo payround($get['taxable']) ?></td>
       <td><?php  echo payround($get['paye']) ?></td>
       <td><?php  echo payround($get['totaltax']) ?></td>
       <td><?php  echo payround($get['totaldeduction']) ?></td>
       <td><?php  echo payround($get['netpay']) ?></td>

       <td><?php  echo payround($get['ssnitcompany']) ?></td>
       <td><?php  echo payround($get['totalsalarycost']) ?></td>

    </tr>
    <?php
    endforeach;
    ?>
   </table>

    </div>
    <?php }  ?>
    <?php }  ?>



      <?php if($data['payrolltype'] == 'Officer'){   ?>

      <?php if(isset($data['payrolldata'])){ ?>

      <div style='width:100%; overflow-y:scroll; margin-top:10px'>

      <div><a style='font-size:10px' href='<?php echo URLROOT  ?>/excelreport/actualexcel/<?php echo $data['startdate'] ?>/<?php echo $data['enddate'] ?>/<?php echo urlencode($data['companyid']) ?>'
       class='btn btn-danger pull-right'>Download</a></div>
      <br/>
      <table class='table table-bordered table-condensed' >
      <tr>
          <td>ID</td>
          <td>Employee Name</td>
          <td>Department</td>
          <td>Position</td>
          <td>Weekdays</td>
          <td>Basic Salary</td>
          <td>Transport Allowance</td>
          <td>Fix Overtime</td>
          <td>Weekday Present Salary</td>
          <td>Weekday Daily Rate</td>
          <td>Weekend Daily Rate</td>
          <td>Holiday Daily Rate</td>

          <td>Weeday Present Days</td>
          <td>Saturday Present Days </td>
          <td>Sunday Present Days</td>
          <td>Holiday Present Days</td>
          <td>COMPTIMES (Days)</td>

          <td>Weekday Salary</td>
          <td>Saturday Salary</td>
          <td>Sunday Salary</td>
          <td>Holiday Salary</td>
          <td>T & T Salary</td>
          <td>Fixed Overtime Present</td>
          <td>Total Overtime</td>
          <td>Overtime Tax</td>
          <td>Other Allowance</td>
          <td>Other Deduction</td>
          <td>Gross</td>
          <td>Acture Basic For SSF Calculation</td>

          <td>SSF Basic (5.5%)</td>
          <td>Taxable</td>
          <td>PAYE</td>
          <td>Total Tax</td>
          <td>Total Deduction </td>
          <td>Net Pay </td>
          <td>SSNIT Company (13%) </td>
          <td>Total Salary Cost </td>


       </tr>
        <?php
        foreach($data['payrolldata'] as $key=>$get):

        ?>
        <tr>
          <td><?php echo $get['basic_id']  ?></td>
          <td><?php echo $get['fullname']  ?></td>
          <td><?php echo $get['department']  ?></td>
          <td><?php echo $get['position']  ?></td>
          <td><?php echo $get['weekdays']  ?></td>
          <td><?php echo $get['officerbasic']  ?></td>
          <td><?php echo $get['officertransport']  ?></td>
          <td><?php echo $get['fixovertime']  ?></td>
          <td><?php echo $get['weekdayspresentsalary']  ?></td>
          <td><?php echo $get['weekdaydailyrate']  ?></td>
          <td><?php echo $get['weekendrate']  ?></td>
          <td><?php echo $get['holidayrate']  ?></td>

          <td><?php echo $get['weekdaypresentdays']  ?></td>
          <td><?php echo $get['saturdaypresentdays']  ?></td>
          <td><?php echo $get['sundaypresentdays']  ?></td>
          <td><?php echo $get['holidaypresentdays']  ?></td>
          <td><?php echo $get['companytimehours']  ?></td>

          <td><?php echo $get['weekdaysalary']  ?></td>
          <td><?php echo $get['saturdaysalary']  ?></td>
          <td><?php echo $get['sundaysalary']  ?></td>
          <td><?php echo $get['holidaysalary']  ?></td>
          <td><?php echo $get['officertandtpresent']  ?></td>
          <td><?php echo $get['fixedovertimepresent']  ?></td>
          <td><?php echo $get['officertotalovertime']  ?></td>
          <td><?php echo $get['officerovertimetax']  ?></td>
          <td><?php echo $get['officerotherallowances']  ?></td>
          <td><?php echo $get['officerotherdeductions']  ?></td>
          <td><?php echo $get['officergross']  ?></td>
          <td><?php echo $get['acturebasic']  ?></td>

          <td><?php echo $get['officerssf']  ?></td>
          <td><?php echo $get['officertaxable']  ?></td>
          <td><?php echo $get['officerpaye']  ?></td>
          <td><?php echo $get['officertotaltax']  ?></td>
          <td><?php echo $get['officertotaldeduction']  ?> </td>
          <td><?php echo $get['officernetpay']  ?> </td>
          <td><?php echo $get['officerssnitcompany']  ?> </td>
          <td><?php echo $get['officertotalsalarycost']  ?></td>


        </tr>
        <?php
        endforeach;
        ?>
       </table>

        </div>
        <?php }  ?>
        <?php }  ?>
        <?php } ?>

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
