<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/side_nav/user.php' ; ?>


  <!-- Commhr content goes here -->
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
          <h1 class="page-title">USER REGISTRY SETTING</h1>

        </div>
      </div>
       <!-- Breadcrumbs-->
      <ol class="mybreadcrumb">
        <li class="breadcrumb-item">Mange Users</li>
      </ol>
    </div>

    <div class="container-fluid main_container">



    <form name ="register" method = 'post'>
      <div id='placeholder'>

        <table class='ui celled striped table apptables'>
          <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>Status</th>
            <th>Role</th>
            <th>Edit</th>
          </tr>
        </thead>

          <?php
            foreach ($data['users'] as $get):
           ?>
           <tr>
             <td><?php echo $get->firstname   ?></td>
             <td><?php echo $get->surname   ?></td>
             <td><?php echo $get->email   ?></td>
             <td><?php echo $get->telephone  ?></td>
             <td><?php echo $get->status  ?></td>
             <td><?php echo $get->role   ?></td>
             <td><a href='<?php echo URLROOT.'/pages/edituser/'.$get->uid ?>'>Edit</a></td>
           </tr>
         <?php endforeach ?>

        </table>

      </div>



  <!--Footer and JS directies -->
<?php require APPROOT .'/views/inc/footer.php'  ?>
