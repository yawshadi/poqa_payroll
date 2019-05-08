<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/operationsmenu.php' ; ?>

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




  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-10">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> LEAVE REPORTING</h1>
        </div>

        <div class="col-2">
         <div style='margin-top:10px'><a class='btn btn-danger' style='font-size:11px' href='<?php echo URLROOT.'/downloads/leaveform.xlsx'  ?>'><i class='fa fa-download'></i>  Download Form </a></div>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>

    </div>



<div class="row" style="margin-bottom:20px">

     <div class="col-lg-5 col-md-5 col-sm-12">

     <div class='card'>
     <table class='table'>
      </table>
         <div id='searchcontainer' style="margin:10px">
         <form method='post' enctype="multipart/form-data">
  <input type='hidden' name='employeeid'    value='<?php echo  $data['empdata']->basic_id ?>'   />
    <input type='hidden' name='compval' id='compvalue'    value='<?php echo  $data['empdata']->company   ?>'   />
<table class='table'>
  <tr>
  <td>Employee Name</td>
  <td><?php echo $data['empdata']->fullname   ?></td>
  </tr>

  <tr>
  <td>Company</td>
  <td><?php echo $data['empdata']->company   ?></td>
  </tr>

  <tr>
  <td>Department</td>
  <td><?php echo $data['empdata']->department   ?></td>
  </tr>

  <tr>
  <td>Position</td>
  <td><?php echo $data['empdata']->position   ?></td>
  </tr>

  <tr>
  <td>Available Leave days</td>
  <td><?= Leavedays::availabledays($data['empdata']->basic_id,date('Y'),$data['leavedata']->lid)   ?></td>
  </tr>
  <input type="hidden" id='availableleave' value="<?= Leavedays::availabledays($data['empdata']->basic_id,date('Y'),$data['leavedata']->lid)   ?>" name="">
  <tr>
  <td>Leave Type:</td>
  <td><select class='form-control' id='leavetype' name='leavetype'>
      <option><?=$data['leavedata']->leavetype?></option>
    <option>Normal</option>
    <option>Maternity</option>
  </select>
  </td>
  </tr>
  <!-- <tr>
  <td>Reported To:</td>
  <td><select class='form-control' required name='reportedby'>
    <option>Select</option>
    <?php
    foreach($data['userdata'] as $get){
      echo '<option value='.$get->uid.'>'.$get->firstname.' '.$get->surname  .'</option>';
    }
    ?>
  </select>
  </td>
  </tr>

  <tr>
  <td>Cc:</td>
  <td><select class='form-control' name='reportedbycc[]' id='reportedbycc' multiple >
    <?php
    foreach($data['userdata'] as $get){
          echo '<option value='.$get->uid.'>'.$get->firstname.' '.$get->surname  .'</option>';
    }
    ?>
  </select>
  </td>
  </tr> -->

  <tr>
  <td>Start Date</td>
  <td>  <input type='text' name='startdate' required id='leavestartdate' value="<?=$data['leavedata']->startdate?>" class="form-control leavedate"  /></td>
  </tr>

  <tr>
  <td>End Date</td>
  <td>  <input type='text' name='endate' required id='leaveenddate' value="<?=$data['leavedata']->endate?>" class="form-control leavedate"   /></td>
  </tr>

  <tr>
  <td>Reason</td>
  <td><textarea class='form-control' required name='description'><?=$data['leavedata']->description?></textarea></td>
  </tr>


<input type="hidden" name="leaveid" value="<?= $data['leavedata']->lid?>">

  <tr>
  <td>Attach Document</td>
  <td><input type="file"  name="leavedoc"/></td>
  </tr>

    <tr>
    <td></td>
    <td><button type='submit' name='submitleave' style='font-size:9px' class='btn btn-primary'>
    <i class='fa fa-plus-circle'></i> Submit</button></td>
    </tr>

</table>
</form>
        </div>
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
       <td>Employee</td>
       <td>Start Date</td>
       <td>End Date</td>
       <td>View </td>
       <td>Edit </td>
       <td>Delete </td>
       <td>Download</td>
      </tr>
      </thead>

       <?php
        foreach($data['grievancedata'] as $get):
          $em = new Employee($get->employeeid);
          $employeename  =   $em->recordObject->fullname;
       ?>
       <tr>
       <td><?php echo $employeename   ?></td>
       <td><?php  echo $get->startdate ?></td>
       <td><?php  echo $get->endate ?></td>
       <td><a href='<?php  echo URLROOT.'/Operations/operationprofile/Leave/'.$get->lid   ?>'>View</a></td>
       <td><a href='<?php  echo URLROOT.'/Operations/Leaveedit/'.$get->lid   ?>'>Edit</a></td>
       <td><a style='color:crimson' href='#' lid="<?=$get->lid?>" class="deleteleave">Delete</a></td>
       <td><a href='<?php  echo URLROOT.'/uploads/'.$get->filename   ?>' >Download</a></td>
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
  <script>
var urlroot = marketplacecfg.urlroot;


var urlroot = marketplacecfg.urlroot;
$('#reportedbycc').SumoSelect({search: true});

$(".leavedate").datepicker({inline: true,
changeMonth: true, changeYear: true, yearRange: "1920:2080", dateFormat: 'yy-mm-dd' });


  $("#leaveenddate").change(function (e) { 
        e.preventDefault();
        var startdate = $("#leavestartdate").val();
        var enddate = $(this).val();
        var available = $("#availableleave").val();
        var leavetype = $("#leavetype").val();
        if (leavetype=='Maternity') return;
        ajaxurl = urlroot + "/operations/isleavevalid";
        postdata ={startdate:startdate,enddate:enddate,available:available}
        $.ajax({
            type: "POST",
            url:  ajaxurl,
            data: postdata,
            dataType: "html",
            success: function (text) {
               if(text < 0){
                notie.alert({ type: 3, text: 'You have exceeded the available days', time: 3 });
                $("#leaveenddate").val("");
               }
            }
            })
    });
</script>