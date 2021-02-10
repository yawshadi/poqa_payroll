<?php
$n = new User($_SESSION['uid']);
$role =  $n->recordObject->role;
 ?>
<div class="vertical-menu" style="margin-top:15px; font-size:16px">
<div href="#" > QUICK MENU </div>



<?php
if($role != 'Leave Manager'  ){
?>
<a href="<?php echo URLROOT  ?>/operations"> <i  class="fa  fa-arrow-left"></i> Back to Operations</a>
<br/>
<a href="<?php echo URLROOT  ?>/operations/Appraisal"> <i  class="fa  fa-circle"></i> Appraisal Form</a>
<a href="<?php echo URLROOT  ?>/operations/grievance"> <i  class="fa  fa-circle"></i> Grievances Management Form</a>
<a href="<?php echo URLROOT  ?>/operations/discipline"><i  class="fa  fa-circle"></i> Disciplinary /Resignation Mgt Form</a>
<a href="<?php echo URLROOT  ?>/operations/promotion"><i  class="fa  fa-circle"></i> Promotions Management Form</a>
<a href="<?php echo URLROOT  ?>/operations/transfer"><i  class="fa  fa-circle"></i> Transfers Management Form</a>
<a href="<?php echo URLROOT  ?>/operations/Assets"><i  class="fa  fa-circle"></i> Assets Management Form</a>
<?php } ?>
<a href="<?php echo URLROOT  ?>/operations/leave"><i  class="fa  fa-circle"></i> Leave Management Form</a>
<a href="<?php echo URLROOT  ?>/operations/operationsview/Leave"><i  class="fa  fa-circle"></i> Leave Calendar</a>
    <a href="<?php echo URLROOT  ?>/operations/holiday"><i  class="fa  fa-circle"></i> Holiday Setup</a>
    <a href="<?php echo URLROOT  ?>/operations/leavedays"><i  class="fa  fa-circle"></i> Leave Days</a>
    <a href="<?php echo URLROOT  ?>/payrollreport/leavereport"><i  class="fa  fa-circle"></i> Leave Report</a>



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
