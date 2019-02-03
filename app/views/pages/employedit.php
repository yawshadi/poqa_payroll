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
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> EDIT EMPLOYEE: <?php echo $data['employees']->fullname   ?></h1>
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
         <td><input type="text" class="form-control bom"  name="firstname" value="<?php echo $data['employees']->firstname   ?>" placeholder='First Name'/></td>
         <td><input type="text" class="form-control bom" name="lastname" value="<?php echo $data['employees']->surname   ?>"  placeholder='Last Name'/></td>
         </tr>
         <tr>
         <td><input type="text" class="form-control bom" name="othernames" value="<?php echo $data['employees']->othernames   ?>"  placeholder='Othernames'/></td>
         <td><input type="text" class="form-control bom"  name="dob" value="<?php echo $data['employees']->dateofbirth  ?>"  placeholder='Date of Birth'/></td>
         </tr>

         <td><input type="text" class="form-control bom" name="staffid" value="<?php echo $data['employees']->staffid   ?>"  placeholder='STAFF ID'/></td>
         <td><input type="text" class="form-control bom" name="email" value="<?php echo $data['employees']->email   ?>"  placeholder='Email'/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" name="location" value="<?php echo $data['employees']->location  ?>"  placeholder='First Location'/></td>
         <td><input type="text" class="form-control bom" name="telephone" value="<?php echo $data['employees']->telephone  ?>"  placeholder='Telephone'/></td>
         </tr>
         <tr>
         <td><select class='form-control bom' name='nationality' id='nationality'>
          <option ><?php echo $data['employees']->nationality  ?></option>
           <option>Ghanaian</option>
           <option>Expatriate</option>
          </select></td>
         <td><select class='form-control bom' name='gender' id='gender'>
          <option ><?php echo $data['employees']->gender  ?></option>
           <option>Male</option>
           <option>Female</option>
          </select></td>
         </tr>

         
         <tr>
         <td <?= ($data['employees']->maritalstatus!='Married')?'colspan=2':''?>>
         <select class='form-control bom' name="maritalstatus" id='maritalstatus'>
         <option ><?php echo $data['employees']->maritalstatus  ?></option>
           <option>Single</option>
           <option>Married</option>
           <option>Divorced</option>
           <option>Separated</option>
          </select>
         </td>
         <?php if($data['employees']->maritalstatus=='Married'):?>
         <td>
         <button style="padding:3px;border-radius:0px" class="btn btn-primanry " id='viewmarital'>view </button>
         </td>
        <?php endif;?>
         </tr>
<input type="hidden" name="randomnumber" id="randomnumber" value="<?= $data['employees']->randomnumber?>">
         <tr>
         <td>
         <select class='form-control bom' id='compval' name='company'>
          <option><?php echo $data['employees']->company   ?></option>
          <?php
           foreach($data['companies'] as $get):
           ?>
           <option><?php echo $get->companyname   ?></option>
           <?php 
            endforeach
           ?>
          </select>
        </td>

        <td><select class='form-control bom' id='department' name='department'>
          <option><?php echo $data['employees']->department   ?></option>
         
          </select>
        </td>
        </tr>
        
        <tr>
         <td> <select class='form-control bom' id='position' name='position'>
          <option><?php echo $data['employees']->position   ?></option>
          
          </select></td>
         <td>
         <select class='form-control bom' name='idtype'>
        <option><?php echo $data['employees']->idtype   ?></option>
        <option>Voter ID</option>
        <option>National ID</option>
        <option>NHIS ID</option>
        <option>Driver's Licence</option>
        <option>SSNIT</option>
        </select> 
         </td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" name="idnumber"  placeholder='ID Number' value="<?php echo $data['employees']->idnumber   ?>"/></td>
         <td>
         <input type="text" class="form-control bom"  name="tinnumber"  placeholder='Employee TIN' value="<?php echo $data['employees']->tinnumber   ?>"/></td>
         </tr>

         <tr>
         <td>
         <select class='form-control bom' id='bankname' name='bankname'>
          <option><?php echo $data['employees']->bankname   ?></option>
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
         <select class='form-control bom' id='branch' name='branch'>
          <option><?php echo $data['employees']->branch  ?></option>
          
          </select>
         
         </td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" name="accountnumber"  placeholder='Account Number' value="<?php echo $data['employees']->accountnumber   ?>"/></td>
         <td><input type="text" class="form-control bom"  name="ssnitnumber"  placeholder='SSNIT Number' value="<?php echo $data['employees']->ssnitnumber   ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom " name="probationstart"  placeholder='Probation Start' value="<?php echo $data['employees']->probationstart   ?>"/></td>
         <td><input type="text" class="form-control bom "  name="probationend"  placeholder='Probation End' value="<?php echo $data['employees']->probationend   ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom"  name="gname"  placeholder='Guarantor' value="<?php echo $data['employees']->gaurantor   ?>"/></td>
         <td> <input type="text" class="form-control bom"  name="gtelephone"  placeholder='Guarantor Telephone' value="<?php echo $data['employees']->gaurantor_telephone  ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom"  name="tierno"  placeholder='Tire 2 Number' value="<?php echo $data['employees']->tiernumber  ?>"/></td>
         <td align='right'><input type="text" class="form-control bom"  placeholder='Hire Date'  name="hiredate" value="<?php echo $data['employees']->hiredate   ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom"  id="contractstart" name='contractstart' value="<?php echo $data['employees']->contractstart  ?>" placeholder="Contract Start "/></td>
         <td align='right'><input type="text" class="form-control bom"  name='contractend' id="contractend" value="<?php echo $data['employees']->contractend  ?>" placeholder="Contract End"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom"  id="entrydate" name='entrydate' value="<?php echo $data['employees']->entrydate  ?>" placeholder="Entry Date"/></td>
         <td align='right'><input type="text" class="form-control bom"  name='exitdate' value="<?php echo $data['employees']->exitdate  ?>" id="exitdate" placeholder="Exit Date"/></td>
         </tr>
         <tr>
         <td><input type="text" class="form-control bom"  name='contractallocation' id="contractallocation" value="<?php echo $data['employees']->contractallocation  ?>"  placeholder="Contract Allocation"/></td>
         <td><input type="text" class="form-control bom" name='academictitle'  id="academictitle"  value="<?php echo $data['employees']->academictitle  ?>" placeholder="Academic Title"/></td>
         </tr>
         <tr>
         <td><select class='form-control bom' name='category' id='category'>
          <option><?php echo $data['employees']->category  ?></option>
           <option>Manager</option>
           <option value="Officer 1">Officer 1 (27.5 %)</option>
           <option  value="Officer 2">Officer 2 (2.5 %)</option>
          </select></td>
          <td><input type="text" class="form-control bom" name='basicsalary' value="<?php echo $data['employees']->basicsalary  ?>" id="basicsalary" placeholder="Basic Salary"/></td>
         </tr>

         <tr>
         <td><input type="hidden"  id="employeeid"   value="<?php echo $data['employees']->basic_id  ?>"/></td>
         <td align='right'><button type='submit' name='updateemployeebtn' style='font-size:12px' class='btn btn-primary'>
         <i class='fa fa-plus-circle'></i> UPDATE EMPLOYEE</button></td>
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
       <td>Telephone</td>
       <td>Company</td>
       <td>Department</td>
       <td>Edit </td>
       <td>Delete</td>
      </tr>
      </thead>

       <?php
        foreach($data['allemployees'] as $get):
       ?>
       <tr>
       <td><?php  echo $get->fullname  ?></td>
       <td><?php  echo $get->telephone  ?></td>
       <td><?php  echo $get->company ?></td>
       <td><?php  echo $get->department ?></td>
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




