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
      <div>

      <form method='post'>

      <table  class='table table-bordered table-condensed' style='font-size:12px'>

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
  </div>

    <br/>

    <?php if(isset($data['payrolldata'])): ?>

     

      
  <div style='width:70%; margin-top:10px'>


      <table>
          <tr>
              <!-- <td><a style='font-size:10px' href='<?php echo URLROOT  ?>/payslip/slipdf/<?php echo $data['startdate'] ?>/<?php echo $data['enddate'] ?>/<?php echo urlencode($data['employeeid']) ?>'
                     class='btn btn-danger pull-right'>Download PDF</a></td> -->
              <td><a style='font-size:10px' href='<?php echo URLROOT  ?>/payslip/slipexcel/<?php echo $data['startdate'] ?>/<?php echo $data['enddate'] ?>/<?php echo urlencode($data['employeeid']) ?>'
                     class='btn btn-danger pull-right'>Download EXCEL</a></td>
              <td><button style='font-size:10px' onclick="test()" class='btn btn-warning pull-right'>Download PDF</button></td>
          </tr>
      </table>
      <div id='pdfprint'>
     <div style="display: none;" align='center'><img src="<?php echo URLROOT ?>/img/vamed.png" alt="Vamed"></div>
     <br>
    <div style="width:100%">
    <table  class='table table-bordered '>
      <tr>
       <td>Staff Name</td>
       <td class="vas"><?php echo $data['payrolldata']['fullname']  ?></td>
      </tr>
      <tr>
       <td>Position</td>
       <td class="getvisaemployees"><?php echo $data['payrolldata']['position']  ?></td>
      </tr>
      <tr>
       <td>Job Category</td>
       <td class="getvisaemployees"><?php echo $data['payrolldata']['jodcat']  ?></td>
      </tr>

      <tr>
       <td>Social Security No:</td>
       <td class="vas"><?php echo $data['payrolldata']['ssnitnumber']  ?></td>
      </tr>

      <tr>
       <td>BBG Details</td>
       <td class="vas"><?php echo $data['payrolldata']['bankname'] . '<br>'.
            $data['payrolldata']['accountnumber'] . '-'.$data['payrolldata']['branch'];
         ?></td>
      </tr>
      <tr>
       <td>Tier 2 Number</td>
       <td class="vas"><?php echo $data['tier2']  ?></td>

      </tr>
      <tr>
       <td>Tier 3 Number</td>
       <td class="vas"><?php echo $data['tier3'] ?></td>

      </tr>

    </table>
  </div>
  <table class='table table-bordered '>

<tr style="font-weight:700; font-size:15px;">
 <td width="300">Basis for Calculation</td>
 <td>Total (GHs)</td>
</tr>

<tr style="color:#00ACE5; font-weight:700">
 <td colspan=2>Income</td>
</tr>


<tr>
 <td>Consolidated Salary</td>
 <td class="vas"><?php echo payround($data['payrolldata']['basic_salary'])  ?></td>
</tr>

<tr>
 <td>5.5% Staff SSNIT Contribution</td>
 <td class="vas"><?php echo payround($data['payrolldata']['staffssnit'])  ?></td>
</tr>

<tr>
    <td>5% Provident Fund</td>
    <td class="vas"><?php echo payround($data['payrolldata']['providentfund'])  ?></td>
</tr>

<tr>
    <td>Other Benefits / Allowances</td>
    <td class="vas"><?php echo payround($data['payrolldata']['otherbenefits'])  ?></td>
</tr>


<tr  style="background:#00ACE5; font-size:20px; color:#fff">
    <td>Gross Salary</td>
    <td class='vas'><?php echo payround($data['payrolldata']['grossincome'])  ?></td>
</tr>
<tr>
 <td colspan="2"><br/></td>
</tr>

<tr>
 <td>Monthly Loan Repayment</td>
 <td class='vas'><?php echo payround($data['payrolldata']['loanrepayment'])  ?></td>
</tr>
<tr>
 <td>Loan Benefits</td>
 <td class='vas'><?php echo payround($data['payrolldata']['loanbenefits'])  ?></td>
</tr>
<tr>
 <td>Tax Relief	</td>
  <td class='vas'><?php echo payround($data['payrolldata']['taxrelief'])  ?></td>
</tr>

<tr>
 <td>Taxable Income	</td>
  <td class='vas'><?php echo payround($data['payrolldata']['taxableincome'])  ?></td>
</tr>
<tr>
 <td>PAYE Tax Payable </td>
     <td class='vas'><?php echo payround($data['payrolldata']['paye'])  ?></td>
</tr>

<tr>
 <td>Bonus </td>
     <td class='vas'><?php echo payround($data['payrolldata']['bonus'])  ?></td>
</tr>

<tr>
 <td>Bonus Tax</td>
     <td class='vas'><?php echo payround($data['payrolldata']['bonustax'])  ?></td>
</tr>

<tr>
 <td>Total Tax Payable</td>
     <td class='vas'><?php echo payround($data['payrolldata']['totaltaxpayable'])  ?></td>
</tr>

<tr style="background:#00ACE5; font-size:15px; color:#fff">
 <td>Total Cash Emoluments</td>
    <td class="vas"><?php echo payround($data['payrolldata']['vamedwelfarenetsalary'])  ?></td>
</tr>

<tr>
 <td colspan="2"><br/></td>
</tr>


<tr>
    <td>Salary Advance</td>
    <td class='vas'><?php echo payround($data['payrolldata']['salaryadvance'])  ?></td>
</tr>
<tr>
    <td>Net Salary</td>
    <td class='vas'><?php echo payround($data['payrolldata']['vamednetpay'])  ?></td>
</tr>
<tr>
 <td>Staff Welfare Association Contribution</td>
     <td class='vas'><?php echo payround($data['payrolldata']['staffwelfare'])  ?></td>
</tr>

<tr>
    <td>Other deductible</td>
    <td class='vas'><?php echo payround($data['payrolldata']['otherdeductible'])  ?></td>
</tr>

<tr>
 <td colspan="2"></td>
</tr>

<tr  style="background:red; font-size:15px; color:#fff">
<td>Net Amount Payable to Staff Account</td>
    <td class='vas'><?php echo payround($data['payrolldata']['vamedwelfarenetsalary'])  ?></td>
</tr>

<tr style="color:#00ACE5; font-weight:700">
    <td colspan="2">Monthly Contributions</td>
</tr>

<tr>
    <td>Tier 1 - SSF @ 13.5%</td>
    <td><?php  echo $data['payrolldata']['staffssnit']  ?></td>
</tr>

<tr>
    <td>Tier 2 - OPS @ 5%</td>
    <td><?php  echo $data['payrolldata']['secondtier']    ?></td>
</tr>

<tr>
    <td>Tier 3 - PF @ 10%</td>
    <td><?php  echo $data['payrolldata']['tier3'] ?></td>
</tr>

</table>
    <br/>


    </div>
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
    <script>
      function test() {
        // Get the element.
        var element = document.getElementById('pdfprint');
        console.log('hi')
        // Generate the PDF.
        html2pdf().from(element).set({
          margin: 1,
          filename: '<?php echo $data['payrolldata']['fullname']  ?>.pdf',
          html2canvas: { scale: 2 },
          jsPDF: {orientation: 'portrait', unit: 'in', format: 'letter', compressPDF: true}
        }).save();
      }
    </script>