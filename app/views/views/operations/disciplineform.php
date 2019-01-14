<script>
$('#reportedbycc').SumoSelect({search: true, okCancelInMulti: true});
</script>

<?php
if($data['empcount'] > 0){
?>

<form method='post' enctype="multipart/form-data">
  <input type='hidden' name='employeeid'    value='<?php echo  $data['empdata']->basic_id ?>'   />
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
  <td>Reported To:</td>
  <td><select class='form-control' name='reportedby'>
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
  </tr>

  <tr>
  <td>Subject</td>
  <td><input type="text"  name="subject" class="form-control"/></td>
  </tr>

  <tr>
  <td>Description</td>
  <td><textarea class='form-control' name=description></textarea></td>
  </tr>


  <tr>
  <td>Attach Document</td>
  <td><input type="file"  name="disciplinedoc"/></td>
  </tr>

    <tr>
    <td></td>
    <td><button type='submit' name='submitdiscipline' id='submitdiscipline' style='font-size:9px' class='btn btn-primary'>
    <i class='fa fa-plus-circle'></i> Search</button></td>
    </tr>

</table>
</form>
<?php
}else{
  echo '<h3>Sorry. No Records Found !!!</h3>';
}
 ?>
