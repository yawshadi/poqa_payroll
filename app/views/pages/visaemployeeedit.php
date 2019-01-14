<?php require APPROOT .'/views/inc/header.php';  ?>
<?php

require APPROOT .'/views/inc/employee.php' ;
//echo $data['passport']->did;
if(isset($data['passport']->did)){ $did = $data['passport']->did ;} else{ echo $did = ''; }
if(isset($data['supportingdoc']->did)){ $supdid = $data['supportingdoc'] ; } else{ echo $supdid = ''; }


 ?>

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

      <div id='value'>

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
       <select class='form-control bom' id='company'>
          <option><?php echo  $data['basicdata']->company   ?></option>
        <option value=''>Select Company</option>
        <?php
         foreach($data['companies'] as $get):
         ?>
         <option><?php echo $get->companyname   ?></option>
         <?php
          endforeach
         ?>
        </select>
      </td>

      <td></td>
      </tr>
         <tr>
         <td><input type="text" class="form-control bom"  id="firstname" placeholder="Firstname" value ="<?php echo $data['basicdata']->firstname   ?>"/></td>
         <td><input type="text" class="form-control bom" id="lastname" placeholder="Family  name" value="<?php echo $data['basicdata']->surname   ?>"/></td>
         </tr>
         <tr>
         <td>
           <select class='form-control bom' id='gender'>
              <option><?php echo  $data['basicdata']->gender   ?></option>
              <option value=''>Select Gender </option>
                <option>Male</option>
                <option>Female</option>
            </select>

         </td>
         <td><input type="text" class="form-control bom" placeholder="Date of birth"  id="dob" value="<?php echo $data['basicdata']->dateofbirth   ?>"/></td>
         </tr>

          <tr>
         <td><input type="text" class="form-control bom" placeholder="Year of birth" id="yearofbirth" value="<?php echo $data['basicdata']->yearofbirth   ?>"/></td>
         <td><input type="text" class="form-control bom" placeholder="Telephone"  id="telephone" value="<?php echo $data['basicdata']->telephone   ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" placeholder="Profession" id="profession" value="<?php echo $data['basicdata']->profession   ?>"/></td>
         <td><input type="text" class="form-control bom" placeholder="Intended Profession" id="intendedprofession" value="<?php echo $data['basicdata']->intendedprofession  ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" placeholder="Passport Number" id="passportnumber" value="<?php echo $data['basicdata']->passportnumber   ?>"/></td>
         <td><input type="text" class="form-control bom alldate" placeholder="Date of issue of passport"  id="dateofpassportissue" value="<?php echo $data['basicdata']->dateofpassportissue  ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom alldate" placeholder="Date of expiry of passport" id="dateofpassportexpiry" value="<?php echo $data['basicdata']->dateofpassportexpiry  ?>"/></td>
         <td><input type="text" class="form-control bom"  id="height" placeholder='Height (cm)' value="<?php echo $data['basicdata']->height   ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" placeholder="Father's Name" id="fathersname" value="<?php echo $data['basicdata']->fathersname   ?>"/></td>
         <td><input type="text" class="form-control bom" placeholder="Mother's Name"   id="mothersname" value="<?php echo $data['basicdata']->mothersname   ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" placeholder="Spouse Name" id="spousename" value="<?php echo $data['basicdata']->spousename   ?>"/></td>
         <td><input type="text" class="form-control bom alldate" placeholder="Date of birth of spouse"  id="spousedob" value="<?php echo $data['basicdata']->dateofbirthofspouse   ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="spousetelephone" placeholder='Telephone of Spouse' value="<?php echo $data['basicdata']->telephoneofspouse  ?>"/></td>
         <td><input type="text" class="form-control bom"  id="spouseplaceofbirth" placeholder='Place of birth of spouse' value="<?php echo $data['basicdata']->placeofbirthofspouse  ?>"/></td>
         </tr>

         <tr>
         <td><input type="text" class="form-control bom" id="familyaddress" placeholder='Family Address' value="<?php echo $data['basicdata']->familyaddress  ?>"/></td>
         <td><input type="text" class="form-control bom"  id="numberofchildren" placeholder="Number of children" value="<?php echo $data['basicdata']->numberofchildren  ?>"/></td>
         </tr>

         <tr>
         <td><input type="hidden" class="form-control bom"  id="basicid" value='<?Php echo $data['basicdata']->basic_id ?>' /></td>
         <td align='right'><button type='button' id='updatevisaemployeebtn' style='font-size:12px' class='btn btn-primary'>
         <i class='fa fa-plus-circle'></i> Update Record</button></td>
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
        <?php  //echo '<pre/>'; print_r($data) ?>

        <form method='post'>
        <table class='table table-bordered'>


          <tr>
            <td>Number of Children</td>
            <td><?php echo $data['basicdata']->numberofchildren   ?></td>
          </tr>

          <?php  for($i=1; $i<= $data['basicdata']->numberofchildren; $i++){

           ?>
          <tr>
            <td><input type="text" class="form-control bom"  name="nameofchild[]" placeholder='Name of Child' /></td>
            <td><input type="text" class="form-control bom alldate"  name="dobofchild[]" placeholder='Date of Birth' /></td>
          </tr>
         <?php } ?>

        <tr>
          <td>Passport Picture</td>
          <td><input type="file" name="epassportdoc" id="epassportdoc" style="font-size:10px" /></td>
        </tr>

        <tr>
          <td>Supporting Document</td>
          <td><input type="file" name="esupportingdoc" id="esupportingdoc" style="font-size:10px" /></td>
        </tr>

        <tr>
          <td><input type="hidden" class="form-control bom"  name="basicid" value='<?Php echo $data['basicdata']->basic_id ?>' /></td>
          <td><button name='updatevisa' type='submit' class='btn btn-warning' style="background:#000; font-size:12px"> Update </button></td>
        </tr>
        </table>
        </form>


      </div>
     </div>
     </div>

      </div>


      </div>




      <!-- End of first upper row -->


      <div class="row" style="margin-bottom:20px">




      </div>
    </div>   <!-- End of value -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>

  <script type="text/javascript">

  var did = '<?php echo $did  ?>';
   if(did == ''){
    var uroot = '<?php  echo URLROOT.'/pages/savepassport/'.$data['basicdata']->basic_id  ?>';
    var suroot = '<?php echo URLROOT.'/pages/savesupporting/'.$data['basicdata']->basic_id  ?>';
  }else{
    var uroot = '<?php  echo URLROOT.'/pages/updatesavepassport/'.$did ?>';
    var suroot = '<?php echo URLROOT.'/pages/updatesavesupporting/'.$supdid ?>'; 
  }


  $('#epassportdoc').uploadifive({
      'buttonText'  : 'Browse for passport picture',
      'buttonClass' : 'uploadifive-button',
      'auto'        : true,
      'method'      : 'post',
      'multi'       : true,
      'width'       : 250,
      'uploadScript': uroot,
      'onUploadComplete' : function(file, data) {
          //window.location.href = '<?php // echo URLROOT.'/task/edittask/'.$data['task']->id   ?>'
        }
   });


   $('#esupportingdoc').uploadifive({
       'buttonText'  : 'Browse for supporting documnet',
       'buttonClass' : 'uploadifive-button',
       'auto'        : true,
       'method'      : 'post',
       'multi'       : true,
       'width'       : 250,
       'uploadScript': suroot,
       'onUploadComplete' : function(file, data) {
          // window.location.href = '<?php // echo URLROOT.'/task/edittask/'.$data['task']->id   ?>'
         }
    });


  </script>
