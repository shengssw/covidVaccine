
<html lang="en">


<head>

    <meta charset="utf-8" />


    <link rel="icon" type="image/png" href="assets/img/new_logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


    <title>Admin</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="../patient/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="../patient/assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="../patient/assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <link href="../patient/assets/css/table.css" rel="stylesheet">

    <link href="../patient/assets/css/animation.css" rel="stylesheet">



    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../patient/assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="../patient/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
   <!-- <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>-->

    <script src="../patient/assets/modals/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../patient/assets/modals/bootstrap.min.js" ></script>

    <link href="../patient/assets/css/custom.css" rel="stylesheet"/>

</head>


<body>
<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-5.jpg">

        <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->


        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="" class="simple-text">
                    Hello  <?php echo $_SESSION['admin_name'] ?>
                </a>
            </div>

            <ul class="nav">
                <li class="<?php if($current_file=="dashboard.php") echo "active" ?>">
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="<?php if($current_file=="hospital_section.php") echo "active" ?>">
                    <a href="hospital_section.php">
                        <i class="pe-7s-portfolio"></i>
                        <p>Add Appointment</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">

<?php
include '../patient/uppernav.php';
?>