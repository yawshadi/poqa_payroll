<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/config.php' ; ?>

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
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> ADD POSTIONS </h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>


      <?php //require APPROOT .'/views/inc/dash.php' ; ?>


      </div>



<div class="row" style="margin-bottom:20px">


     <div class="col-lg-4 col-md-4 col-sm-12">

     <div class= 'card'>
     <form method='post'>

      <table  class='table table-bordered table-condensed' style='font-size:12px'>

       <tr>
       <td>Company</td>
       <td>
       <select class='form-control' name='company' id='company'>
       <?php
       foreach($data['companies'] as $get):
       ?>
       <option><?php echo $get->companyname   ?></option>
       <?php
        endforeach;
       ?>

       </select>

       </td>
      </tr>

      <tr>
       <td>Department</td>
       <td>
       <select class='form-control' name='department' >
       <?php
       foreach($data['departments'] as $get):
       ?>
       <option><?php echo $get->departmentname   ?></option>
       <?php
        endforeach;
       ?>

       </select>

       </td>
      </tr>


      <tr>
       <td>Position</td>
       <td><input type='text' class='form-control' name='position'></td>
      </tr>

      <tr>
       <td></td>
       <td><button class='btn btn-danger' type='submit' name='addposition' > Add </button></td>
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
       <td>Company Name</td>
       <td>Department</td>
       <td>Position</td>
       <td align='center'>Edit</td>
       <td align='center'>Delete</td>
      </tr>
      </thead>

       <?php
        foreach($data['positions'] as $get):
       ?>
       <tr>
       <td><?php  echo $get->company  ?></td>
       <td><?php  echo $get->department  ?></td>
       <td><?php  echo $get->positionname  ?></td>
       <td align='center'><a href='#' class='editposition' positionid='<?php echo $get->pid  ?>'> Edit</a></td>
       <td align='center'><a href='#' class='deleteposition' posid='<?php echo $get->pid  ?>'><i class='fa fa-trash'></i></a></td>
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
