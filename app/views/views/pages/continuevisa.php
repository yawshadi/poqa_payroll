<form method="post" enctype="multipart/form-data">
<table class='table table-bordered'>
  <tr>
    <td>Name of applicant</td>
    <td><h6><?php echo $data->fullname   ?></h6></td>
  </tr>

  <tr>
    <td>Number of Children</td>
    <td><?php echo $data->numberofchildren   ?></td>
  </tr>

  <?php for($i=1; $i<= $data->numberofchildren; $i++){
     //for($i=1; $i<= 2; $i++){
   ?>
  <tr>
    <td><input type="text" class="form-control bom"  name="nameofchild[]" placeholder='Name of Child' /></td>
    <td><input type="text" class="form-control bom alldate"  name="dobofchild[]" placeholder='Date of Birth' /></td>
  </tr>
 <?php } ?>

<tr>
  <td>Passport Picture</td>
  <td><input type="file" name="passportdoc" id="passportdoc" style="font-size:10px" /></td>
</tr>

<tr>
  <td>Supporting Document</td>
  <td><input type="file" name="supportingdoc" id="supportingdoc" style="font-size:10px" /></td>
</tr>

<tr>
  <td><input type="hidden" class="form-control bom"  name="basicid" value='<?Php echo $data->basic_id ?>' /></td>
  <td><button name='visapplicantbtn' type='submit' class='btn btn-warning' style="background:red; font-size:12px"> Submit </button></td>
</tr>
</table>
</form>


<script type="text/javascript">
var uroot = '<?php  echo URLROOT.'/pages/savepassport/'.$data->basic_id ?>';
var suroot = '<?php  echo URLROOT.'/pages/savesupporting/'.$data->basic_id ?>';

$('#passportdoc').uploadifive({
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


 $('#supportingdoc').uploadifive({
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
