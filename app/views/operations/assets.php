<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/operationsmenu.php' ; ?>

<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
  font-size:12px;
}
</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">

  <div id="empmodal" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width:800px" role="document">

                <div class="modal-content">
                    <div class="modal-body" id="ajaxcontainer" >

                    </div>

                </div>
            </div>
</div>


  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-10">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> ASSETS MANAGEMENT</h1>
        </div>

       <!-- <div class="col-2">
         <div style='margin-top:10px'><a class='btn btn-danger' style='font-size:11px' href='<?php echo URLROOT.'/downloads/promotion.docx'  ?>'><i class='fa fa-download'></i>  Download Form </a></div>
        </div>-->
   </div>

      <hr/>

      <div id='placeholder'>

    </div>



<div class="row" style="margin-bottom:20px">

     <div class="col-lg-5 col-md-5 col-sm-12">

     <div class='card'>
     <table class='table'>
     <tr>
         <td width=90%><input type="text" class="form-control bom employeename"  id="empname" placeholder="Search Employee Name, StaffID or Telephone"/></td>
         <td><button type='button' id='assetsbtn' style='font-size:10px' class='btn btn-primary'>
         <i class='fa fa-plus-circle'></i> Search</button></td>
         </tr>
         <input type="hidden" class="form-control" id="employeeid">


      </table>
         <div id='searchcontainer' style="margin:10px"> </div>
     </div>

      </div>

      <div class="col-lg-7 col-md-7 col-sm-7">

      <div class='card'>
      <div class="container">
      <br/>
      <div align='center'>

      <table  class='table table-bordered table-condensed apptables' style='font-size:12px'>
       <thead>
       <tr>
       <td>Employee</td>

       <td>Asset Name</td>
       <td>Asset Quantity</td>
       <td>Assigned Date</td>
       <td>View </td>
       <td>Download</td>
      </tr>
      </thead>

       <?php
        foreach($data['assetdata'] as $get):
          $em = new Employee($get->employeeid);
          $employeename  =   $em->recordObject->fullname;
       ?>
       <tr>
       <td><?php echo $employeename;  ?></td>
       <td><?php  echo $get->assetname ?></td>
       <td><?php  echo $get->assetquantity ?></td>
       <td><?php  echo $get->reportdate ?></td>
       <td><a href='<?php  echo URLROOT.'/operations/operationprofile/assets/'.$get->aid   ?>' >View</a></a></td>
       <td><a href='<?php  echo URLROOT.'/uploads/'.$get->filename   ?>' >Download</a></td>

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
