<?php
$n = new User($_SESSION['uid']);
$role =  $n->recordObject->role;
 ?>

<div class="vertical-menu" style="margin-top:15px; font-size:16px">
<div href="#" > QUICK MENU </div>
<a href="<?php echo URLROOT  ?>/pages/employees"> <i  class="fa  fa-circle"></i> Add New Employee</a>
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
