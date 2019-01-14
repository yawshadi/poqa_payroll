<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/side_nav/user.php' ; ?>


  <!-- Commhr content goes here -->
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
          <h1 class="page-title">EDIT ACCOUNT SETTING</h1>

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
            <td><input id="firstname" type="text" name="firstname" placeholder="Firstname"
              class="form-control input-sm " value='<?php echo $data['userdata']->firstname ?>' ></td>
          </tr>

          <tr>
            <td>Lastname</td>
            <td>  <input id="lastname" type="text" name="lastname" placeholder="Lastname"
              class="form-control" value='<?php echo $data['userdata']->surname ?>' ></td>
          </tr>

          <tr>
            <td>Email</td>
            <td>  <input id="email" type="text" name="email" placeholder="Email"
               class="form-control" value='<?php echo $data['userdata']->email ?>' /></td>
          </tr>

          <tr>
            <td>Telephone</td>
            <td><input id="telephone" type="text" name="telephone" placeholder="Telephone"
                 class="form-control" value='<?php echo $data['userdata']->telephone ?>' /></td>
          </tr>



          <tr>
            <td>Role</td>
            <td>  <select class='form-control' name='role'>
                <option><?php echo $data['userdata']->role ?></option>
                <option value=''>Pick a role</option>
                <option>Administrator</option>
                <option>HR Manager</option>
                <option>Payroll Manager</option>
                <option>Site Manager</option>
                <option>Head of Admin</option>
                <option>Data Entry Clerk</option>
                <option>Expatriate</option>
                <option value='Administrator'>Managing Director</option>
                <option>IT Manager</option>


              </select></td>
          </tr>

          <tr>
            <td>Status</td>
          <td>
           <select class='form-control' name='status'>
             <option><?php echo $data['userdata']->status ?></option>
             <option>Active</option>
             <option>Locked</option>

           </select></td>
        </tr>

        <tr>
          <td></td>
          <td>
            <button type='submit' class="ui orange button" name='updateuser'>Update user</button>
            <button type='button' class="ui primary button" name='updateuser'>Change Password</button>
          </td>
      </tr>


        </table>
      </div>



      </div>
      </form>


    </div>


<?php require APPROOT .'/views/inc/footer.php'  ?>
