
<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/side_nav.php' ; ?>

<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #800080;
  padding:2px;
}

</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">

  <div id="viewmodal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 800px" role="document">

                <div class="modal-content"  style="width: 600px" >
                    <div class="modal-body" id="ajaxcontainer">
                        
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Close</button> -->

                    </div>

                </div>
            </div>
  </div>
  

  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#800080; font-weight:700' class="page-title">CUSTOMER SUBSCRIPTIONS</h1>
        </div>
   </div>
      
      <hr/>
     
      <div id='placeholder'>


      <?php require APPROOT .'/views/inc/dash.php' ; ?>




      </div>



<div class="row" style="margin-bottom:20px">  


      <div class="col-lg-12 col-md-12 col-sm-12">
      
      <div class='card'>
      <div class="container">
      <br/>
      <div align='center'>
     

      <table  class='table table-bordered table-condensed table-striped apptables' style='font-size:12px'>
       <thead>
       <tr>
       <td>Customer Name</td>
       <td>Email</td>
       <td>Subscription Type</td>
       <td>Price</td>
       <td>Date Applied</td>
      </tr>
      </thead>

       <?php
        foreach($data as $get):
       ?>
       <tr>
       <td><?php  echo $get->firstname.' '.$get->lastname  ?></td>
       <td><?php  echo $get->email  ?></td>
       <td><?php  echo $get->product  ?></td>
       <td><?php  echo $get->totalamount  ?></td>
       <td><?php  echo $get->datecreated  ?></td>
       
      </tr>
       <?php
       endforeach;
       ?>


      </table>
      </div>
     </div>
     </div>
    
      </div>


      </div>


      

      <!-- End of first upper row -->


      <div class="row" style="margin-bottom:20px">

      

      


      </div>
    </div>   <!-- End of Placeholder -->

    </div>
    </div>
   

  <!--Footer and JS directies -->
  
  <?php require APPROOT .'/views/inc/footer.php'  ?>




