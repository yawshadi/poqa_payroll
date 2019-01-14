<style>
tr, td{
  padding:2px
}

</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/operationsmenu.php' ;
$n = new User($_SESSION['uid']);
$role =  $n->recordObject->role;
 ?>
<div class="content-wrapper">


    <div class="container-fluid main_container">


      <div id='placeholder' style='margin-top:-50px'>

      <?php
      require APPROOT .'/views/inc/oanalysisbar.php' ;
      ?>


      </div>


    </div>   <!-- End of Placeholder -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
