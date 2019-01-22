<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/employee.php' ; ?>
<?php
$n = new User($_SESSION['uid']);
$role = $n->recordObject->role;
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

.textlight{
  font-size:13px;
  font-weight: 700;
  color:#883002;
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
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> <?php echo $data['basicdata']->fullname  ?> </h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>

      <div id='ajaxcontainer'> </div>
    
      </div>



<div class="row" style="margin-bottom:20px">

     <div class="col-lg-3 col-md-3 col-sm-3">

     <div class='card'>
       <br/>
       <table align=center class=''>
       <tr>
         <td align='center'><a href="<?php echo URLROOT.'/uploads/'.$data['passport']->newname ?>" target='_blank'>
           <img style="border-radius: 50%"  src='<?php echo URLROOT.'/uploads/'.$data['passport']->newname  ?>' height=200 width=180  /></a> </td>
       </tr>
       <tr>
         <td align='center'><span style='font-size:15px; font-weight:700; color:#DE561E'>Passport Picture </h4></td>
       </tr>

       <tr>
         <td>&nbsp</td>
       </tr>
       <tr>
         <td align='center'><span style='font-size:15px; font-weight:700; color:#DE561E'>Scanned Document </h4></td>
       </tr>

       <tr>
         <td><a href="<?php echo URLROOT.'/uploads/'.$data['supportingdoc']->newname ?>" target='_blank'>
         <?php  echo  'Dowmload  Doc: '. $data['supportingdoc']->newname   ?> </a></td>
       </tr>

       </table>

       <?php
        // echo '<pre/>';
        // print_r($data);
       ?>

      </div>

      </div>

      <div class="col-lg-8 col-md-8 col-sm-8">

      <div class='card'>
      <div class="container">
      <br/>
      <div align='center'>

        <table class='table table-bordered'>

          <tr>
            <td colspan='1'>
              <?php
               if($data['basicdata']->visastatus == ''){
                   echo '<span style="color:red">'.'<h3>PENDING</h3>'.'</span>';
               }else{
                  echo '<span style="color:green">'.'<h3>RECRUITED</h3>'.'</span>';
               }

              ?>

             </td>
          <td colspan='1' align=right>
            <a href='<?php echo URLROOT.'/pages/pdfprofile/'.$data['basicdata']->basic_id  ?>' target='_blank' class='btn btn-danger' style="font-size:12px; background:#000"><i class='fa fa-print'></i> Print</a>

            <?php
              if($role == 'Expatriate'):
             ?>
            <button id='recruitbtn' basicid='<?php echo $data['basicdata']->basic_id   ?>' class='btn btn-danger'
              style="font-size:12px; background:green">Recruit</button>
            <?php
             endif;
             ?>
          </td>

          </tr>

            <tr>
            <td width='25%'>Firstname</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->firstname   ?></span> </td>
          </tr>
            <tr>
            <td>Family Name</td>
            <td ><span class='textlight'><?php  echo $data['basicdata']->surname   ?></span> </td>
            </tr>

             <tr>
            <td>Gender</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->gender   ?> </span></td>
            </tr>

            <tr>
            <td>Date of birth</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->dateofbirth   ?></span> </td>
            </tr>

            <tr>
            <td>Telephone</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->telephone   ?></span> </td>
            </tr>

            <tr>
            <td>Profession</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->profession   ?></span> </td>
            </tr>

            <tr>
            <td>Intended Profession</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->intendedprofession   ?> </span></td>
            </tr>

            <tr>
            <td>Passport Number</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->passportnumber   ?> </span></td>
            </tr>

            <tr>
            <td>Date of issue</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->dateofpassportissue   ?></span></td>
            </tr>

            <tr>
            <td>Date of Expiry</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->dateofpassportexpiry   ?></span></td>
            </tr>

            <tr>
            <td>Height</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->height. ' cm'   ?></span></td>
            </tr>

            <tr>
            <td>Father's name</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->fathersname  ?></span></td>
            </tr>

            <tr>
            <td>Mother's name</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->mothersname  ?></span></td>
            </tr>

            <tr>
            <td>Spouse name</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->spousename  ?></span></td>
            </tr>

            <tr>
            <td>Spouse date of birth</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->dateofbirthofspouse  ?></span></td>
            </tr>

            <tr>
            <td>Spouse place of birth</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->placeofbirthofspouse  ?></span></td>
            </tr>

            <tr>
            <td>Family address</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->familyaddress  ?></span></td>
            </tr>

            <tr>
            <td>Number of Children</td>
            <td><span class='textlight'><?php  echo $data['basicdata']->numberofchildren ?></span></td>
            </tr>



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
