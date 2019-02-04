<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/employee.php' ; ?>

<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
  font-size:12px;
}
</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">

  <div id="empmodal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width:800px" role="document">

                <div class="modal-content">
                    <div class="modal-body" id="ajaxcontainer" >

                    </div>

                </div>
            </div>
</div>


  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> ADD NEW EMPLOYEE</h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>

      <div id='ajaxcontainer'> </div>
    </div>



<div class="row" style="margin-bottom:20px">

     <div class="col-lg-5 col-md-5 col-sm-12">

     <div class='card'>
     <form method='post'>
     <table class='table'>
         <tr>
         <td><input type="text" class="form-control bom" required id="firstname" placeholder="Firstname"/></td>
         <td><input type="text" class="form-control bom" id="lastname" placeholder="Lastname"/></td>
         </tr>
         <tr>
         <td><input type="text" class="form-control bom" id="othernames" placeholder="Other Names"/></td>
         <td><input type="text" class="form-control bom"  id="dob" placeholder="Date of Birth"/></td>
         </tr>

         <td><input type="text" class="form-control bom" id="staffid" placeholder="Staff ID"/></td>
         <td><input type="text" class="form-control bom"  id="email" placeholder="Email Address"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="location" placeholder="Location"/></td>
         <td><input type="text" class="form-control bom"  id="telephone" placeholder="Telephone"/></td>
         </tr>
         <tr>
         <td><select class='form-control bom' id='nationality'>
          <option value=''>Nationality</option>
           <option>Ghanaian</option>
           <option>Expatriate</option>
          </select></td>
         <td><select class='form-control bom' id='gender'>
          <option value=''>Gender</option>
           <option>Male</option>
           <option>Female</option>
          </select></td>
         </tr>



         <tr>
         <td colspan=2><select class='form-control bom' required name="maritalstatus" id='maritalstatus'>
          <option>Marital Status</option>
           <option>Single</option>
           <option>Married</option>
           <option>Divorced</option>
           <option>Separated</option>
          </select>
         </td>
         </tr>
<input type="hidden" name="randomnumber" id="randomnumber" value="<?= time()?>">


         <tr>
         <td>
         <select class='form-control bom' id='compval'>
          <option value=''>Company</option>
          <?php
           foreach($data['companies'] as $get):
           ?>
           <option><?php echo $get->companyname   ?></option>
           <?php
            endforeach
           ?>
          </select>
        </td>

        <td><select class='form-control bom' id='department'>
          <option value=''>Department</option>

          </select>
        </td>
        </tr>

        <tr>
         <td> <select class='form-control bom' id='position'>
          <option value=''>Select Position</option>

          </select></td>
         <td>
         <select class='form-control bom' id='idtype'>
        <option value=''>ID type</option>
        <option>Voter ID</option>
        <option>National ID</option>
        <option>NHIS ID</option>
        <option>Driver's Licence</option>
        <option>SSNIT</option>
        </select>
         </td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="idnumber" placeholder="ID Number"/></td>
         <td>
         <input type="text" class="form-control bom"  id="tinnumber" placeholder="Employee TIN"/></td>
         </tr>

         <tr>
         <td>
         <select class='form-control bom' id='bankname'>
          <option value=''>Select Bank</option>
          <?php
           foreach($data['banks'] as $get):
           ?>
           <option><?php echo $get->bankname   ?></option>
           <?php
            endforeach
           ?>
          </select>
         </td>
         <td>
         <select class='form-control bom' id='branch'>
          <option value=''>Select Branch</option>

          </select>

         </td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="accountno" placeholder="Account Number"/></td>
         <td><input type="text" class="form-control bom"  id="ssnit" placeholder="SSNIT Number"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom " id="prostart" placeholder="Probation Start"/></td>
         <td><input type="text" class="form-control bom "  id="proend" placeholder="Probation End"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom"  id="gname" placeholder="Gaurantor Name"/></td>
         <td> <input type="text" class="form-control bom"  id="gtelephone" placeholder="Gaurantor Telephone"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom"  id="tierno"  placeholder="Tier 2 No: "/></td>
         <td align='right'><input type="text" class="form-control bom"  id="hiredate" placeholder="Hire Date"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom"  id="contractstart"  placeholder="Contract Start "/></td>
         <td align='right'><input type="text" class="form-control bom"  id="contractend" placeholder="Contract End"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom"  id="entrydate"  placeholder="Entry Date"/></td>
         <td align='right'><input type="text" class="form-control bom"  id="exitdate" placeholder="Exit Date"/></td>
         </tr>
         <tr>
         <td><input type="text" class="form-control bom"  id="contractallocation"  placeholder="Contract Allocation"/></td>
         <td><input type="text" class="form-control bom"  id="academictitle" placeholder="Academic Title"/></td>
         </tr>
         <tr>
         <td><select class='form-control bom' id='category'>
          <option value=''>Category</option>
           <option>Manager</option>
           <option value="Officer 1">Officer 1 (27.5 %)</option>
           <option  value="Officer 2">Officer 2 (2.5 %)</option>
          </select></td>
          <td><input type="text" class="form-control bom" name='basicsalary' id="basicsalary" placeholder="Basic Salary"/></td>

         </tr>

         <tr>
         <td></td>
         <td align='right'><button type='button' id='addemployeebtn' style='font-size:12px' class='btn btn-primary'>
         <i class='fa fa-plus-circle'></i> ADD EMPLOYEE</button></td>
         </tr>
         </table>

     </form>
     </div>
      </div>

      <div class="col-lg-7 col-md-7 col-sm-7">

      <div class='card'>
      <div class="container">
      <br/>
      <div align='center'>

      <table  class='table table-bordered table-condensed apptables' style='font-size:12px'>
       <thead>
       <tr>
       <td>Employee Name</td>
       <td>Department</td>
       <td>Position</td>
       <td>Slip</td>
       <td>Edit </td>
       <td>Delete</td>
      </tr>
      </thead>

       <?php
        foreach($data['employees'] as $get):
       ?>
       <tr>
       <td><a href='<?php echo URLROOT.'/pages/fullprofile/'.$get->basic_id;   ?>'><?php  echo $get->fullname  ?></a></td>
       <td><?php  echo $get->department ?></td>
       <td><?php  echo $get->position ?></td>
       <td><a href='<?php echo URLROOT  ?>/payslip/slip/<?php echo $get->basic_id  ?>' >Slip</a></td>
       <td><a href='<?php echo URLROOT  ?>/pages/editemployee/<?php echo $get->basic_id  ?>' ><i class='fa fa-pencil'></i></a></td>
       <td><a href='#' class='deleteemployee' employeeid='<?php echo $get->basic_id  ?>'><i class='fa fa-trash'></i></a></td>

      </tr>
       <?php
       endforeach;
       ?>



      </table>
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

    <div class="modal fade" id="maritalmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" style='width:500px' role="document">
            <!--Content-->
            <div class="modal-content form-elegant mform">

            </div>
            <!--/.Content-->
        </div>
    </div>

  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
