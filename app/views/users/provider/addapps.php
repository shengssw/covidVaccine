<?php
session_start();
include('../../../config/config.php');



if(!isset($_SESSION['providerId'])){
    header("Location: /covidVaccine/app/views/users/login.php");
}

if (isset($_REQUEST['num'])){
$providerId =  (int) $_SESSION['providerId'];

$current_file = basename($_SERVER['PHP_SELF']);

$date = stripslashes($_REQUEST['apptDate']);
$timeblock = (int) $_POST['timeblock'];
$num= (int) $_POST['num'];
$date = mysqli_real_escape_string($connection,$date);

$quer = "select max(appointId) m from appointment";
$role = mysqli_query($connection,$quer);
$row = mysqli_fetch_assoc($role);
$appid = $row['m'] + 1;

$ttable = $connection->prepare("WITH T AS (SELECT patientID, address, distancepreference
FROM Patient 
where patientID not in (
Select patientID
from patientAppointment
where status = 'pending' or status = 'accepted' or status = 'vaccinated') and patientID in (
select patientID
from Timepreference
where WEEKDAY(?) = day and timeblock = ?
))

select patientID
from T natural join address
where distancepreference >= (6371 
* acos(cos(radians((select latitude from address where address = 
(select address from provider where providerid = ?))) 
* cos(radians(latitude)) 
* cos(radians(longitude)) 
- radians((select longitude from address where address 
= (select address from provider where providerid = ?)))
+ sin(radians((select latitude from address where address 
= (select address from provider where providerid = ?)))) * sin(radians(latitude)))))
"); 
$ttable -> bind_param('siiii', $date, $timeblock, $providerId, $providerId, $providerId);
$ttable ->execute();
$run = $ttable->get_result();
confirm_query($run);
$count = mysqli_num_rows($run);


for ($i = 0; $i <= $num; $i++) {
    $query = "INSERT into `appointment` 
    VALUES ($appid + $i, $providerId, '$date', $timeblock, 1)";
    $result = mysqli_query($connection,$query);


}

if($result){
    $j = 0;
    while ($row = mysqli_fetch_array($run) and $j <= $num) {
        $query2 = "INSERT INTO patientAppointment
        $id = (int) {$row['PatientID']};
        value($j + $appid, $id, curtime(), 
        DATE_ADD(curtime(), INTERVAL 2 DAY), null, 'pending')";
        $result2 = mysqli_query($connection,$query2);
        $j++;
    }
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


