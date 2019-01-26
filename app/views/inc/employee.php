<?php
$n = new User($_SESSION['uid']);
$role =  $n->recordObject->role;
 ?>

<div class="vertical-menu" style="margin-top:15px; font-size:16px">
<div href="#" > QUICK MENU </div>

<?php if($role == 'HR Manager' || $role == 'Administrator' || $role == 'Head of Admin' || $role == 'Site Manager'){
  ?>
<a href="<?php echo URLROOT  ?>/pages/employees"> <i  class="fa  fa-circle"></i> Add New Employee</a>
<a href="<?php echo URLROOT  ?>/pages/designation"> <i  class="fa  fa-circle"></i> Employee Designation</a>
<?php } ?>

<?php
  if($role == 'Administrator' || $role == 'Head of Admin' || $role == 'HR Manager'){
?>
<a href="<?php echo URLROOT  ?>/pages/visamasterlist"><i  class="fa  fa-circle"></i> Masterlist of Employee</a>
<?php } ?>

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
