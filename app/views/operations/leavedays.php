<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/config.php' ; ?>

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
          <h1 style='color:#FB6600; font-weight:700' class="page-title">LEAVE DAYS SETUP</h1>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>

    </div>


   <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Current Year Leave</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Accumulated Leave</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div class="row" style="margin-bottom:20px">
     <div class="col-lg-5 col-md-5 col-sm-12">
     <div class='card'>
     <form method='post'>
     <table class='table'>
         <tr>
         <td>Total Leave Days</td>
         <td><input required type="text" value="<?=isset($data->leavedays)?$data->leavedays:''?>" class="form-control bom" name="leavedays" placeholder="Total Number of Days"/></td>
         </tr>
         <input type="hidden" value="<?=isset($data->daysid)?$data->daysid:''?>" name='daysid'/>
         <tr>
         <td></td>
         <td align='right'><button type='submit' name='saveleavedaysbtn' style='font-size:12px' class='btn btn-primary'>
         <i class='fa fa-plus-circle'></i><?=isset($data->daysid)?'Update':'Save'?></button>
         <?php 
         if(isset($data->daysid)):
          ?>
         <a href='<?= URLROOT ?>/operations/leavedays'><button type='button' name='' style='font-size:12px' class='btn btn-primary'>
         <i class='fa fa-plus-circle'></i>back</button></a>
         <?php 
         endif;
         ?>
         </td>
         </tr>
         </table>
         </form>
     </div>
      </div>

    <div class="col-lg-7 col-md-7 col-sm-7">
      <div class='card'>
      <div class="container">
      <br/>
      <div align='center'>

      <table  class='table table-bordered table-condensed holidaytable' style='font-size:12px'>
       <thead>
       <tr>
       <td>Total Leave Days</td>
       <td>Edit </td>
       <td>Delete </td>
      </tr>
      </thead>

       <?php
       $tleave = 0;
        foreach(Leavedays::listAll() as $get):
          $tleave=$get->leavedays;
       ?>
       <tr>
       <td><?php echo $get->leavedays   ?></td>
       <td><a href='<?php echo URLROOT  ?>/operations/leavedays/<?php echo $get->daysid  ?>' ><i class='fa fa-pencil'></i></a></td>
       <td><a href='#' class='deleteleaveday' daysid='<?php echo $get->daysid  ?>'><i class='fa fa-trash'></i></a></td>       </tr>
       <?php
       endforeach;
       ?>
      </table>
      </div>
     </div>
     </div>
    </div>
  </div>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  <div class="row">
  <?php
    $doublearray = array_chunk(Employee::listAll(),10);
      foreach($doublearray as $double):
    ?>
  <div class="col-md-4">
  <table id='success'  class='table datatable table-bordered table-condensed'>
  	<thead>
	   <tr style='font-weight:700'>
  		<td>Employee</td>
  		<td>Accumulated Leave</td>
     </tr>
      </thead>
     <?php     
      foreach($double as $get):
		    $id=$get->basic_id;
     ?>
     <tr>
     	<td width='45%'><?php echo $get->fullname ?><br/>
        <span style='font-size:10px; color:red'><?php echo $get->position ?></span>
      </td>
  		<td><input type='text' employeeid = '<?php echo $get->basic_id ?>'  value="<?= ($get->accumulatedleave=='')?$tleave:$get->accumulatedleave ?>" field='accumulatedleave' class='form-control accumulated'/></td>
     </tr>
     <?php
	   endforeach;
     ?>
  </table> 
  </div>
    <?php endforeach; ?>
  </div>
  </div>
  </div>

    </div>   <!-- End of Placeholder -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>
