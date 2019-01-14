<br/>
<span style='font-size: 15px; font-weight:700; color:red'><i>TASKS ASSIGNED TO YOU</i></span>
<hr/>
<div class="row" style="margin-bottom:20px">
<div class="col-lg-4 col-md-4 col-sm-12">

<a href="<?php echo URLROOT.'/task/taskassignedyou/All'  ?>">
<div class="card" style='background:#DE561E'>
<div class="container">
  <br>
<div align='center'><span style='color:#fff; font-size:12px; font-weight:700'> TOTAL TASKS</span></div>
<hr style='background:#fff'/>
<div align='center' style='font-size:30px; font-weight:700; color:#fff'><?php echo $data['atotaltask']   ?></div>
</div>
</div>
</a>
</div>

<div class="col-lg-4 col-md-4 col-sm-12">
<a href="<?php echo URLROOT.'/task/taskassignedyou/Incomplete'   ?>">
<div class="card">
<div class="container" style="background:#F98228">
  <br>
<div align='center'><span style='color:#fff; font-size:12px;'>UNCOMPLETED TASKS </span></div>
  <hr style='background:#fff'/>
<div align='center' style='font-size:30px; font-weight:700; color:#fff'><?php echo $data['auncompleted']   ?></div>
</div>
</div>
</a>
</div>


<div class="col-lg-4 col-md-4 col-sm-12">
<a href="<?php echo URLROOT.'/task/taskassignedyou/Complete'   ?>">
<div class="card">
<div class="container" style="background:#883002">
  <br>
<div align='center'><span style='color:#fff; font-size:12px;font-weight:700'> COMPLETED TASKS</span></div>
<hr style='background:#fff'/>
<div align='center' style='font-size:30px; font-weight:700; color:#fff'><?php echo $data['acompleted']   ?></div>
</div>
</div>
</a>
</div>

</div>


<table class='table table-bordered table-striped apptables'>

  <thead>
  <tr style="font-size:15px; font-weight:700">
    <td>Task</td>
    <td>Assigned By</td>
    <td>Assigned Date</td>
    <td>Respond</td>

  </tr>
</thead>

  <?php
     foreach ($data['notifications'] as $get):
   ?>
  <tr>
    <td><a href='<?php echo URLROOT.'/task/taskprofile/'. $get->id;  ?>'><?php echo $get->taskname  ?></a></td>
    <td><?php echo $get->firstname. ' '. $get->surname  ?></td>
    <td><?php echo $get->dateassigned  ?></td>
    <td><a href='#'><a href='<?php echo URLROOT.'/task/assignmentdetails/'.$get->taskid   ?>'>Respond</a></td>
  </tr>
  <?php
   endforeach;
   ?>
</table>
