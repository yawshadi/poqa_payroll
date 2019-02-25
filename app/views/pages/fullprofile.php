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
.fontdisplay{
  font-size: 13px;
  font-weight: 700;
}
</style>

<div id="empmodal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:800px" role="document">

              <div class="modal-content">
                  <div class="modal-body" id="ajaxcontainer" >

                  </div>

              </div>
          </div>
</div>



  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="
     background:linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)),
    url('<?php  echo URLROOT.'/img/new1.jpg' ?>') !important;
    background-size:cover !important;
    background-attachment:fixed !important;
    background-position: center !important;
    ">



  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> FULL EMPLOYEE PROFILE</h1>
        </div>
   </div>

      <hr style='background:#fafafa'/>

      <div id='placeholder'>

      <div id='ajaxcontainer'> </div>
    </div>



<div class="row" style="margin-bottom:20px">

     <div class="col-lg-5 col-md-5 col-sm-12">

     <div>
     <form method='post'>
     <table class='table table-bordered' style='color:#fff'>
         <tr>
         <td width=40%>Name: </td>
         <td class='fontdisplay'><?php  echo $data['empdata']->fullname.' '.$data['empdata']->othernames  ?></td>
         </tr>
         <tr>
         <td>Date of Birth</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->dateofbirth  ?></td>
         </tr>
          <tr>
         <td>Staffid</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->staffid  ?></td>
         </tr>

         <tr>
         <td>Email Address</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->email  ?></td>
         </tr>

         <tr>
         <td>Telephone</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->telephone  ?></td>
         </tr>

         <tr>
         <td>Location</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->location  ?></td>
         </tr>
         <tr>
         <td>Nationality</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->nationality  ?></td>
         </tr>
         <tr>
         <td>Gender</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->gender  ?></td>
         </tr>
         <tr>
         <td>Company</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->company  ?></td>
         </tr>

         <tr>
         <td>Department</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->department  ?></td>
         </tr>

         <tr>
         <td>Position</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->position  ?></td>
         </tr>
         <tr>
         <td>Academic Title</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->academictitle  ?></td>
         </tr>
         <tr>
         <td>ID Type</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->idtype  ?></td>
         </tr>

         <tr>
         <td>ID Number</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->idnumber  ?></td>
         </tr>

         <tr>
         <td>Tin Number</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->tinnumber  ?></td>
         </tr>

         <tr>
         <td>Bank</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->bankname  ?></td>
         </tr>

         <tr>
         <td>Bank Branch</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->branch  ?></td>
         </tr>

         <tr>
         <td>Account Number</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->accountnumber  ?></td>
         </tr>

         <tr>
         <td>SSNIT Number</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->ssnitnumber  ?></td>
         </tr>

         <tr>
         <td>Tier 2 Number </td>
         <td class='fontdisplay'><?php  echo $data['empdata']->tiernumber  ?></td>
         </tr>

         <tr>
         <td>Hire Date</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->hiredate  ?></td>
         </tr>

         <tr>
         <td>Probation Start</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->probationstart  ?></td>
         </tr>

         <tr>
         <td>Probation End</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->probationend  ?></td>
         </tr>
         <tr>
         <td>Contract Start</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->contractstart  ?></td>
         </tr>
         <tr>
         <td>Contract End</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->contractend  ?></td>
         </tr>
         <tr>
         <td>Contract Allocation</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->contractallocation  ?></td>
         </tr>
         <tr>
         <td>Entry Date</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->entrydate  ?></td>
         </tr>
         <tr>
         <td>Exit Date</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->exitdate  ?></td>
         </tr>
         <tr>
         <td>Guarantor Name</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->gaurantor  ?></td>
         </tr>

         <tr>
         <td>Guarantor Telephone</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->gaurantor_telephone  ?></td>
         </tr>
         <tr>
         <td>Category</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->category  ?></td>
         </tr>
         <tr>
         <td>Basic Salary</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->basicsalary  ?></td>
         </tr>
         <tr>
         <td>Marital Status</td>
         <td class='fontdisplay'><?php  echo $data['empdata']->maritalstatus  ?></td>
         </tr>
          <?php 
          if($data['empdata']->maritalstatus=='Married'):
            $maritaldata = Marital::maritaldata($data['empdata']->randomnumber);

          ?>
         <tr>
         <td>Spouse Name</td>
         <td class='fontdisplay'><?php  echo $maritaldata->spouse  ?></td>
         </tr>
         <tr>
         <td>Spouse Contact</td>
         <td class='fontdisplay'><?php  echo $maritaldata->spousecontact  ?></td>
         </tr>
         <tr>
         <td>1st Dependant</td>
         <td class='fontdisplay'><?php  echo $maritaldata->first  ?></td>
         </tr>
         <tr>
         <td>2nd Dependant</td>
         <td class='fontdisplay'><?php  echo $maritaldata->second  ?></td>
         </tr>
         <tr>
         <td>3rd Dependant</td>
         <td class='fontdisplay'><?php  echo $maritaldata->third  ?></td>
         </tr>
         <tr>
         <td>4th Dependant</td>
         <td class='fontdisplay'><?php  echo $maritaldata->fourth  ?></td>
         </tr>
          <?php endif;?>
         </table>

     </form>
     </div>
      </div>
<input type="hidden" name="" id="randomnumber" value="<?=$data['empdata']->randomnumber ?>">
      <div class="col-lg-7 col-md-7 col-sm-7">

      <div>
      <div class="container">

      <div align='center'>
      <table  style='font-size:12px'>
        <tr>
          <td colspan="3" align='center'>
            <?php if(!isset($data['passport']->newname)):
            $did = null;  
            ?>
            <img style="border-radius: 50%"
            src='<?php  echo URLROOT.'/img/noimage.jpg' ?>' height="150"
            width="150" class='img-circle'   /></td>
          <?php endif;  ?>

          <?php if(isset($data['passport']->newname)): 
            $did = $data['passport']->did;
            ?>
          <img style="border-radius: 50%"
          src='<?php  echo URLROOT.'/uploads/'.$data['passport']->newname ?>' height="150"
          width="150" class='img-circle'/></td>
        <?php endif;  ?>
        </tr>
        <tr>
          <td>
            <a href='<?php echo URLROOT.'/pages/editemployee/'.$data['empdata']->basic_id  ?>' class='btn btn-danger' style='font-size:12px'> Edit</a>
          </td>
          <td>
             <input  type=file id=filedoc />
           </td>
            <td>
                <a href='<?php echo URLROOT.'/payrollreport/payslip/'.$data['empdata']->basic_id  ?>' class='btn btn-danger'  style='font-size:12px; background:#BFFF00; color:#000'> Print Slip</a>
            </td>
            <td>
            <a  class='btn btn-danger' id="employeefolder" style='font-size:12px;color:white'><i class="fa fa-folder-o"></i>Employee Folder</a>

          </td>
        </tr>
      </table>
      <br/>
     <?php  if(count($data['grievancedata']) > 0 ):  ?>

      <table  style='font-size:12px; color:#fff' class='table table-bordered'>
        <tr>
          <td colspan="4" align='center' style='font-weight:700'>GRIEVANCES REQUEST</td>
        </tr>
        <?php
         foreach($data['grievancedata'] as $get):
        ?>
        <tr>
          <td><?php echo $get->subject  ?></td>
          <td><?php echo $get->reportdate  ?></td>
          <td><?php  echo $get->status == '' ?  'Pending' : $get->status  ?></td>
          <td><a href='<?php  echo URLROOT.'/uploads/'.$get->filename  ?>'>Download</a></td>
        </tr>
      <?php endforeach; ?>

      </table>
    <?php endif;  ?>

    <?php  if(count($data['transferdata']) > 0 ):  ?>

      <table  style='font-size:12px; color:#fff' class='table table-bordered'>
        <tr>
          <td colspan="5" align='center' style='font-weight:700'>TRANSFERS REQUEST</td>
        </tr>
        <?php
         foreach($data['transferdata'] as $get):
        ?>
        <tr>
          <td><?php echo $get->reportdate  ?></td>
          <td><?php echo $get->department  ?></td>
          <td><?php echo $get->position  ?></td>
          <td><?php  echo $get->status == '' ?  'Pending' : $get->status  ?></td>
          <td><a href='<?php  echo URLROOT.'/uploads/'.$get->filename  ?>' >Download</a></td>
        </tr>
          <?php endforeach; ?>
      </table>
      <?php endif;  ?>

      <?php  if(count($data['promotiondata']) > 0 ):  ?>
      <table  style='font-size:12px; color:#fff' class='table table-bordered'>
        <tr>
          <td colspan="5" align='center' style='font-weight:700'>PROMOTION REQUEST</td>
        </tr>
        <?php
         foreach($data['promotiondata'] as $get):
        ?>
        <tr>
          <td><?php echo $get->reportdate  ?></td>
          <td><?php echo $get->department  ?></td>
          <td><?php echo $get->position  ?></td>
          <td><?php  echo $get->status == '' ?  'Pending' : $get->status  ?></td>
          <td><a href='<?php  echo URLROOT.'/uploads/'.$get->filename  ?>'>Download</a></td>
        </tr>
          <?php endforeach; ?>
      </table>
      <?php endif;  ?>

       <?php  if(count($data['leavedata']) > 0 ): ?>
      <table  style='font-size:12px; color:#fff' class='table table-bordered'>
        <tr>
          <td colspan="5" align='center' style='font-weight:700'>LEAVES REQUEST </td>
        </tr>
        <tr>
          <td>Leave entitled to </td>
          <td>Dates on Leave(From) </td>
          <td>Dates on Leave (To)</td>
          <td>Total No. of days applied</td>
          <td>Outstanding days</td>
        </tr>
        <?php
        $i=1;
         foreach($data['leavedata'] as $get):
        ?>
        <tr>
        <td <?= ($i==1)?"rowspan=".sizeof($data['leavedata']):"style=display:none"?>><?php echo $data['empdata']->accumulatedleave ?></td>
          <td><?php echo $get->startdate  ?></td>
          <td><?php echo $get->endate  ?></td>
          <td><?php  echo $get->actualdays  ?></td>
          <td <?= ($i==1)?"rowspan=".sizeof($data['leavedata']):"style=display:none"?>><?php echo Leavedays::availabledays($data['empdata']->basic_id,date('Y')) ?></td>
<!--<td <?= (sizeof($data['leavedata'])==$i)?'':'rowspan='.sizeof($data['leavedata'])?>><span style="display:<?= (sizeof($data['leavedata'])==$i)?'':'none'?>"><?php echo $data['empdata']->accumulatedleave ?></span></td>-->
        </tr>
        <?php
        $i++; 
        endforeach; 
        ?>
      </table>
      <?php endif;  ?>

      <?php  if(count($data['disciplinedata']) > 0 ):  ?>
      <table  style='font-size:12px; color:#fff' class='table table-bordered'>
        <tr>
          <td colspan="4" align='center' style='font-weight:700'>DISCIPLINARY</td>
        </tr>
        <?php
         foreach($data['disciplinedata'] as $get):
        ?>
        <tr>
          <td><?php echo $get->subject  ?></td>
          <td><?php echo $get->reportdate  ?></td>
          <td><?php  echo $get->status == '' ?  'Pending' : $get->status  ?></td>
          <td><a href='<?php  echo URLROOT.'/uploads/'.$get->filename  ?>'>Download</a></td>
        </tr>
      <?php endforeach; ?>

      </table>
      <?php endif;  ?>


      <?php  if(count($data['assetdata']) > 0 ):  ?>

      <table  style='font-size:12px; color:#fff' class='table table-bordered'>
        <tr>
          <td colspan="5" align='center' style='font-weight:700'>ASSETS LIST</td>
        </tr>
        <tr>
          <td>Asigned Date</td>
          <td>Asset Name</td>
          <td>Asset Quantity</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
        <?php
         foreach($data['assetdata'] as $get):
        ?>
        <tr>
          <td><?php echo $get->reportdate  ?></td>
          <td><?php echo $get->assetname  ?></td>
          <td><?php echo $get->assetquantity  ?></td>
          <td><?php  echo $get->status == '' ?  'Approved' : $get->status  ?></td>
          <td><a href='<?php  echo URLROOT.'/uploads/'.$get->filename  ?>' >Download</a></td>
        </tr>
          <?php endforeach; ?>
      </table>
      <?php endif;  ?>

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

    <div class="modal fade" id="foldermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" style='width:500px' role="document">
            <!--Content-->
            <div class="modal-content form-elegant folderform">

            </div>
            <!--/.Content-->
        </div>
    </div>
  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
  <script type="text/javascript">
  var uroot = "<?= URLROOT.'/pages/savepassport/'.$data['empdata']->basic_id.'/'.$did ?>";

  $('#filedoc').uploadifive({
      'buttonText'  : 'Browse for picture',
      'buttonClass' : 'uploadifive-button',
      'auto'        : true,
      'method'      : 'post',
      'multi'       : true,
      'width'       : 250,
      'uploadScript': uroot,
      'onUploadComplete' : function(file, data) {
          window.location.href = '<?php echo URLROOT.'/pages/fullprofile/'.$data['empdata']->basic_id ?>'
        }
   });


  </script>
