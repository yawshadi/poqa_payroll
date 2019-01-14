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
      <link rel="stylesheet" href="<?php echo URLROOT ?>/uploadify/uploadifive.css" />

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

      <script type="text/javascript">
          var marketplacecfg = {
              <?php
                  /*
                   * PHP 7 throws warnings about non-scalar values in constants...
                   * serialized JSVARS to compensate.
                  */
                  foreach (unserialize(JSVARS) as $jskey => $jsval){
                      echo $jskey . " : '" . $jsval . "',";
                  }
              ?>
          }
      </script>
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
                            <h3 style='color:#883002'>UPLOAD DOCUMENTS</h3>
                            <br/>
                            <span style='color:#883002; font-size:12px'>NB:We need Certificate of Incorporation and Business Registration </span>
                            <br/>
                           <form id="login-form" method="post" action="/">
                              <div class="form-row" style="padding:-20px">
                                 <div class="form-group col-md-12">
                                   <input style='font-size:10px' type=file name='businessdocs[]'  class = 'form-sontrol' id='filedoc'/>
                            </div>


                           </div>

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


      <?php require APPROOT .'/views/inc/footer.php'  ?>
      <script type="text/javascript">
      var uroot = '<?php echo URLROOT.'/pages/savebusinessdocs/'.$data ?>';

      $('#filedoc').uploadifive({
          'buttonText'  : 'BROWSE FOR BUSINESS CERTICATE',
          'buttonClass' : 'uploadifive-button',
          'auto'        : true,
          'method'      : 'post',
          'multi'       : true,
          'width'       : 450,
          'uploadScript': uroot,
          'onUploadComplete' : function(file, data) {
              window.location.href = '<?php echo URLROOT.'/pages/regsuccess' ?>'
            }
       });


      </script>

   </body>
</html>
