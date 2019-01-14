<style >
tr, td{
  padding:2px
}
</style>


<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/taskmenu.php' ; ?>


<div class="content-wrapper">

     <div style='padding-left:20px; color:#7F400B'><h3>TASK OVERVIEW</h3></div>
     <hr/>
    <div class="container-fluid main_container">

      <div id='placeholder' style='margin-top:-30px'>
      <form method="post">
      <div class="row" style="margin-bottom:20px">

      <div class="col-lg-12 col-md-12 col-sm-12">
        <a href="#">
        <div class="card">
        <div class="container">
          <br/>

            <table width='100%'>
            <tr>
              <td width='' >
              <span style='font-size:15px; font-weight:700; color: #800800'>TASK HEADLINE</span></td>
            </tr>
          </table>
          <br/>
          <div>

          </div>

        </div>
        </div>
        </a>
      </div>
    </form>

    </div>

    <?php
      if(isset($data['users'])):
     ?>

      <div class="row" style="margin-bottom:20px">

      <div class="col-lg-5 col-md-5 col-sm-5">
        <h5 style='color:#800800'>Task Details</h5>

        <table class='table table-bordered'>
          <tr>
           <td width='20%'>Taskname</td>
           <td><?php  echo $data['details']->taskname  ?></td>
          </tr>

          <tr>
           <td width='20%'>Status</td>
           <td> <?php if($data['taskstatus'] == 0){
               echo '<span style="color:orange">Active</span>';
           }elseif($data['taskstatus'] == 1){
               echo '<span style="color:green">Complete</span>';
           }elseif($data['taskstatus'] == 2){
               echo '<span style="color:red">Incomplete</span>';
           }
           ?></td>
          </tr>
          <tr>


          <tr>
           <td>Start Date</td>
           <td><?php  echo $data['details']->startdate  ?></td>
          </tr>

          <tr>
           <td>End Date</td>
           <td><?php  echo $data['details']->enddate  ?></td>
          </tr>

          <tr>
           <td>Description</td>
           <td><?php  echo $data['details']->description  ?></td>
          </tr>

        </table>

         <h5 style='color:#800800'>Task Document(s)</h5>
        <table class='table table-bordered'>
          <tr style="font-weight:700; font-size:15px">
            <td>Document</td>
            <td>Date</td>
            <td align='center'>Download</td>
          </tr>

          <?php
          foreach($data['doc'] as $get){
          ?>

          <tr>
            <td><?php echo  $get->name    ?></td>
            <td><?php echo  $get->docdate    ?></td>
            <td align='center'><a target='_blank' href='<?php echo URLROOT.'/uploads/'. $get->newname ?>'><i class='fa fa-download'></i> </a></td>
          </tr>
          <?php
            }
           ?>
        </table>

         <h5 style='color:green'>Assigned User(s)</h5>
        <table class='table table-bordered'>
          <?php
          foreach($data['asusers'] as $ass):
          ?>
          <tr>
           <td width='20%'><i class= 'fa fa-user'></i> <?php  echo $ass->firstname. ' '. $ass->surname. ' - '.$ass->role ?></td>
          </tr>
          <?php
        endforeach;
           ?>
        </table>

      </div>
      <div class="col-lg-7 col-md-7 col-sm-7">
      <form method='post'>
      <input type='hidden' value ='<?php  echo $data['details']->id  ?>' name='taskid' />
      <table>
        <tr>
         <td width='80%'><h5 style='color:#800800'>Users to Assign</h5></td>
         <td width='20%'><button type='submit' class="ui primary button" name='assigntask' style='width:200px'>Assign User</button></td>
        </tr>
      </table>
      <table class='ui celled striped table'>
      <thead>
       <tr style="font-weight:700">
         <th><input type='checkbox'></th>
         <th>Name</th>
         <th>Email</th>
         <th>Telephone</th>
       </tr>
     </thead>
       <?php
        foreach ($data['users'] as $get):
        ?>
        <tr>
           <td><input type='checkbox' name='chktask[]' value='<?php  echo $get->uid ?>'></td>
          <td><?php  echo $get->firstname.' '.$get->surname  ?></td>
          <td><?php  echo $get->email ?></td>
          <td><?php  echo $get->telephone   ?></td>
        </tr>
        <?php
        endforeach;
         ?>
      </table>
    </form>

      </div>

      </div>
      <?php
      endif;
      ?>


    </div>   <!-- End of Placeholder -->

    </div>
    </div>


  <!--Footer and JS directies -->

  <?php require APPROOT .'/views/inc/footer.php'  ?>

  <script type='text/javascript'>
  // $('.ui.search.dropdown')
  // .dropdown({
  //   fullTextSearch: true,
  //   debug: true
  // });



$('.tasklist').SumoSelect({search: true, searchText: 'Enter here.'});

  $('#searchtask').click(function(){
    var taskid =$('#taskname').dropdown('get value');
  })

   </script>
