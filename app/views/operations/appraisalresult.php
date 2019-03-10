<?php require APPROOT . '/views/inc/header.php';?>
<?php require APPROOT . '/views/inc/operationsmenu.php';?>

<style>
tr, td{
  padding:2px
}
.form-control{
  border: 1px solid #FB6600;
  padding:2px;
  font-size:12px;
}
.btn-link{
  background-color: white !important;
  color: black !important;

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
          <h1 style='color:#FB6600; font-weight:700' class="page-title">EMPLOYEE APPRAISAL </h1>
        </div>

       <div class="col-2">
         <div style='margin-top:10px'><a target='_blank' class='btn btn-danger' style='font-size:11px' href='<?php echo URLROOT.'/uploads/'. $data['filename'] ?>'><i class='fa fa-download'></i>  Download Result </a></div>
        </div>
   </div>

      <hr/>

      <div id='placeholder'>

    </div>
<div class="row" style="margin-bottom:20px">

     <div class="col-lg-12 col-md-12 col-sm-12">

     <div class=''>

    <form method='post' enctype="multipart/form-data">
         <input type='hidden' name='employeeid'    value='<?php echo $data['empdata']->basic_id ?>'   />
           <input type='hidden' name='compval' id='compvalue'    value='<?php echo $data['empdata']->company ?>'   />
        <table class='table'>
         <tr>
         <td>Employee Name</td>
         <td><?php echo $data['empdata']->fullname ?></td>
         </tr>

         <tr>
         <td>Company</td>
         <td><?php echo $data['empdata']->company ?></td>
         </tr>

         <tr>
         <td>Department</td>
         <td><?php echo $data['empdata']->department ?></td>
         </tr>

         <tr>
         <td>Position</td>
         <td><?php echo $data['empdata']->position ?></td>
         </tr>
         </table>

         <div id="accordion">
         <?php
         $c=1;
            foreach (Appraisal::section() as $section):
            ?>
          <div class="">
         <div class="card-header" id="headingOne">
           <h5 class="mb-0">
             <button type='button' class="btn btn-link" data-toggle="" data-target="#<?=$section->sectionid . 'xyx'?>" aria-expanded="true" aria-controls="collapseOne">
             <?= $c.'. '.$section->sectiontext?>
             </button>
           </h5>
         </div>

         <div id="<?=$section->sectionid. 'xyx'?>" class="<?=($section->sectionid == 1) ? 'show' : ''?>" aria-labelledby="headingOne" data-parent="#accordion">
           <div class="card-body">
           <div class='row'> 
            <div class='col-md-4'>
           <?=$section->description?>
           </div>
           <div class='col-md-4'>
           <button style='border-radius:0px'class='btn pull-left'>Section result : <span class="badge badge-light"> <?=$data['sectionresult'][$section->sectionid]?></span></button>
           </div>
           </div>

        <table class='table'>
         <?php
        foreach (Appraisal::sectionQuestions($section->sectionid) as $questions):
        ?>
          <tr>
          <td ><?=$questions->question?></td>
          </tr>
          <tr>
          <td>
                    <!-- Default inline 1-->
            <?php
            for ($i = 1; $i <= $section->scale; $i++):
            ?>
            <div class="custom-control custom-radio custom-control-inline">
            <input type="radio"  disabled class="custom-control-input"  <?= (Appraisal::answerFromQuestion($questions->questionid,$data['empdata']->basic_id) == $i)?'checked':''?> value='<?=$i?>' id="<?=$questions->questionid . '-' . $i?>" name="<?=$questions->questionid?>">
            <label class="custom-control-label" for="<?=$questions->questionid . '-' . $i?>"> <?=$i;?> </label>
            </div>
            <?php
        endfor;
        ?>

        </td>
      </tr>
     <?php
    endforeach;
    ?>
      </table>

          </div>
        </div>
  </div>
    <?php
    $c++;
    endforeach;
    ?>

 </div>
        <div >
       
     </div>

 </form>
     </div>

      </div>
 

      </div>
      <div class="card-header" id="headingOne">
           <h5 class="mb-0">
             <button type='button' class="btn btn-link">
            Overall Result
             </button>
           </h5>
         </div>
     <div class="card-body">
      <div class='row'>
      <div class='col-md-4'>
      <ul>
       <li> 4 - EXCELLENT </li> 
       <li> 3 - GOOD </li> 
       <li> 2 - FAIR </li> 
       <li> 1 - POOR </li> 
        </ul>
        </div>
      <div class='col-md-4'>
           <button style='border-radius:0px' class='btn pull-left'> Overall result : <span class="badge badge-light"><?=$data['overall']?></span> </button>
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

  <?php require APPROOT . '/views/inc/footer.php'?>
