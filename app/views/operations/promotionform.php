<script>

  const urlroot = marketplacecfg.urlroot;
$('#reportedbycc').SumoSelect({search: true, okCancelInMulti: true});

$('.newdepartment').change(function(){

      var compvalue  = $('#compvalue').val();
      var department = $(this).val();
      var postdata = {compvalue:compvalue, department:department};
      var ajaxurl =  urlroot + '/ajax/positiondata';

      $('#newposition').html('');

      $.ajax({
          type: "POST",
          url: ajaxurl,
          data : postdata,
          beforeSend: function () {
              $.blockUI();
          },
          success: function (json) {

              var data = JSON.parse(json);
              $('#newposition').append('<option>' + 'Select Position' + '</option>');
              for (var key in data) {
                  if (data.hasOwnProperty(key)) {

                    $('#newposition').append('<option>' + data[key].positionname + '</option>');
                  }
              }

          },
          complete: function () {
              $.unblockUI();
          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status + " " + thrownError);
          }
      });
  })
</script>

<?php
if($data['empcount'] > 0){
?>

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
  <td>New Department</td>
  <td><select class='form-control newdepartment' name='department'>
    <option>Select</option>
    <?php
    foreach($data['departmentdata'] as $get){
      echo '<option>'.$get->departmentname.'</option>';
    }
    ?>
  </select></td>
  </tr>

  <tr>
  <td>New Position</td>
  <td><select class='form-control' name='position' id='newposition'>
    <option value=''>Select Position</option>
  </select></td>
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
  <td>Description</td>
  <td><textarea class='form-control' name=description></textarea></td>
  </tr>


  <tr>
  <td>Attach Document</td>
  <td><input type="file"  name="promotiondoc"/></td>
  </tr>

    <tr>
    <td></td>
    <td><button type='submit' name='submitpromotion' style='font-size:9px' class='btn btn-primary'>
    <i class='fa fa-plus-circle'></i> Search</button></td>
    </tr>

</table>
</form>
<?php
}else{
  echo '<h3>Sorry. No Records Found !!!</h3>';
}
 ?>
