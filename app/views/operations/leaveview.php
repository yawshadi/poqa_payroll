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
       
          <div id="calendar"></div>

        </div>
        </div>
        </a>
      </div>



    </div>   <!-- End of Placeholder -->

    </div>
    </div>
    <div class="modal fade" id="myCalendarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style='width:500px' role="document">
            <!--Content-->
            <div class="modal-content form-elegant bookingform">

            </div>
            <!--/.Content-->
        </div>
    </div>

  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
