<?php print_r($data)   ?>

<table class='table'>

  <tr>
  <td>Start Date</td>
  <td><?php echo $data->startdate;   ?></td>
  </tr>

  <tr>
  <td>End Date</td>
  <td><?php echo $data->endate   ?></td>
  </tr>

  <tr>
  <td>Reason</td>
  <td><?php echo $data->description   ?></td>
  </tr>

  <tr>
  <td>Action</td>
  <td>
  <select class='form-control' id='action'>
    <option><?php  echo $data->status;   ?></option>
    <option>Approve</option>
    <option>Decline</option>
  </select>
  </td>
  </tr>

  <tr>
  <td></td>
  <td><button class='btn btn-danger updateleave' style='font-size: 12px'
    <?php if($data->status == 'Approve'){ echo "disabled='disabled'"; }   ?>
    actionid='<?php echo $data->lid  ?>'
    >
    Save</button></td>
  </tr>


</table>
