<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title><?php echo SITENAME   ?></title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <meta name="theme-color" content="#7568E0">
      <meta name="robots" content="all,follow">
      <link rel="stylesheet" href="<?php echo URLROOT ?>/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo URLROOT ?>/css/style.default.css" id="theme-stylesheet">
      <link rel="stylesheet" href="<?php echo URLROOT ?>/css/custom.css">
      <link rel="shortcut icon" href="<?php echo URLROOT ?>/img/favicon.png">
      <link rel="stylesheet" href="css/font-awesome.min.css">
      <link rel="stylesheet" href="css/icons.css">

      <style>
         #content {
         width: 55%;
         margin-left: auto;
         margin-right: auto;
         position: relative;
         top: 50%;
         transform: translateY(-50%);
         }
      </style>
   </head>
   <body>
      <div class="page login-page">
         <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
               <div class="row">
                  <!-- Logo & Information Panel-->
                  <div class="col-lg-3" style="background:#fff; border-right:1px solid #883002">
                     <div id="content">

                        <img src="<?php echo URLROOT ?>/img/plogo.png" alt="Commehr" style="height: 100%; width: 100%;">
                     </div>
                  </div>

				 <!-- Form Panel    -->
                  <div class="col-lg-9 bg-white">
                     <div class="form d-flex align-items-center">
                        <div class="content" >
                            <h3 style='color:#883002'>LABOR POWER AGENT REGISTRATION</h3>
                            <br/>
                           <form id="login-form" method="post">
                              <div class="form-row" style="padding:-20px">
                                 <div class="form-group col-md-12">
                                    <input type="text" required class="form-control" name="company" placeholder="Name of Company">
                                 </div>
                                 <div class="form-group col-md-12">
                                    <input type="text" required class="form-control" name="activity" placeholder="Principal Activity">
                                 </div>

                                 <div class="form-group col-md-12">
                                    <input type="text" required class="form-control" name="country" placeholder="Country">
                                 </div>

                                 <div class="form-group col-md-12">
                                    <input type="text" required class="form-control" name="postal" placeholder="Postal Address">
                                 </div>

                                 <div class="form-group col-md-12">
                                    <input type="email" required class="form-control" name="email" placeholder="Email Address">
                                 </div>



                                 <div class="form-group col-md-12">
                                    <input type="text" required class="form-control" name="telephone" placeholder="Telephone">
                                 </div>

                                 <div class="form-group col-md-12">
                                    <input type="text" required class="form-control" name="aname" placeholder="Name of Athorized Person ">
                                 </div>

                                 <div class="form-group col-md-12">
                                    <input type="text" required class="form-control" name="atelephone" placeholder="Telephone of Athorized Person">
                                 </div>

                                 <div class="form-group col-md-12">
                                    <input type="text" required class="form-control" name="manpower" placeholder="Manpower Capacity">
                                 </div>


                              </div>
                              <button style='background:#883002' id="login" name='registeragent' type='submit' class="btn btn-primary">Continue</button>
                           </form>

                        </div>
                     </div>
                  </div>
				  <!-- End of Form Panel -->

			</div>
            </div>
         </div>
      </div>

   </body>
</html>
