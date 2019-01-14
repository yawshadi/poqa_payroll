<?php
$n = new User($_SESSION['uid']);
$role =  $n->recordObject->role;
 ?>

<div class="vertical-menu" style="margin-top:15px; font-size:16px">
<div href="#" > QUICK MENU </div>

<?php if($role == 'HR Manager' || $role == 'Administrator' || $role == 'Head of Admin' || $role == 'Site Manager'){
  ?>
<a href="<?php echo URLROOT  ?>/pages/employees"> <i  class="fa  fa-user"></i> Employee Management</a>
<?php } ?>
<?php if($role == 'HR Manager' || $role == 'Administrator' || $role == 'Head of Admin'){
  ?>
<a href="<?php echo URLROOT  ?>/pages/companies"><i  class="fa  fa-circle"></i> System Configurations</a>
<?php } ?>

<?php
  if($role == 'Administrator' || $role == 'Head of Admin' || $role == 'Payroll Manager'){
?>
<a href="<?php echo URLROOT  ?>/pages/payperiod"><i  class="fa  fa-circle"></i> Payroll Configurtions</a>
<?php } ?>
<?php
  if($role == 'Administrator' || $role == 'Head of Admin'){
    ?>
<a href="<?php echo URLROOT  ?>/pages/userlist"><i  class="fa  fa-circle"></i> User Management</a>
<?php } ?>
<a href="<?php echo URLROOT  ?>/task/taskdashboard"><i  class="fa  fa-circle"></i> Task Management</a>
<a href="<?php echo URLROOT  ?>/payrollreport/mainpayroll"><i  class="fa fa-home"></i> Reports</a>

<a href="<?php echo URLROOT  ?>/operations"> <i  class="fa  fa-user"></i> Operational Modules</a>


</div>




</ul>


<ul class="navbar-nav ml-auto">
<li class="nav-item" style="te">
<a class="nav-links">

<img class="notification_icon" src="<?php echo URLROOT ?>/asset/notification.png" alt="">
</a>
</li>
</ul>
</div>
</nav>
