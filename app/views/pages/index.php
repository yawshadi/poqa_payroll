

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
      <!-- Bootstrap CSS-->
      <link rel="stylesheet" href="<?php echo URLROOT ?>/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
      <!-- theme stylesheet-->
      <link rel="stylesheet" href="<?php echo URLROOT ?>/css/style.default.css" id="theme-stylesheet">
      <!-- Custom stylesheet - for your changes-->
      <link rel="stylesheet" href="<?php echo URLROOT ?>/css/custom.css">
      <!-- Favicon-->
      <link rel="shortcut icon" href="<?php echo URLROOT ?>/img/favicon.png">
      <!-- Font Awesome CDN-->
      <!-- you can replace it by local Font Awesome
         <script src="https://use.fontawesome.com/99347ac47f.js"></script> -->
      <link rel="stylesheet" href="css/font-awesome.min.css">
      <!-- Font Icons CSS -->
      <link rel="stylesheet" href="css/icons.css">
      <!-- Tweaks for older IEs-->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
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
                  <div class="col-lg-6" style="background:#fff; border-right:1px solid #883002">
                     <div id="content" align='center'>
                        <img src="<?php echo URLROOT ?>/img/vamed.png" alt="Vamed">
                     </div>
                  </div>

				 <!-- Form Panel    -->
                  <div class="col-lg-6 bg-white">
                     <div class="form d-flex align-items-center">
                        <div class="content">
                            <?php
                                if(isset($data['message'])){
                                    echo "<p class='loginmessage'>" . $data['message'] . "</p>";
                                }
                            ?>
                           <form id="login-form" method="post" action="/">
                              <div class="form-row">
                                 <div class="form-group col-md-12">
                                    <label for="email">Email Address</label>
                                    <input type="text" required class="form-control" name="email" placeholder="Email Address">
                                 </div>
                                 <div class="form-group col-md-12">
                                    <label for="password">Password</label>
                                    <input type="password" required class="form-control" name="password" placeholder="Password">
                                 </div>
                              </div>
                              <button style='background:#883002' id="login" name='login' type='submit' class="btn btn-primary">Login</button>
                           </form>

                        </div>
                     </div>
                  </div>
				  <!-- End of Form Panel -->

			</div>
            </div>
         </div>
      </div>
      <!-- Javascript files-->
      <script src="<?php echo URLROOT ?>/js/bootstrap.min.js"></script>
      <script src="<?php echo URLROOT ?>/js/jquery.cookie.js"></script>
      <script src="<?php echo URLROOT ?>/js/jquery.validate.min.js"></script>
      <script src="<?php echo URLROOT ?>/js/front.js"></script>
   </body>
</html>
