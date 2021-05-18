<?php




    session_start();
    session_unset();
    session_destroy();
    header("location: /covidVaccine/app/views/users/login.php");
    exit();



?>