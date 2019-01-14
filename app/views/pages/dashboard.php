<style>
tr, td{
  padding:2px
}

</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/side_nav.php' ;

$n = new User($_SESSION['uid']);
$role =  $n->recordObject->role;

?>



<div class="content-wrapper">


    <div class="container-fluid main_container">


      <div id='placeholder'>


      <div class="row" style="margin-bottom:20px">
      <?php if($role == 'HR Manager' || $role == 'Administrator' || $role == 'Head of Admin' || $role == 'Site Manager'){
        ?>
      <div class="col-lg-4 col-md-4 col-sm-12">
      <a href="<?php echo URLROOT.'/pages/employees' ?>">
      <div class="card">
      <div class="container">
      <h4><b>&nbsp;</b></h4>
      <div align='center'  class="img-holder"> <img class="card-img" src="<?php echo URLROOT ?>/img/group-refresh.svg" /> </div>
      <p align="center" class="roboto" >Employee Administration </p>
      <h4><b>&nbsp;</b></h4>
     </div>
     </div>
      </a>
      </div>

      <?php
         }
      ?>

      <?php if($role == 'HR Manager' || $role == 'Administrator' || $role == 'Head of Admin'){
        ?>

      <div class="col-lg-4 col-md-4 col-sm-12">
      <a href="<?php  echo URLROOT.'/pages/companies';  ?>">
      <div class="card">
      <div class="container">
      <h4><b>&nbsp;</b></h4>
      <div align='center' class="img-holder"> <img class="card-img" src="<?php echo URLROOT ?>/img/settings.svg"  /> </div>
      <p align="center" class="roboto" >System Configurations </p>
      <h4><b>&nbsp;</b></h4>
     </div>
     </div>
      </a>
      </div>
      <?php
         }
      ?>

      <?php
        if($role == 'Administrator' || $role == 'Head of Admin' || $role == 'Payroll Manager'){
      ?>
      <div class="col-lg-4 col-md-4 col-sm-12">

      <div class="card">
      <a href="<?php echo  URLROOT.'/pages/payperiod';?>">
      <div class="container">

      <h4><b>&nbsp;</b></h4>
      <div align='center' class="img-holder"> <img class="card-img" src="<?php echo URLROOT ?>/img/diploma.svg" /> </div>
      <p align="center" class="roboto" >Payroll Configuarions </p>
      <h4><b>&nbsp;</b></h4>
     </div>
     </div>
      </a>
      </div>

      </div>

    <?php } ?>
  </div>

      <!-- End of first upper row -->


      <div class="row" style="margin-bottom:20px">

      <div class="col-lg-4 col-md-4 col-sm-12">
      <a href="<?php echo URLROOT ?>/payrollreport/mainpayroll">
      <div class="card">
      <div class="container">
      <h4><b>&nbsp;</b></h4>
      <div align='center' class="img-holder"> <img class="card-img" src="<?php echo URLROOT ?>/img/newspaper.svg" /> </div>
      <p align="center" class="roboto" >Reports </p>
      <h4><b>&nbsp;</b></h4>
     </div>
     </div>
      </a>
      </div>

      <?php
        if($role == 'Administrator' || $role == 'Head of Admin'){
          ?>
      <div class="col-lg-4 col-md-4 col-sm-12">
      <a href="<?php   echo URLROOT.'/pages/createuser'; ?>">
      <div class="card" >
      <div class="container">
      <h4><b>&nbsp;</b></h4>
      <div align='center'  class="img-holder"> <img class="card-img" src="<?php echo URLROOT ?>/img/user.svg" /> </div>
      <p align="center" class="roboto" >User Management </p>
      <h4><b>&nbsp;</b></h4>
     </div>
     </div>
      </a>
      </div>
    <?php } ?>


      <div class="col-lg-4 col-md-4 col-sm-12">
        <a href="<?php echo URLROOT ?>/task/taskdashboard">
        <div class="card">
        <div class="container">
        <h4><b>&nbsp;</b></h4>
        <div align='center'  class="img-holder"> <img class="card-img" src="<?php echo URLROOT ?>/img/windows-8.svg" /> </div>
        <p align="center" class="roboto" >Task Management </p>
        <h4><b>&nbsp;</b></h4>
       </div>
       </div>
        </a>


      </div>

      </div>
    </div>   <!-- End of Placeholder -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
