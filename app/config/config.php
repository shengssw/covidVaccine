<?php
    // Database parameters
    define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'password');
    define('DB_NAME', 'covid');

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(mysqli_connect_error()){
    die("Database Connection failed".mysqli_connect_error()." ".mysqli_connect_errno()." ");
}

function confirm_query($result_set){

    if(!$result_set){
        die("Database query failed");
    }
}


    //APPROOT
    define('APPROOT', dirname(dirname(__FILE__)));

    //URLROOT
    define('URLROOT', 'http://localhost:8888/covidVaccine');

    //SITENAME
    define('SITENAME', 'COVID-19 Vaccine NYC');
?>
