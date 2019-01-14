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

<div id="viewmodal" class="modal fade" role="dialog" style="z-index:9999999999999999999999999">
          <div class="modal-dialog" style="width:600px" role="document">

              <div class="modal-content">
                  <div class="modal-body" id="ajaxcontainer" >

                  </div>
              </div>
          </div>
</div>


  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> ADD NEW  VISA EMPLOYEE</h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>

      <div id='ajaxcontainer'> </div>
      <?php// require APPROOT .'/views/inc/dash.php' ; ?>


      </div>



<div class="row" style="margin-bottom:20px">

     <div class="col-lg-5 col-md-5 col-sm-12">

     <div class='card'>

      <div id='visarea'>
      <table class='table'>

       <tr>
       <td>

       <?php if($data['role'] != 'Agent'):    ?>
       <select class='form-control bom' id='company'>
        <option value=''>Select Company</option>
        <?php
         foreach($data['companies'] as $get):
         ?>
         <option><?php echo $get->companyname   ?></option>
         <?php
          endforeach
         ?>
        </select>
      <?php  endif;  ?>
      <?php if($data['role'] == 'Agent'):    ?>
      <select class='form-control bom' id='company'>
       <option><?php echo $data['company'];  ?></option>

       </select>
     <?php  endif;  ?>
      </td>

      <td></td>
      </tr>
         <tr>
         <td><input type="text" class="form-control bom"  id="firstname" placeholder="Firstname"/></td>
         <td><input type="text" class="form-control bom" id="lastname" placeholder="Family Name"/></td>
         </tr>
         <tr>
         <td>
           <select class='form-control bom' id='gender'>
              <option value=''>Select Gender </option>
                <option>Male</option>
                <option>Female</option>
            </select>
         </td>
         <td><input type="text" class="form-control bom"  id="dob" placeholder="Date of Birth"/></td>
         </tr>

          <tr>
         <td><input type="text" class="form-control bom" id="yearofbirth" placeholder="Year of Birth "/></td>
         <td><input type="text" class="form-control bom"  id="telephone" placeholder="Telephone"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="profession" placeholder="Original Profession "/></td>
         <td><input type="text" class="form-control bom"  id="intendedprofession" placeholder="Intended Profession"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="passportnumber" placeholder="Passport Number "/></td>
         <td><input type="text" class="form-control bom alldate"  id="dateofpassportissue" placeholder="Date of Issue"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom alldate" id="dateofpassportexpiry" placeholder="Date of expiry"/></td>
         <td><input type="text" class="form-control bom"  id="height" placeholder="Height (cm)"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="fathersname" placeholder="Father's Name"/></td>
         <td><input type="text" class="form-control bom"  id="mothersname" placeholder="Mother's Name"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="spousename" placeholder="Spouse Name"/></td>
         <td><input type="text" class="form-control bom alldate"  id="spousedob" placeholder="Spouse Date of Birth"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="spousetelephone" placeholder="Spouse Telephone"/></td>
         <td><input type="text" class="form-control bom"  id="spouseplaceofbirth" placeholder="Spouse Place of Birth"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="familyaddress" placeholder="Family Address"/></td>
         <td><input type="text" class="form-control bom"  id="numberofchildren" placeholder="Number of Children"/></td>
         </tr>


         <tr>
         <td></td>
         <td align='right'><button type='button' id='addvisaemployeebtn' style='font-size:12px' class='btn btn-primary'>
         <i class='fa fa-plus-circle'></i> Save & Continue</button></td>
         </tr>
         </table>
       </div>

        <div id='visacont'></div>


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
       <td>Passport Number</td>
       <td>Date of Birth</td>
       <td>View Profile</td>
       <td>Edit </td>
       <td>Delete</td>
       </tr>
      </thead>

       <?php
        foreach($data['employees'] as $get):
       ?>
       <tr>
       <td><?php  echo $get->fullname  ?></td>
       <td><?php  echo $get->passportnumber ?></td>
       <td><?php  echo $get->dateofbirth ?></td>
       <td><a href='<?php echo URLROOT  ?>/pages/employeeprofile/<?php echo $get->basic_id  ?>' >View Profile</a></td>
       <td><a href='<?php echo URLROOT  ?>/pages/visaemployeeedit/<?php echo $get->basic_id  ?>' ><i class='fa fa-pencil'></i></a></td>
       <td><a href='#' class='deletevisaemployee' employeeid='<?php echo $get->basic_id  ?>'><i class='fa fa-trash'></i></a></td>

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


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
