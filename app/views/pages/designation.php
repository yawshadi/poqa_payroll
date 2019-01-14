<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/employee.php' ; ?>

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
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> CONFIGURE EMPLOYEE DESIGNATION</h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>

      <div id='ajaxcontainer'> </div>
    </div>



<div class="row" style="margin-bottom:20px">



      <div class="col-lg-12 col-md-12 col-sm-12">

      <div class='card'>
      <div class="container">
      <br/>
      <div align='center'>

      <table  class='table table-bordered table-condensed apptables' style='font-size:12px'>
       <thead>
       <tr>
       <td>Employee Name</td>
       <td>Department</td>
       <td>Position</td>
       <td>Designation</td>
       <td>Change Designation</td>

      </tr>
      </thead>

       <?php
        foreach($data['employees'] as $get):
       ?>
       <tr>
       <td><a href='<?php echo URLROOT.'/pages/fullprofile/'.$get->basic_id;   ?>'><?php  echo $get->fullname  ?></a></td>
       <td><?php  echo $get->department ?></td>
       <td><?php  echo $get->position ?></td>
       <td><?php  echo $get->designation ?></td>
       <td>
         <select class='form-control designation' employeeid='<?php echo $get->basic_id   ?>' >
           <option value=''>Choose</option>
           <option>Casual</option>
           <option>Officer</option>

         </select>

       </td>


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
