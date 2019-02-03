<script>

var urlroot = marketplacecfg.urlroot;
$('#reportedbycc').SumoSelect({search: true});

$(".leavedate").datepicker({inline: true,
changeMonth: true, changeYear: true, yearRange: "1920:2080", dateFormat: 'yy-mm-dd' });

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
  <td>Available Leave days</td>
  <td><?= Leavedays::availabledays($data['empdata']->basic_id,date('Y'))   ?></td>
  </tr>
  <input type="hidden" id='availableleave' value="<?= Leavedays::availabledays($data['empdata']->basic_id,date('Y'))   ?>" name="">
  <tr>
  <td>Leave Type:</td>
  <td><select class='form-control' id='leavetype' name='leavetype'>
    <option>Normal</option>
    <option>Maternity</option>
  </select>
  </td>
  </tr>
  <tr>
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
  </tr>

  <tr>
  <td>Start Date</td>
  <td>  <input type='text' name='startdate' required id='leavestartdate' class="form-control leavedate"  /></td>
  </tr>

  <tr>
  <td>End Date</td>
  <td>  <input type='text' name='endate' required id='leaveenddate' class="form-control leavedate"   /></td>
  </tr>

  <tr>
  <td>Reason</td>
  <td><textarea class='form-control' required name='description'></textarea></td>
  </tr>




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
<?php
}else{
  echo '<h3>Sorry. No Records Found !!!</h3>';
}
 ?>

<script>
var urlroot = marketplacecfg.urlroot;

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