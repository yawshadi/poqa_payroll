<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/system.php' ; ?>

<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
}

</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">
      <div id="viewmodal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="width:600px" role="document">

              <div class="modal-content">
                  <div class="modal-body" id="ajaxcontainer" >

                  </div>

              </div>
          </div>
      </div>



      <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> BANK CODES </h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>


      <?php // require APPROOT .'/views/inc/dash.php' ; ?>


      </div>



<div class="row" style="margin-bottom:20px">


     <div class="col-lg-4 col-md-4 col-sm-12">
     <div class = 'card'>
     <form method='post'>


      <table  class='table table-bordered table-condensed' style='font-size:12px'>

       <tr>
       <td>Bank Name</td>
       <td><input type='text' class='form-control' required name='bankname'> </td>
      </tr>

      <tr>
       <td>Bank Code</td>
       <td><input type='text' class='form-control' required name='bankcode'></td>
      </tr>

      <tr>
       <td>Branch Name</td>
       <td><input type='text' class='form-control' required name='branchname'></td>
      </tr>

      <tr>
       <td>Branch Code</td>
       <td><input type='text' class='form-control' required name='branchcode'></td>
      </tr>

      <tr>
       <td></td>
       <td><button class='btn btn-danger' type='submit' name='addbank' > Add </button></td>
      </tr>

      </table>

      </form>

      </div>

      </div>

      <div class="col-lg-8 col-md-8 col-sm-8">

      <div class='card'>
      <div class="container">
      <br/>
      <div align='center'>
       <?php
       if(isset($data['response'])) :
       ?>
      <div class='<?php echo $data['class']  ?>'><?php echo $data['response']  ?></div>
       <?php endif;  ?>


      <table  class='table table-bordered table-condensed apptables' style='font-size:12px'>
       <thead>
       <tr>
       <td>Bank Name</td>
       <td>Bank Code</td>
       <td>Branch Name</td>
       <td>Branch Code</td>
        <td>Edit </td>
       <td>Delete</td>
      </tr>
      </thead>

       <?php
        foreach($data['banks'] as $get):
       ?>
       <tr>
       <td><?php  echo $get->bankname  ?></td>
       <td><?php  echo $get->bankcode  ?></td>
       <td><?php  echo $get->branch ?></td>
       <td><?php  echo $get->branchcode ?></td>
        <td><a href='#' class = "editbank" bankid='<?php echo $get->bankid  ?>' ><i class='fa fa-pencil'></i></a></td>
       <td><a href='#' class='deletebank' bankid='<?php echo $get->bankid  ?>'><i class='fa fa-trash'></i></a></td>
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
    <?php require APPROOT .'/views/inc/footer.php'  ?>
