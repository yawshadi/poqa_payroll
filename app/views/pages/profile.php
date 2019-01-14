<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/blank.php' ; ?>


  <!-- Commhr content goes here -->
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
          <h1 class="page-title">EDIT PROFILE  SETTING</h1>

        </div>
      </div>

    </div>
    <hr/>

    <div class="container-fluid main_container">




    <form name ="register" method = 'post'>
      <div id='placeholder'>
        <div class="col-lg-6">
        <?php if(isset($data['message'])): ?>
          <div class='alert alert-success'><?php echo $data['message']  ?></div>
        <?php endif;   ?>

        <table class='table table-bordered' width=800px>
          <tr>
            <td>Firstname</td>
            <td><?php echo $data['userdata']->firstname  ?></td>
          </tr>
          <tr>
            <td>Lastname</td>
            <td><?php echo $data['userdata']->surname  ?></td>
          </tr>
          <tr>
            <td>Email</td>
            <td> <?php echo $data['userdata']->email  ?></td>
          </tr>
          <tr>
            <td>Telephone</td>
            <td><?php echo $data['userdata']->telephone ?></td>
          </tr>

        </table>
      </div>


      <div class="col-lg-6">
      <?php if(isset($data['message'])): ?>
        <div class='alert alert-success'><?php echo $data['message']  ?></div>
      <?php endif;   ?>

      <table class='table table-bordered' width=800px>
        <tr>
          <td>Password</td>
          <td><input id="password" type="password" name="password"
            class="form-control input-sm " value='' ></td>
        </tr>

        <tr>
          <td>Confirm Password</td>
          <td>  <input id="confirmpassword" type="password" name="confirmpassword"
            class="form-control" value='' ></td>
        </tr>

      <tr>
        <td></td>
        <td>
          <button type='button' class="ui primary button" uid='<?php echo $data['userdata']->uid ?>' id='updatepassword'>Change Password</button>
        </td>
    </tr>


      </table>
    </div>




      </div>
      </form>


    </div>


<?php require APPROOT .'/views/inc/footer.php'  ?>
