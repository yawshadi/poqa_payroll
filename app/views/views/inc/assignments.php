<div style="margin-top:50px">
<?php if(isset($data)):  ?>
<table class='table table-bordered' style="font-size:15px">
  <tr>
    <td><h5>Task Notifications</h5></td>
  </tr>
  <?php
   foreach($data as $get):
   ?>
<tr>
  <td style="font-size:15px"><a href='<?php echo URLROOT.'/task/assignmentdetails/'.$get->taskid   ?>'><i style='color:red' class='fa fa-folder-open'></i>
     <?php  echo $get->taskname  ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif;   ?>

</div>
