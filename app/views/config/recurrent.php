<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/system.php' ; ?>

<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
  font-size:12px
}

</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">


  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> SET EMPLOYEE PAYROLL RECURRENT VALUES </h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>


      <?php // require APPROOT .'/views/inc/dash.php' ; ?>


      </div>



<div class="row" style="margin-bottom:20px">


     <div class="col-lg-12 col-md-12 col-sm-12">
     <div class = 'card'>
     <form method='post'>


      <table  class='table table-bordered table-condensed' style='font-size:12px'>

       <tr>

       <td>
       <select class='form-control' id='compval' name='company' required>
       <option value=''>Select Company</option>
       <?php
       foreach($data['companies'] as $get):
       ?>
       <option><?php echo $get->companyname   ?></option>
       <?php
        endforeach;
       ?>

       </select>

       </td>
       <td><select class='form-control' id='department' name='department' required>
       <option value=''>Select Department</option>

       </select></td>
       <td><button class='btn btn-danger' type='submit' name='getallemployees' > Add </button></td>
      </tr>



      </table>

      </form>

      </div>

      <div id='ajaxcontainer'></div>

      <?php  if(isset($data['employeedata'])){  ?>
      <table id='success'  class='table datatable table-bordered table-condensed'>
  	<thead>
	   <tr style='font-weight:700'>
  		<td>Employee</td>
  		<td  style=''>Tax Relief</td>
  		<td  style=''>Salary Advance </td>
  		<td  style=''>Staff Welfare Association</td>
      <td style='display:none'>PAYE</td>

     </tr>
      </thead>
     <?php

     //print_r($data['employeedata']);
      foreach($data['employeedata'] as $get):

		    $id=$get->basic_id;
     ?>
     <tr>
     	<td width='15%'><?php echo $get->fullname ?><br/>
        <span style='font-size:10px; color:red'><?php echo $get->position ?></span>
      </td>
  		<td  style=''><input type='text' recurrentid = '<?php echo $get->recurrentid ?>'  value="<?php echo $get->taxrelf ?>" field='taxrelf' class='form-control pay'/></td>
  		<td  style=''><input type='text' recurrentid = '<?php echo $get->recurrentid ?>'  value="<?php echo $get->salaryadvance ?>" field='salaryadvance' class='form-control pay'/></td>
  		<td  style=''><input type='text' recurrentid = '<?php echo $get->recurrentid ?>'  value="<?php echo $get->staffwelfare ?>" field='staffwelfare' class='form-control pay'/></td>
      <td style='display:none'><input style='display:none' type='text' recurrentid = '<?php echo $get->recurrentid ?>'  value="<?php echo $get->paye == '' ?  0.00 :  $get->paye; ?>" field='paye' class='form-control pay'/></td>


     </tr>

     <?php
	   endforeach;
     ?>
  </table>
  <?php
      }

  ?>




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
