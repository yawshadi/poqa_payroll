<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/employee.php' ; ?>


  <!-- Commhr content goes here -->
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
          <h1 class="page-title">VISA MASTER LIST</h1>

        </div>
      </div>
       <!-- Breadcrumbs-->
      <ol class="mybreadcrumb">
        <li class="breadcrumb-item">Master List</li>
      </ol>
    </div>
    <hr/>

    <div class="container-fluid main_container">

    <div style="margin-top: -20px"><a href='<?php echo URLROOT.'/masterlist/visamasterlistexcel'  ?>' style='font-size:13px; background:red' class='btn btn-danger pull-right'>
      <i class='fa fa-download'></i> Download Master List</a></div>
    <br/><br/>

    <form name ="register" method = 'post'>
      <div id='placeholder'>

        <table class='table table-bordered apptables'>
          <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Passport Number</th>
            <th>Date of Birth</th>
            <th>Passport</th>
             <th>Status</th>
            <th>View Profile</th>
          </tr>
        </thead>

          <?php
            foreach ($data['basicdata'] as $get):
           ?>
           <tr>
             <td><?php echo $get->firstname   ?></td>
             <td><?php echo $get->surname   ?></td>
             <td><?php echo $get->passportnumber  ?></td>
             <td><?php echo $get->dateofbirth  ?></td>
             <td><?php echo $get->passportnumber  ?></td>
             <td>  <?php
                if($get->status == ''){
                    echo '<span style="color:red">'.'PENDING'.'</span>';
                }else{
                   echo '<span style="color:green">'.'RECRUITED'.'</span>';
                }

               ?></td>
             <td><a href='<?php echo URLROOT  ?>/pages/employeeprofile/<?php echo $get->basic_id  ?>' >View Profile</a></td>
           </tr>
         <?php endforeach ?>

        </table>

      </div>



  <!--Footer and JS directies -->
<?php require APPROOT .'/views/inc/footer.php'  ?>
