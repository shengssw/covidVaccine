
<html lang="en">


<head>

    <meta charset="utf-8" />


    <link rel="icon" type="image/png" href="assets/img/new_logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


    <title>Covid Appointment - Provider</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="<?php echo URLROOT; ?>/public/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="<?php echo URLROOT; ?>/public/assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="<?php echo URLROOT; ?>/public/assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <link href="<?php echo URLROOT; ?>/public/assets/css/table.css" rel="stylesheet">

    <link href="<?php echo URLROOT; ?>/public/assets/css/animation.css" rel="stylesheet">



    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo URLROOT; ?>/public/assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo URLROOT; ?>/public/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

    <script src="<?php echo URLROOT; ?>/public/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
   <!-- <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>-->

    <script src="<?php echo URLROOT; ?>/public/assets/modals/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?php echo URLROOT; ?>/public/assets/modals/bootstrap.min.js" ></script>

    <link href="<?php echo URLROOT; ?>/public/assets/css/custom.css" rel="stylesheet"/>

</head>


<body>
<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-5.jpg">

        <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->


        <div class="sidebar-wrapper">
            <div class="logo">
            <?php if(isLoggedIn()): ?>
                <a href="" class="simple-text">
                    Hello  <?php echo $_SESSION['username'] ?>
                </a>
             <?php endif; ?>
            </div>

            <ul class="nav">
                <li class="<?php if($current_file=="dashboard.php") echo "active" ?>">
                    <a href="<?php echo URLROOT; ?>/providers/dashboard">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="<?php if($current_file=="addapps.php") echo "active" ?>">
                    <a href="<?php echo URLROOT; ?>/providers/addapps">
                        <i class="pe-7s-portfolio"></i>
                        <p>Add Appointment</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>



<?php
  require 'uppernav.php';
?>