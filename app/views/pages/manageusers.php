<!-- Header and CSS Directives-->



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
  

  <div class="container-fluid main_container" style='margin-top:-10px'>

      <div class="row">
        <div class="col-12">
          <h1 style='color:#800080; font-weight:700' class="page-title">MANAGE USERS</h1>
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
       <td>Firstname</td>
       <td>Last Name</td>
       <td>Email</td>
       <td>Super Admin</td>
       <td>Edit</td>
       <td>Delete</td> 
      </tr>
      </thead>

       <?php
        foreach($data as $get):
       ?>
       <tr>
       <td><?php  echo $get->firstname ?></td>
       <td><?php  echo $get->lastname  ?></td>
       <td><?php  echo $get->email  ?></td>
       <td><input type='checkbox'  name='' /></td>
       <td><a href='#'><i class='fa fa-pencil'></i></a></td>
       <td><a href='#'><i class='fa fa-trash'></i></a></td>
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




