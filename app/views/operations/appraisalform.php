<style>
.btn-link{
  background-color: white !important;
  color: black !important;

}
</style>

<script>

  const urlroot = marketplacecfg.urlroot;
$('#reportedbycc').SumoSelect({search: true, okCancelInMulti: true});

$('.newdepartment').change(function(){

      var compvalue  = $('#compvalue').val();
      var department = $(this).val();
      var postdata = {compvalue:compvalue, department:department};
      var ajaxurl =  urlroot + '/ajax/positiondata';

      $('#newposition').html('');

      $.ajax({
          type: "POST",
          url: ajaxurl,
          data : postdata,
          beforeSend: function () {
              $.blockUI();
          },
          success: function (json) {

              var data = JSON.parse(json);
              $('#newposition').append('<option>' + 'Select Position' + '</option>');
              for (var key in data) {
                  if (data.hasOwnProperty(key)) {

                    $('#newposition').append('<option>' + data[key].positionname + '</option>');
                  }
              }

          },
          complete: function () {
              $.unblockUI();
          },
          error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.status + " " + thrownError);
          }
      });
  })
</script>

<?php
if($data['empcount'] > 0){
?>


<form method='post' enctype="multipart/form-data">
  <input type='hidden' name='employeeid'    value='<?php echo  $data['empdata']->basic_id ?>'   />
    <input type='hidden' name='compval' id='compvalue'    value='<?php echo  $data['empdata']->company   ?>'   />
<table class='table'>
  <tr>
  <td>Employee Name</td>
  <td><?php echo $data['empdata']->fullname   ?></td>
  </tr>

  <tr>
  <td>Company</td>
  <td><?php echo $data['empdata']->company   ?></td>
  </tr>

  <tr>
  <td>Department</td>
  <td><?php echo $data['empdata']->department   ?></td>
  </tr>

  <tr>
  <td>Position</td>
  <td><?php echo $data['empdata']->position   ?></td>
  </tr>
  </table>

  <div id="accordion">
  <?php 
  $c=1;
  foreach(Appraisal::section() as $section):
  ?>
  <div class="">
        <div class="card-header" id="headingOne">
          <h5 class="mb-0">
            <button type='button' class="btn btn-link" data-toggle="collapse" data-target="#<?= $section->sectionid.'xyx'?>" aria-expanded="true" aria-controls="collapseOne">
            <?= $c.'. '.$section->sectiontext?>
            </button>
          </h5>
        </div>

        <div id="<?= $section->sectionid.'xyx'?>" class="collapse <?=($section->sectionid==1)?'show':''?>" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="card-body">
         <?= $section->description ?>

      <table class='table'>
        <?php
          foreach(Appraisal::sectionQuestions($section->sectionid) as $questions):
        ?>
         <tr>
         <td ><?= $questions->question ?></td>
         </tr>
         <tr>
         <td> 
                    <!-- Default inline 1-->
            <?php 
             for($i=1; $i<= $section->scale; $i++): 
            ?>
            <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" class="custom-control-input" value='<?= $i?>' id="<?= $questions->questionid.'-'.$i?>" name="<?= $questions->questionid?>">
            <label class="custom-control-label" for="<?= $questions->questionid.'-'.$i?>"> <?= $i; ?> </label>
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

  <table class='table'>
  <tr>
  <td>Attach Document</td>
  <td><input type="file"  name="assetdoc"/></td>
  </tr>
    <tr>
    <td></td>
    <td><button type='submit' name='submitappraisal' style='font-size:9px' class='btn btn-primary'>
    <i class='fa fa-plus-circle'></i> Submit</button></td>
    </tr>

</table>
</form>
<?php
}else{
  echo '<h3>Sorry. No Records Found !!!</h3>';
}
 ?>
