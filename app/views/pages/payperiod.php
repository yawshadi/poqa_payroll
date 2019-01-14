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


  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> SET UP PAYROLL PERIOD </h1>
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
     <td>Company</td>
       <td>
        <select class='form-control bom' name='company' id='compval'>
          <option value=''>Select Company</option>
          <?php
           foreach($data['Companies'] as $get):
           ?>
           <option><?php echo $get->companyname   ?></option>
           <?php
            endforeach
           ?>
          </select>
          </td>
       </tr>

       <tr>
       <td>Start Date</td>
       <td><input type='text' class='form-control' id='from' name='paystart'></td>
      </tr>

      <tr>
       <td>End Date</td>
       <td><input type='text' class='form-control' id='to'  name='payend'></td>
      </tr>

      <tr>
       <td></td>
       <td><button class='btn btn-danger' type='submit' name='addperiod' > Begin a New Period </button></td>
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
       <td>Company</td>
       <td>Payroll Start</td>
       <td>Payroll End </td>

       <!-- <td>Edit </td> -->
       <td>Delete</td>
      </tr>
      </thead>

       <?php
        foreach($data['payperiod'] as $get):
       ?>
       <tr>
       <td><?php  echo $get->company  ?></td>
       <td><?php  echo $get->start  ?></td>
       <td><?php  echo $get->end  ?></td>
       <!-- <td><a href='#'<i class='fa fa-pencil'></i></a></td> -->
       <td><a href='#' class='deleteperiod' periodid='<?php echo $get->payrollperiodid  ?>'><i class='fa fa-trash'></i></a></td>
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
