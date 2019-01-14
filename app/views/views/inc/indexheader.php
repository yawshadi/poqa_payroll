<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo SITENAME  ?></title>


    <!-- bootstrap 4 requires popper to be loaded before bootstrap -->
    <script src="<?php echo URLROOT ?>/vendor/twitter/bootstrap/assets/js/vendor/popper.min.js"></script>

    <link href="<?php echo URLROOT ?>/vendor/fortawesome/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URLROOT ?>/vendor/twitter/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/css/AdminLTE.css" rel="stylesheet">
    <link href="<?php echo URLROOT ?>/vendor/driftyco/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT ?>/vendor/datatables/datatables/media/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT ?>/css/dataTables/css/rowReorder.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT ?>/css/dataTables/css/responsive.dataTables.min.css"/>
    <link href="<?php echo URLROOT ?>/css/style.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo URLROOT ?>/vendor/components/jqueryui/themes/base/jquery-ui.css"/>
    <!--<link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>-->
    <link href="<?php echo URLROOT ?>/vendor/etdsolutions/sumoselect/sumoselect.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?php echo URLROOT ?>/img/favicon.png">

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

<body class="fixed-nav sticky-footer bg-white" id="page-top">
<!-- Navigation-->

<nav class="navbar navbar-expand-lg navbar-dark  fixed-top" id="mainNav" style="background:#883002">

    <a class="navbar-brand" href="/"> <img  class="app-logo" alt="">BRAIN HOUSE</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive" >
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion" style="background:#fff">

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="">
                <div class="nav-link user_profile">
                </div>
            </li>