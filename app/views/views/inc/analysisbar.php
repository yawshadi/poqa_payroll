<div class="row" style="margin-bottom:20px">

<div class="col-lg-3 col-md-3 col-sm-12">
<a href="<?php echo URLROOT.'/task/mastertaskstatisticslist/All'  ?>">
<div class="card" style='background:#DE561E'>
<div class="container">
  <br>
<div align='center'><span style='color:#fff; font-size:12px; font-weight:700'> TOTAL TASKS</span></div>
<hr style='background:#fff'/>
<div align='center' style='font-size:30px; font-weight:700; color:#fff'><?php echo $data['totaltaskmaster']   ?></div>
</div>
</div>
</a>
</div>

<div class="col-lg-3 col-md-3 col-sm-12">
<a href="<?php echo URLROOT.'/task/mastertaskstatisticslist/Assigned'   ?>">
<div class="card">
<div class="container" style="background:#F98228">
  <br>
<div align='center'><span style='color:#fff; font-size:12px;'>ASSIGNED TASKS</span></div>
  <hr style='background:#fff'/>
<div align='center' style='font-size:30px; font-weight:700; color:#fff'><?php echo $data['assignedtaskmaster']   ?></div>
</div>
</div>
</a>
</div>


<div class="col-lg-3 col-md-3 col-sm-12">
<a href="<?php echo URLROOT.'/task/mastertaskstatisticslist/Complete' ?>">
<div class="card">
<div class="container" style="background:#BC5603">
  <br>
<div align='center'><span style='color:#fff; font-size:12px;font-weight:700'> COMPLETED TASKS</span></div>
<hr style='background:#fff'/>
<div align='center' style='font-size:30px; font-weight:700; color:#fff'><?php echo $data['completedmaster']   ?></div>
</div>
</div>
</a>
</div>


<div class="col-lg-3 col-md-3 col-sm-12">
<a href="#">
<div class="card" style='background:#EA9902'>
<div class="container">
<br>
<div align='center'><span style='font-size:12px;font-weight:700; color:#fff'> UNASSIGNED TASKS</span></div>
<hr style='background:#fff'/>
<div align='center' style='font-size:30px; color:#fff; font-weight:700'><?php echo $data['totaltaskmaster'] - $data['assignedtaskmaster']  ?></div>
</div>
</div>
</a>
</div>

</div>
