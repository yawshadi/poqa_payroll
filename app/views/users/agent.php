<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/side_nav/user.php' ; ?>


  <!-- Commhr content goes here -->
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
          <h1 class="page-title">AGENT REGISTRY SETTING</h1>

        </div>
      </div>
       <!-- Breadcrumbs-->
      <ol class="mybreadcrumb">
        <li class="breadcrumb-item"><?php echo strtoupper($data['status']) ?> AGENTS REGISTRY</li>
      </ol>
    </div>

    <div class="container-fluid main_container">



    <form name ="register" method = 'post'>
      <div id='placeholder'>

        <table class='ui celled striped table apptables'>
          <thead>
          <tr>
            <th>Company</th>
            <th>Principal Activity</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>Edit</th>
          </tr>
        </thead>

          <?php
            foreach ($data['compdata'] as $get):
           ?>
           <tr>
             <td><?php echo $get->companyname   ?></td>
             <td><?php echo $get->principalactivity   ?></td>
             <td><?php echo $get->email   ?></td>
             <td><?php echo $get->telephone  ?></td>
             <td><a href='<?php echo URLROOT.'/pages/companyprofile/'.$get->companyid ?>'>View</a></td>
           </tr>
         <?php endforeach ?>

        </table>

      </div>



  <!--Footer and JS directies -->
<?php require APPROOT .'/views/inc/footer.php'  ?>
