<?php

ob_start();

?>


<div style='width:80%'>

  <table width="700">
    <tr>
      <td width="400"><h1>VAMED Engineering GmbH</h1> </td>
      <td width="179" rowspan="2"><img src='<?php echo URLROOT.'/img/vamed.png';  ?>' height=50  width=80 /></td>
    </tr>
    <tr>
      <td>Ghana Branch Office</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr style="font-weight:700">
      <td>PAYSLIP</td>
      <td><?php  echo $data['payrolldata']['enddate'];   ?></td>
    </tr>
  </table>
  <p></p>
  <div style="width:80%">
  <table  class='table table-bordered '>

    <tr>
     <td width=150>Staff Name:</td>
     <td class="vas"><?php echo $data['payrolldata']['fullname']  ?></td>
    </tr>
    <tr>
     <td>Position:</td>
     <td class="getvisaemployees"><?php echo $data['payrolldata']['position']  ?></td>
    </tr>

    <tr>
     <td>Social Sec. No:</td>
     <td class="vas"><?php echo $data['payrolldata']['ssnitnumber']  ?></td>
    </tr>

    <tr>
     <td>BBG Details:</td>
     <td class="vas"><?php echo   $data['payrolldata']['accountnumber'] . '-'.$data['payrolldata']['branch'];
       ?></td>
    </tr>

  </table>
</div>
<hr/>
<p></p>

<table class='table table-bordered '>

    <tr style="font-weight:700; font-size:15px;">
     <td width="300">Basis for Calculation</td>
     <td>Total (GHs)</td>
    </tr>

    <tr style="color:#00ACE5; font-weight:700">
     <td colspan=2>Income</td>
    </tr>


    <tr>
     <td>Basic Salary</td>
     <td class="vas"><?php echo payround($data['payrolldata']['basic_salary'])  ?></td>
    </tr>

    <tr>
     <td>5.5% Staff SSNIT Contribution</td>
     <td class="vas"><?php echo payround($data['payrolldata']['staffssnit'])  ?></td>
    </tr>

    <tr>
        <td>Transport Allowance</td>
        <td class="vas"><?php echo payround($data['payrolldata']['transportvehiclemaintenance'])  ?></td>
    </tr>

    <tr>
        <td>Rent Allowance</td>
        <td class="vas"><?php echo payround($data['payrolldata']['rentallowance'])  ?></td>
    </tr>

    <tr  style="background:#00ACE5; font-size:20px; color:#fff">
        <td>Gross Income</td>
        <td class='vas'><?php echo payround($data['payrolldata']['grossincome'])  ?></td>
    </tr>

    <tr>
     <td colspan="2"><br/></td>
    </tr>

    <tr  style="color:#00ACE5; font-weight:700">
     <td colspan=2>Bonuses</td>
    </tr>
    <tr>
     <td>50% Standard Overtime</td>
     <td class='vas'><?php echo payround($data['payrolldata']['standardovertime'])  ?></td>
    </tr>
    <tr>
     <td>Team Development & Weekend Bonus</td>
      <td class='vas'><?php echo payround($data['payrolldata']['teamdevelopment'])  ?></td>
    </tr>
    <tr>
     <td>Saturdays, Sundays, & Public Holidays Overtime	</td>
      <td class='vas'><?php echo payround($data['payrolldata']['satsunholovertime'])  ?></td>
    </tr>
    <tr style="background:#00ACE5; font-size:15px; color:#fff">
     <td>Total Bonuses</td>
        <td class="vas"><?php echo payround($data['payrolldata']['totalbonus'])  ?></td>
    </tr>

    <tr>
     <td colspan="2"><br/></td>
    </tr>

    <tr  style="color:#00ACE5; font-weight:700">
     <td colspan="2">Deductions</td>
    </tr>
    <tr>
     <td>Tax Relief</td>
         <td class='vas'><?php echo payround($data['payrolldata']['taxrelief'])  ?></td>
    </tr>
    <tr>
     <td>Taxable Income</td>
      <td class='vas'><?php echo payround($data['payrolldata']['taxableincome'])  ?></td>
    </tr>
    <tr>
     <td>PAYE Tax Payable </td>
         <td class='vas'><?php echo payround($data['payrolldata']['paye'])  ?></td>
    </tr>
    <tr>
     <td>WHT on Overtime</td>
      <td class='vas'><?php echo payround($data['payrolldata']['whtonstandardovertime'])  ?></td>
    </tr>
    <tr>
     <td>WHT on Excess Overtime</td>
        <td class='vas'><?php echo payround($data['payrolldata']['whtonsatsunholovertime'])  ?></td>
    </tr>

    <tr>
     <td>Bonus Tax</td>
         <td class='vas'><?php echo payround($data['payrolldata']['bonustax'])  ?></td>
   </tr>


    <tr>
     <td>Total Tax Payable</td>
         <td class='vas'><?php echo payround($data['payrolldata']['totaltaxpayable'])  ?></td>
    </tr>

    <tr>
     <td>Staff Welfare Association Contribution</td>
         <td class='vas'><?php echo payround($data['payrolldata']['staffwelfare'])  ?></td>
    </tr>

    <tr>
     <td colspan="2"></td>
    </tr>

    <tr  style="background:#00ACE5; font-size:15px; color:#fff">
    <td>Net Amount Payable to Staff Account</td>
        <td class='vas'><?php echo payround($data['payrolldata']['vamedwelfarenetsalary'])  ?></td>
    </tr>

  </table>

  <br/>
  </div>

  <?php

      $content = ob_get_clean();

      try
      {
          // init HTML2PDF
          $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(15, 20, 15, 5));
          // display the full page
          $html2pdf->pdf->SetDisplayMode('fullpage');
          // convert
          $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

          // send the PDF
          $pdffile = $html2pdf->Output('payroll.pdf','F');//,'D');
          $fp = fopen('payroll.pdf','r');

          Header('Content-Type: application/pdf');
      		Header('Content-Description: File Transfer');
      		Header('Content-Disposition: inline; filename='.basename($file_name));
      		Header('Content-Transfer-Encoding: binary');
      		Header('Expires: 0');
      		Header('Cache-Control: must-revalidate, post-check=0, precheck=0');
      		Header('Pragma: public');
      		Header('Content-Length: '.filesize($file_name));
          print fread($fp,filesize('payroll.pdf'));

      }
      catch(HTML2PDF_exception $e) {
          echo $e;
          exit;
      }
  ?>
