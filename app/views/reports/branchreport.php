<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/report.php' ; ?>

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
          <h1 style='color:#FB6600; font-weight:700' class="page-title">  BRANCH WEEKLY REPORT  </h1>
        </div>
   </div>
      
      <hr/>
     
      <div id='placeholder'>
     
      </div>




<div class="row" style="margin-bottom:20px">  


     <div class="col-lg-12 col-md-12 col-sm-12">
     <div >
     <form method='post'>
       <br/>
      <table  class='table table-bordered table-condensed' style='width:50%'>
      <tr> 
      <td>
      <select class='form-control' name='month'>
       <option><?php  echo "Select Month" ?></option>
       <?php
         $months = months();
         foreach($months as $key=>$value){
             echo '<option value='.$value.'>'.$key.'</option>';
         }
       ?>
       </select>
      </td>
      <td>
      <select class='form-control' name='year'>
        <option><?php  echo "Select Year" ?></option>
        <?php
          foreach(getYear() as $year):
        ?>
        <option><?php echo $year  ?></option>
        <?php
          endforeach;
        ?>
      </td>
      <td><button type=submit class='btn btn-danger' name='branchbtn'>Weekly Report</button></td>
      <td align='left'><button type=submit class='btn btn-danger pull-left' name='monbranchbtn'>Monthly Report</button></td>
     </tr>
      </table>
      </form>
      
      <hr/>

     
      <?php  if(isset($data['payrolldata'])){   ?>
            
  <div style='width:800px; padding:10px; height:400px; overflow-y:scroll'>
      <a href='<?php echo URLROOT  ?>/excelreport/branchweeklyexcel/<?php echo $data['month'] ?>/<?php echo $data['year'] ?>' 
       class='btn btn-warning' style='font-size:10px'> Download</a>
      <table id='success'  class='table datatable table-bordered table-condensed table-striped'>
      <thead style='font-weight:700'>
      <tr>
      <td>Branch</td>
      <td>Attendance</td>
      <td>Offering </td>
      <td>Tithe</td>
      <td>Welfare</td>
      <td>Midweek</td>
      <td>Harvest</td>
      <td>Expenses</td>
      <td>Total</td>

      </tr>
      </thead>
      <?php
      foreach($data['payrolldata'] as $get):

      ?>	
      <tr>
      <td width='10%'><?php echo $get['branchname']  ?> </td>
      <td><?php echo $get['attendance']    ?></td>
      <td><?php echo $get['offering']    ?></td>
      <td><?php echo $get['tithe']    ?></td>
      <td><?php echo $get['welfare']    ?></td>
      <td><?php echo $get['midweek']    ?></td>
      <td><?php echo $get['harvest']    ?></td>
      <td><?php echo $get['expenses']    ?></td>
      <td><?php echo $get['total']    ?></td>
      </tr>	

      <?php
      endforeach;
      ?>
  </table>	
  <?php
      }

  ?>
</div>

  
<?php  if(isset($data['totaldata'])){   ?>

      <div style='width:800px; padding:10px; height:400px; overflow-y:scroll'>
      <a href='<?php echo URLROOT  ?>/excelreport/branchmonthlyexcel/<?php echo $data['month'] ?>/<?php echo $data['year'] ?> ?>' 
       class='btn btn-warning' style='font-size:10px'> Download</a>
      <table id='success'  class='table datatable table-bordered table-condensed table-striped' width='50%'>
      <thead>
      <tr style='font-weight:700'>
      <td>No:</td>
      <td>Branch</td>
      <td>Total (GHC)</td>

      </tr>
      </thead>
      <?php
      foreach($data['totaldata'] as $key=>$get):

      ?>	
      <tr>
      <td width='10%'><?php echo $key + 1  ?> </td>
      <td><?php echo $get['branchname'];   ?></td>
      <td><?php echo $get['total'];  ?></td>
      </tr>	

      <?php
      endforeach;
      ?>
  </table>	
  <?php
      }

  ?>

  </div>

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
 