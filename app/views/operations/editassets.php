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
        <div class="col-10">
          <h1 style='color:#FB6600; font-weight:700' class="page-title">EDIT ASSETS MANAGEMENT</h1>
        </div>

       <!-- <div class="col-2">
         <div style='margin-top:10px'><a class='btn btn-danger' style='font-size:11px' href='<?php echo URLROOT.'/downloads/promotion.docx'  ?>'><i class='fa fa-download'></i>  Download Form </a></div>
        </div>-->
   </div>

      <hr/>

      <div id='placeholder'>

    </div>



<div class="row" style="margin-bottom:20px">

     <div class="col-lg-5 col-md-5 col-sm-12">

     <div class='card'>
  
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
  <td>Asset Name:</td>
  <td><input type="text" name='assetname' class="form-control" value="<?= $data['asset']->assetname?>" id='assetname' required/>
  </td>
  </tr>
  <tr>
  <td>Asset Quantity:</td>
  <td><input type="text" name='assetquantity' value="<?= $data['asset']->assetquantity?>" class="form-control" id='assetquantity' required/>
  </td>
  </tr>
  <tr>
  <td>Assigning Officer:</td>
  <td><select class='form-control' name='reportedby'>
    <option>Select</option>
    <?php foreach($data['userdata'] as $get):?>
    <option value="<?= $get->uid?>" <?=$get->uid==$data['asset']->uid? 'selected':''?> ><?= $get->firstname.' '.$get->surnamae?></option>
    <?php endforeach ?>
    </select>
  </td>
  </tr>
  <tr>
  <td>Asset Status:</td>
  <td><select class='form-control' name='status'>
    <option>Select</option>
    <option value="1" <?=$data['asset']->status == 1? 'selected':''?>>Returned</option>
    <option value="0" <?=$data['asset']->status == 0? 'selected':''?>>Not Returned</option>
    
    </select>
  </td>
  </tr>
  <tr>
  <td>Returned Date</td>
  <td><input type="text" name="returneddate"  value="<?= $data['asset']->returneddate?>" class='form-control leavedate' id="rdate">
  </td>
  </tr>
  <!-- <tr>
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
  <td>Description</td>
  <td><textarea class='form-control' name=description><?= $data['asset']->description?></textarea></td>
  </tr>
  <tr>
  <td>Attach Document</td>
  <td><input type="file"  name="assetdoc"/></td>
  </tr>
    <tr>
    <td></td>
    <td><button type='submit' name='submitasset' style='font-size:9px' class='btn btn-primary'>
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

       <td>Asset Name</td>
       <td>Asset Quantity</td>
       <td>Assigned Date</td>
       <td>View </td>
       <td>Edit </td>
       <td>Delete </td>
       <td>Returned</td>
      </tr>
      </thead>

       <?php
        foreach($data['assetdata'] as $get):
          $em = new Employee($get->employeeid);
          $employeename  =   $em->recordObject->fullname;
       ?>
       <tr>
       <td><?php echo $employeename;  ?></td>
       <td><?php  echo $get->assetname ?></td>
       <td><?php  echo $get->assetquantity ?></td>
       <td><?php  echo $get->reportdate ?></td>
       <td><a href='<?php  echo URLROOT.'/operations/operationprofile/assets/'.$get->aid   ?>' >View</a></a></td>
       <td><a href='<?php  echo URLROOT.'/Operations/Assets/'.$get->aid   ?>'>Edit</a></td>
       <td><a style='color:crimson' href='#' assetid="<?=$get->aid?>" class="deleteasset">Delete</a></td>
       <td><button style='font-size:9px' class='btn-sm  btn-<?=$get->status== 1?'success':'danger'?>'><?=$get->status==1?'Yes':'No'?></button></td>

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
    $(".leavedate").datepicker({inline: true,
changeMonth: true, changeYear: true, yearRange: "1920:2080", dateFormat: 'yy-mm-dd' });
</script>