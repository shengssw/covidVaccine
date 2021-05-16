<?php
session_start();
include('../../../config/config.php');



if(!isset($_SESSION['providerId'])){
    header("Location: /covidVaccine/app/views/users/login.php");
}

if (isset($_REQUEST['num'])){
$providerId =  (int) $_SESSION['providerId'];
echo $providerId;
$current_file = basename($_SERVER['PHP_SELF']);

$date = stripslashes($_REQUEST['apptDate']);
$timeblock = (int) $_POST['timeblock'];
$num= (int) $_POST['num'];
$date = mysqli_real_escape_string($connection,$date);

$quer = "select max(appointId) m from appointment";
$role = mysqli_query($connection,$quer);
$row = mysqli_fetch_assoc($role);
$appid = $row['m'] + 1;

$query = "INSERT into `appointment` 
VALUES ($appid, $providerId, '$date', $timeblock, $num)";
$result = mysqli_query($connection,$query);
if($result){
        echo("Appointments added to our database successfully");
    } else {
        echo("add failed");
    }

}

?>


    <?php include('header.php'); ?>

    <div class="container">



<form class="well form-horizontal" method="post"  id="user_form">
    <fieldset>
        <!-- Form Name -->
        <h3 style="text-align: center">Add appointments</h3>

        <!-- Text input first name-->

        <div class="form-group">
            <label class="col-md-4 control-label">Appointment Date</label>
            <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"></span>
                    <input name="apptDate" placeholder="Date" class="form-control"  type="date" id="dobfield" onchange="getAge()">
                </div>
                <div class="registrationFormAlert" id="divCheckAge">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Appointment Time</label>
            <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon">
                    <select name="timeblock" class="form-control selectpicker" >
                        <option value=" " >Select the time block </option>
                        <option>1</option>
                        <option >2</option>
                        <option >3</option>
                        <option >4</option>
                        <option >5</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="form-group">
                <label class="col-md-4 control-label">Number of appointments</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"></i></span>
                        <input name="num" id="loc" placeholder="Enter the number" class ="form-control" type="text">
                    </div>

                </div>
            </div>
            
        </div>

 


        <div class="form-group" >
                <label class="col-md-4 control-label"></label>
                <div class="col-md-4">
                    <button type="submit" id="button" class="btn" name="sign_up" >Submit</button>
                </div>
            </div>


    </fieldset>
</form>
</div>


