
  <!-- Header and CSS Directives-->
<?php require APPROOT .'/views/inc/header.php'  ?>
 <?php   require APPROOT .'/views/inc/side_nav/dashboard.php'  ?>
 
 <style>

.innerText {
            text-align:center;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            color:#fff;
        }

.mygridbox{
  border:0px solid red; width:100%; height:150px; background:#F57C00;
}        

p.plabel{
  color:#fff;
  font-size:21px;
}
 </style>

<body class="fixed-nav sticky-footer bg-white" id="page-top">
  <!-- Navigation-->
  <?php require APPROOT .'/views/inc/side_nav.php'  ?>

  <!-- Commhr content goes here -->
  <div class="content-wrapper">
  

    <div class="container-fluid main_container">
     
     
      <div id='placeholder'>
           	
      <div class="row">

      <div class="col-lg-3 col-md-4 col-sm-12" >
      <div class="small-box" style="background:#F57C00">
            <div class="inner">
              <p class="plabel">Administrator<br/>Dashboard<p>
            </div>
            <div class="icon">
              <i class="ion ion-social-buffer"></i>
            </div>
            <a href="customers" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>

      </div>

       
      <div class="col-lg-3 col-md-4 col-sm-12" >
      <div class="small-box" style="background:#F57C00">
            <div class="inner">
              <p class="plabel">Account<br/>Settings<p>
              
            </div>
            <div class="icon">
              <i class="ion ion-android-settings"></i>
            </div>
            <a href="settings" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>   
      </div>

      <div class="col-lg-3 col-md-4 col-sm-12" >
      <div class="small-box" style="background:#F57C00">
            <div class="inner">
              <p class="plabel">Change <br/> Password<p>
            
            </div>
            <div class="icon">
              <i class="ion ion-key"></i>
            </div>
            <a href="changeaccount" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>   
      </div>

      <div class="col-lg-3 col-md-4 col-sm-12" >
      <div class="small-box" style="background:#F57C00">
            <div class="inner">
              <p class="plabel">Reports<br/>&nbsp<p>
              
            </div>
            <div class="icon">
              <i class="ion ion-ios-compose"></i>
            </div>
            <a href="reports" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>


      <div class="col-lg-3 col-md-4 col-sm-12" >
      <div class="small-box" style="background:#F57C00">
            <div class="inner">
            <p class="plabel">Uploads<br/>&nbsp<p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cloud-upload"></i>
            </div>
            <a href="uploads" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>


      <div class="col-lg-3 col-md-4 col-sm-12" >
      <div class="small-box" style="background:#F57C00">
            <div class="inner">
              <p class="plabel">Contract <br/> Management<p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            <a href="contract" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>



     </div>  
    </div>
   

  <!--Footer and JS directies -->
  
  <?php require APPROOT .'/views/inc/footer.php'  ?>



