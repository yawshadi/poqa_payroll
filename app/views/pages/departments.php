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
              <h1 style='color:#FB6600; font-weight:700' class="page-title"> ADD DEPARTMENTS </h1>
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
       <td>Company Name</td>
       <td>
       <select class='form-control' name='companyname'>
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
       <td>Department Name</td>
       <td><input type='text' class='form-control' name='departmentname'></td>
      </tr>

      <tr>
       <td>Department Code</td>
       <td><input type='text' class='form-control' name='departmentcode'></td>
      </tr>

      <tr>
       <td></td>
       <td><button class='btn btn-danger' type='submit' name='addepartment' > Add </button></td>
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
       <td>Department Code</td>
       <td>Edit </td>
       <td>Delete</td>
      </tr>
      </thead>

       <?php
        foreach($data['departments'] as $get):
       ?>
       <tr>
       <td><?php  echo $get->company  ?></td>
       <td><?php  echo $get->departmentname  ?></td>
       <td><?php  echo $get->departmentcode  ?></td>
           <td><a href='#' class="editdepartment" departmentid='<?php echo $get->did  ?>'>Edit</a></td>
       <td><a href='#' class='deletedepartment' departmentid='<?php echo $get->did  ?>'><i class='fa fa-trash'></i></a></td>
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
 