<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/system.php' ; ?>

<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
  font-size:12px
}

</style>


  <!-- Commhr content goes here -->
  <div class="content-wrapper" style="background: #fafafa">
  

  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#FB6600; font-weight:700' class="page-title"> ENTER BRANCH WEEKLY VALUES  </h1>
        </div>
   </div>
      
      <hr/>
      <?php
      if(isset($data['message'])):  ?>
      <div id='placeholder' class='alert alert-success'>
      <?php echo $data['message']   ?>
      </div>
<?php endif;  ?>



<div class="row" style="margin-bottom:20px">  


     <div class="col-lg-12 col-md-12 col-sm-12">
     <div class = 'card'>
     <form method='post'>

      <table  class='table table-bordered table-condensed' style='font-size:12px; width:50%'>
      
      <tr> 
      <td><input type='text' class='form-control' id='from' name='start'></td>
      <td><input type='text' class='form-control' id='to'  name='end'></td>
      <td><button type=submit class='btn btn-danger' name='sendbranch' style='font-size:10px'>Submit</button></td>
     </tr>
      </table>
 
      
      <hr/>

     
      <?php  if(isset($data['branchdata'])){  ?>
      <table id='success'  class='table datatable table-bordered table-condensed'>
  	<thead>
	   <tr>
  	 <td>Branch</td>
  	 <td>Attendance</td>
  	 <td>Offering </td>
  	  <td>Tithe</td>
  	  <td>Welfare</td>
      <td>Midweek</td>
      <td>Harvest</td>
      <td>Expenses</td>

     </tr>
      </thead>
     <?php
      foreach($data['branchdata'] as $get):

     ?>	
     <tr>
      <td width='10%'><?php echo $get->branchname ?> <input type='hidden'  value='<?php echo $get->branchname ?>' name='branchname[]' class='form-control'/> </td>
  	  <td><input type='text' value=0  name='attendance[]' class='form-control'/></td>
  	  <td><input type='text' value=0.00    name='offering[]' class='form-control '/></td>
  	  <td><input type='text' value=0.00   name='tithe[]' class='form-control'/></td>
      <td><input type='text' value=0.00   name='welfare[]' class='form-control'/></td>
      <td><input type='text' value=0.00   name='midweek[]' class='form-control'/></td>
      <td><input type='text' value=0.00   name='harvest[]' class='form-control'/></td>
      <td><input type='text' value=0.00   name='expenses[]' class='form-control'/></td>
 	
     </tr>	

     <?php
	   endforeach;
     ?>
  </table>	
  <?php
      }

  ?>

</form>

      </div>

      <div id='ajaxcontainer'></div>

   



     
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
 