<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/side_nav/user.php' ; ?>

<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
  font-size:12px;
}
.fontdisplay{
  font-size: 13px;
  font-weight: 700;
}
</style>

<div id="empmodal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:800px" role="document">

              <div class="modal-content">
                  <div class="modal-body" id="ajaxcontainer" >

                  </div>

              </div>
          </div>
</div>



  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="
     background:linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)),
    url('<?php  echo URLROOT.'/img/new1.jpg' ?>') !important;
    background-size:cover !important;
    background-attachment:fixed !important;
    background-position: center !important;
    ">



  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> FULL COMPANY PROFILE</h1>
        </div>
   </div>

      <hr style='background:#fafafa'/>

      <div id='placeholder'>

      <div id='ajaxcontainer'> </div>
    </div>



<div class="row" style="margin-bottom:20px">

     <div class="col-lg-5 col-md-5 col-sm-12">

     <div>
     <form method='post'>
     <table class='table table-bordered' style='color:#fff'>
         <tr>
         <td width=40%>Company Name </td>
         <td class='fontdisplay'><?php  echo $data['compdata']->companyname  ?></td>
         </tr>
         <tr>
         <td>Principal Activity</td>
         <td class='fontdisplay'><?php  echo $data['compdata']->principalactivity  ?></td>
         </tr>
          <tr>
         <td>Country</td>
         <td class='fontdisplay'><?php  echo $data['compdata']->country  ?></td>
         </tr>

         <tr>
         <td>Postal Address</td>
         <td class='fontdisplay'><?php  echo $data['compdata']->postaladdress  ?></td>
         </tr>

         <tr>
         <td>Telephone</td>
         <td class='fontdisplay'><?php  echo $data['compdata']->telephone  ?></td>
         </tr>

         <tr>
         <td>Email Address</td>
         <td class='fontdisplay'><?php  echo $data['compdata']->email  ?></td>
         </tr>

         <tr>
         <td>Name of Authorized Person</td>
         <td class='fontdisplay'><?php  echo $data['compdata']->repname  ?></td>
         </tr>

         <tr>
         <td>Telephone of Authorized Person</td>
         <td class='fontdisplay'><?php  echo $data['compdata']->reptelephone  ?></td>
         </tr>

         <tr>
         <td>Manpower Capacity</td>
         <td class='fontdisplay'><?php  echo $data['compdata']->manpower  ?></td>
         </tr>

         </table>

     </form>
     </div>
      </div>

      <div class="col-lg-5 col-md-5 col-sm-5">

      <div>
      <div class="container">

      <div align='center'>

      <table  style='font-size:12px; color:#fff' class='table table-bordered'>
        <tr>
          <td  style='font-weight:700'>Business Document(s)</td>
        </tr>
        <?php
         foreach($data['docdata'] as $get):
        ?>
        <tr>
          <td><a href='<?php  echo URLROOT.'/uploads/'.$get->newname  ?>'>Download</a></td>
        </tr>
       <?php endforeach; ?>
      </table>

      <table  style='font-size:12px; color:#fff' >
        <tr>
          <td  style='font-weight:700' align='left'><button id='approvecompany' companyid='<?php echo $data['compdata']->companyid  ?>' class="btn btn-danger pull-left" style='font-size:12px'>Approve</button></td>
        </tr>

      </table>

      </div>
     </div>
     </div>

      </div>


      </div>


      <div class="row" style="margin-bottom:20px">




      </div>
    </div>   <!-- End of Placeholder -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
