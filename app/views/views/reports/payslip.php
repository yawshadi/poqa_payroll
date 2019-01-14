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
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> EMPLOYEE PAY SLIP: <?php echo $data['name']  ?> </h1>
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
      <div align='center'>

      <form method='post'>

      <table  class='table table-bordered table-condensed apptables' style='font-size:12px'>

       <tr>
       <td>
       <select class='form-control' name='company' id='company'>
       <option><?php echo $data['company']  ?></option>
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
       <td><button type='submit' name='slipbtn' class='btn btn-warning'>Search</button></td>

      </tr>

      </table>
    </form>

    <br/>

    <?php if(isset($data['payrolldata'])): ?>
    <div><a style='font-size:10px' href='<?php echo URLROOT  ?>/excelreport/payslipexcel/<?php echo $data['startdate'] ?>/<?php echo $data['enddate'] ?>/<?php echo urlencode($data['employeeid']) ?>'
   class='btn btn-danger pull-left'>Download PaySlip</a></div>
  <div style='width:100%; overflow-x:scroll; margin-top:10px'>
  <?php
    foreach($data['payrolldata'] as $key=>$get):

    ?>
  <table width="100%"  align="center" class='table table-bordered  table-condensed'>
  <tr>
    <td width="187">Payslip No</td>
    <td width="186">1</td>
    <td width="12">&nbsp;</td>
    <td width="221">&nbsp;</td>
    <td width="83"></td>
    <td width="107">Period</td>
    <td width="191"><?php  echo $data['startdate']. ' / '. $data['enddate'];  ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4"><b>OVERTIME</b></td>
  </tr>
  <tr>
    <td>Employee Code</td>
    <td><?php echo $get['staffid'];  ?></td>
    <td>&nbsp;</td>
    <td>Day(s)</td>
    <td>Hours </td>
    <td>Rate</td>
    <td>Amount</td>
  </tr>
  <tr>
    <td>Department</td>
    <td><?php echo $get['department'];  ?></td>
    <td>&nbsp;</td>
    <td>WeekDay</td>

    <td><?php //echo  $act->weekday_dayshift   ?></td>
    <td><?php //echo $var->weekday_hourly_rate  ?></td>
    <td><?php //echo $weekdayshiftbasic ?></td>
  </tr>
  <tr>
    <td>Position</td>
    <td><?php  echo $get['position']; ?></td>
    <td>&nbsp;</td>
    <td>Holiday/Weekend</td>

    <td><?php //echo $act->holiday_weekend_overtime   ?></td>
    <td><?php //echo $var->holiday_overtime_rate ?></td>
    <td><?php  //echo $holidayandweekovertimeallowance ?></td>
  </tr>
  <tr>
    <td>Name</td>
    <td><?php echo $get['fullname'];  ?></td>
    <td>&nbsp;</td>
    <td>Total</td>
    <td><?php //echo  $act->weekday_dayshift + $act->holiday_weekend_overtime  ?></td>
    <td>&nbsp;</td>
    <td><?php //echo $weekdayshiftbasic + $holidayandweekovertimeallowance  ?></td>
  </tr>
  <tr>
    <td>Bank</td>
    <td><?php echo $get['bank']; ?></td>
    <td>&nbsp;</td>
    <td>Officer's OT</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Branch</td>
    <td><?php echo $get['branch']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Account</td>
    <td><?php echo $get['accountnumber'];  ?></td>
    <td>&nbsp;</td>
    <td>No. of days/hours worked</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>SSF No</td>
    <td><?php echo $get['ssnitnumber']  ?></td>
    <td>&nbsp;</td>
    <td>Daily Hourly Rate</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tier 2 No</td>
    <td><?php echo $get['tiernumber']  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">&nbsp;</td>

  </tr>
  <tr>
    <td><strong>EARNINGS</strong></td>
    <td><strong>AMOUNT(GHC)</strong></td>
    <td>&nbsp;</td>
    <td><strong>DEDUCTIONS</strong></td>
    <td>&nbsp;</td>
    <td><strong>AMOUNT </strong></td>
    <td><strong>Taxable Salary (GHS)</strong></td>
  </tr>
  <tr>
    <td>Monthly Wage</td>
    <td><?php  echo $get['basic_salary'];   ?></td>
    <td>&nbsp;</td>
    <td>SSF Employee (5.5%)</td>
    <td></td>
    <td><?php  echo $get['ssnitpercent'];   ?></td>
    <td><?php //echo $taxable   ?></td>
  </tr>
  <tr>
    <td>Overtime</td>
    <td><?php  echo payround($get['overtime']);   ?></td>
    <td>&nbsp;</td>
    <td>Income Tax </td>
    <td></td>
    <td><?php  echo $get['paye']  ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Transport Allowance</td>
    <td><?php //echo $var->transport_allowance  ?></td>
    <td>&nbsp;</td>
    <td>Overtime Tax</td>
    <td></td>
    <td><?php echo payround($get['overtimetax']);  ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Night Allowance</td>
    <td><?php echo $get['nightshiftallowance'];  ?></td>
    <td>&nbsp;</td>
    <td>Loan</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Other Deductions</td>
    <td></td>
    <td><?php echo $get['otherdeductions']  ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Gross</td>
    <td><?php echo $get['overallgross']  ?></td>
    <td>&nbsp;</td>
    <td>Total Deductions</td>
    <td><?php echo payround($get['totaldeduction'])  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Net Pay</td>
    <td><?php echo payround($get['netsalary'])   ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" style='font-weight:700'>Employers Contributions</td>
  </tr>
  <tr>
    <td>SSF Employer (15%)</td>
    <td><?php  echo payround($get['ssnitocompany'])  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Total SSF</td>
    <td><?php  echo payround($get['totalssf'])  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
    <?php
     endforeach;
    ?>

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
