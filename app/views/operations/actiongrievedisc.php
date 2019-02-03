<?php
 if($data['status']  == 'Grievance'){
   $actionid = $data['pdata']->gid;
 }else{
   $actionid = $data['pdata']->did;
 }

?>
<table class='table'>

  <tr>
  <td>Subject</td>
  <td><?php echo $data['pdata']->subject;   ?></td>
  </tr>


  <tr>
  <td>Description</td>
  <td><?php echo $data['pdata']->description   ?></td>
  </tr>

  <?php
   if($data['status']  == 'Grievance'):
  ?>

  <tr>
  <td>Action</td>
  <td>
  <select class='form-control' id='action'>
    <option><?php  echo $data['pdata']->status;   ?></option>
    <option>Resolved</option>
    <option>Unresolved</option>
  </select>
  </td>
  </tr>
<?php  endif; ?>
<?php
 if($data['status']  == 'Disciplinary'):
?>
  <tr>
  <td>Action</td>
  <td>

  <select class='form-control' id='action'>
    <option><?php  echo $data['pdata']->status;   ?></option>
    <option>Verbal Warning</option>
    <option>First Warning</option>
    <option>Final Warning</option>
    <option>Suspension</option>
    <option>Dimissal</option>
    <option>Termination</option>
    <option>Resignation</option>
  </select>
  </td>
  </tr>

<?php endif; ?>


  <tr>
  <td></td>
  <td><button class='btn btn-danger updategrievedis' style='font-size: 12px'
    <?php if($data['pdata']->status == 'Approve'){ echo "disabled='disabled'"; }   ?>
    employeeid='<?php echo $data['pdata']->employeeid   ?>'
    status='<?php echo $data['status']   ?>'
    actionid='<?php echo $actionid   ?>'
    >
    Save</button></td>
  </tr>


</table>
