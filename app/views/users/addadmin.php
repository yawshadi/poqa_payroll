<?php require APPROOT .'/views/inc/header.php';  ?>
<?php require APPROOT .'/views/inc/side_nav/user.php' ; ?>


  <!-- Commhr content goes here -->
  <div class="content-wrapper">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
          <h1 class="page-title">USER ACCOUNT SETTING</h1>

        </div>
      </div>
       <!-- Breadcrumbs-->
      <ol class="mybreadcrumb">
        <li class="breadcrumb-item">Account setting</li>
      </ol>
    </div>

    <div class="container-fluid main_container">

<?php if(isset($data['messsagedata'])): ?>
<div  class="<?php  echo $data['class']  ?>"><?php  echo $data['messsagedata']  ?></div>
<?php endif; ?>

    <form name ="register" method = 'post'>
      <div id='placeholder'>
      <div class="row" id="">
                                 <div class="col-lg-12">

                <div>

                        <div class="row">
                            <div class="col-lg-6">

                                <div class="form-group">

                               <input id="firstname" type="text" name="firstname" placeholder="Firstname"
                                 class="form-control input-sm " >
                                </div>
                                <div class="form-group">

                                <input id="lastname" type="text" name="lastname" placeholder="Lastname"
                                class="form-control" >
                                </div>

                               <div class="form-group">

                                    <input id="email" type="email" name="email" placeholder="Email" class="form-control"/>

                                </div>

                                <div class="form-group">

                                     <input id="telephone" type="text" name="telephone" placeholder="Telephone" class="form-control"/>

                                 </div>

                                 <div class="form-group">

                                   <select class='form-control bom' name='company'>
                                    <option value=''>Select Company</option>
                                    <?php
                                     foreach($data['companies'] as $get):
                                     ?>
                                     <option value='<?php echo $get->companyid   ?>'><?php echo $get->companyname   ?></option>
                                     <?php
                                   endforeach;
                                     ?>
                                    </select>


                                  </div>

                                  <div class="form-group">

                                    <select class='form-control bom' name='parent'>
                                     <option value=''>Parent User ?</option>
                                      <option>Yes</option>
                                      <option>No</option>
                                     </select>


                                   </div>

                                <div class="form-group">

                                    <select class='form-control' name='role'>

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


                                  </select>

                                 </div>

                                  <div class="form-group">

                                 <input id="password" name="password" type="password" placeholder="Password" class="form-control"/>

                                </div>

                                <div class="form-group">

                                    <input id="confirmpassword" name="confirmpassword" type="password" placeholder="Confirm Password"
                                    class="form-control" />

                                </div>

                            </div>

                            <div class="col-lg-12">
                                <div><span style="color:red"></span></div>
                                <div class="form-group">
                              <button name='adduser'  type="submit" class="btn btn-custom">Create Account</button>
                                </div>
                            </div>

                        </div>



                </div>

        </div>
    </div>
      </div>
      </form>


    </div>


<?php require APPROOT .'/views/inc/footer.php'  ?>
