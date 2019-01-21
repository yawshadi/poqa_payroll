<style >
tr, td{
  padding:2px
}
</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/operationsmenu.php' ; ?>

<div id="viewmodal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:400px" role="document">

              <div class="modal-content">
                  <div class="modal-body" id="ajaxcontainer" >

                  </div>

              </div>
          </div>
</div>


<div class="content-wrapper">

  <div style='padding-left:20px; color:#7F400B'><h3><?php echo $data['status']  ?></h3></div>
  <hr/>

    <div class="container-fluid main_container">

      <div id='placeholder' style='margin-top:-30px'>
        <?php //require APPROOT .'/views/inc/analysisbar.php' ; ?>
      <div class="row" style="margin-bottom:20px;">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <a href="#">
        <div class="card">
        <div class="container" style="padding:10px">
          <br/>
        
          <div id="calendar"></div>
        </div>
        </div>
        </a>
      </div>



    </div>   <!-- End of Placeholder -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
