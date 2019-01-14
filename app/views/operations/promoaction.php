<?php
 if($data['status']  == 'Transfer'){
   $actionid = $data['pdata']->tid;
 }else{
   $actionid = $data['pdata']->pid;
 }

?>
<table class='table'>

  <tr>
  <td>New Deparment</td>
  <td><?php echo $data['pdata']->department;   ?></td>
  </tr>

  <tr>
  <td>New Position</td>
  <td><?php echo $data['pdata']->position   ?></td>
  </tr>

  <tr>
  <td>Description</td>
  <td><?php echo $data['pdata']->description   ?></td>
  </tr>

  <tr>
  <td>Action</td>
  <td>
  <select class='form-control' id='action'>
    <option><?php  echo $data['pdata']->status;   ?></option>
    <option>Approve</option>
    <option>Decline</option>
  </select>
  </td>
  </tr>
  <tr>
  <td></td>
  <td><button class='btn btn-danger promoteaction' style='font-size: 12px'
    <?php if($data['pdata']->status == 'Approve'){ echo "disabled='disabled'"; }   ?>
    employeeid='<?php echo $data['pdata']->employeeid   ?>'
    status='<?php echo $data['status']   ?>'
    actionid='<?php echo $actionid   ?>'
    position='<?php echo $data['pdata']->position   ?>'
    department='<?php echo $data['pdata']->department   ?>'
    > Save</button></td>
  </tr>
</table>
