<span style='font-size: 15px; font-weight:700;'><i>TASKS CREATED BY YOU</i></span>
<hr/>
<div class="row" style="margin-bottom:20px">
<div class="col-lg-4 col-md-4 col-sm-12">

<a href="<?php echo URLROOT.'/task/individualstatisticslist/All'  ?>">
<div class="card" style='background:#22165F'>
<div class="container">
  <br>
<div align='center'><span style='color:#fff; font-size:12px; font-weight:700'> TOTAL TASKS</span></div>
<hr style='background:#fff'/>
<div align='center' style='font-size:30px; font-weight:700; color:#fff'><?php echo $data['totaltask']   ?></div>
</div>
</div>
</a>
</div>

<div class="col-lg-4 col-md-4 col-sm-12">
<a href="<?php echo URLROOT.'/task/individualstatisticslist/Incomplete'   ?>">
<div class="card">
<div class="container" style="background:#41031C">
  <br>
<div align='center'><span style='color:#fff; font-size:12px;'>UNCOMPLETED TASKS </span></div>
  <hr style='background:#fff'/>
<div align='center' style='font-size:30px; font-weight:700; color:#fff'><?php echo $data['uncompleted']   ?></div>
</div>
</div>
</a>
</div>


<div class="col-lg-4 col-md-4 col-sm-12">
<a href="<?php echo URLROOT.'/task/individualstatisticslist/Complete'   ?>">
<div class="card">
<div class="container" style="background:#6F9C3A">
  <br>
<div align='center'><span style='color:#fff; font-size:12px;font-weight:700'> COMPLETED TASKS</span></div>
<hr style='background:#fff'/>
<div align='center' style='font-size:30px; font-weight:700; color:#fff'><?php echo $data['completed']   ?></div>
</div>
</div>
</a>
</div>




</div>
