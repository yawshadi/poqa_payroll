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


       <td><button type='submit' name='mainpayrollbtn' class='btn btn-warning'>Search</button></td>

      </tr>

      </table>
    </form>
    <br/>



  <?php if(isset($data['payrolldata'])){ ?>

  <div style='width:100%; margin-top:10px'>

  <div><a style='font-size:10px' href='<?php echo URLROOT  ?>/excelreport/actualexcel/<?php echo $data['startdate'] ?>/<?php echo $data['enddate'] ?>/<?php echo urlencode($data['companyid']) ?>'
       class='btn btn-danger pull-right'>Download</a></div>
  <br/>

  <table class='table table-bordered table-condensed' id='payrolltable' >
  <tr style="font-weight:700">
      <td>No:</td>
      <td>Employee Name</td>
      <td>Department</td>
      <td>Position</td>
      <td>Location</td>
      <td>Basic Salary</td>
      <td>Gross Income</td>
      <td>Total Tax Payable</td>
      <td>Actual Netpay </td>
      <td>Netpay to Staff</td>


   </tr>
    <?php
    foreach($data['payrolldata'] as $key=>$get):

    ?>
    <tr>
      <td><?php echo $key + 1  ?></td>
      <td><?php echo $get['fullname']  ?></td>
      <td><?php echo $get['department']  ?></td>
      <td><?php echo $get['position']  ?></td>
      <td><?php echo $get['location']     ?></td>
      <td><?php echo payround($get['basic_salary'])   ?></td>
      <td><?php echo payround($get['grossincome'])     ?></td>
      <td><?php echo payround($get['totaltaxpayable'])    ?></td>
      <td><?php echo payround($get['vamednetpay'])   ?></td>
      <td><?php echo payround($get['vamedwelfarenetsalary'])  ?></td>


    </tr>
    <?php
    endforeach;
    ?>
   </table>

    </div>
    <?php }  ?>

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
