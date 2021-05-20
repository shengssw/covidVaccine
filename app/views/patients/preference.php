<?php
    require APPROOT . '/views/includes/header4.php';
?>

<?php

    // Global variables
    $distance = $data['distance']->distancepreference;
    $timePreferences = $data['timePreferences'];
    $patientId = $data['patientId'];
 ?>

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

table, th, td {
    border-top: 1px solid #f5f8f6;
    border-bottom: 1px solid #f5f8f6;
}

th, td {
    padding-right: 60px;
    padding-left: 20px;
    padding-top: 20px;
    padding-bottom: 20px;
    font-size: 20px;
    font-weight: 200;
    text-align: left;
}

</style>

<div class="wrapper">

    <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-5.jpg">
        <div class="sidebar-wrapper">
            <div class="logo">
            <?php if(isLoggedIn()): ?>
                <a href="" class="simple-text">
                    Hello  <?php echo $_SESSION['username'] ?>
                </a>
            <?php endif; ?>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="<?php echo URLROOT; ?>/patients/dashboard">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class= "active">
                    <a href="<?php echo URLROOT."/patients/preference/".$_SESSION['userid']?>">
                        <i class="pe-7s-portfolio"></i>
                        <p>Preference</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container" style="margin-left:250px; background-color: white;">
        <h1 class="pageTitle"> Preference</h1>
    
        <h2 class="sectionTitle">Distance</h2>
        <p class="sectionNoti">You can edit your preferred distance for vaccination location here (in miles).</p>
        <div class="section">
            <h3 style="font-size: 18px; font-weight:200;">Your Currenr Distance Preference: <?php echo $distance; ?> mile(s)</h3>   
            <form action="<?php echo URLROOT . "/patients/updateDistance/" . $patientId ?>" method="POST">
                <label for="distance" style="font-size: 18px; font-weight: 200;"> Max Distance:</label>
                <input type="text" id="distance" name="distance" style="font-size: 18px;padding:10px; border-radius:10px; margin: 15px; border: 1px solid grey;"><br><br>
                <button class="sectionButton" type="submit"> Update</button>
            </form>
        
        </div>

    
        <h2 class="sectionTitle">Time</h2>
        <p class="sectionNoti"> You can edit your preferred time(s) for vaccination here.</p>
        <div class="section">
            <button class="sectionAddButton"> <a href="<?php echo URLROOT . "/patients/createTime/" . $patientId ?>">Add New Time</a> </button>
            <?php if (sizeof($timePreferences) > 0) { ?>
                <table>
                    <tr> <th>Weekday</th> <th>Time Slot</th> <th>Action</th> </tr>
                    <?php foreach ($timePreferences as $timePreference) {
                        $day = $timePreference->day;
                        $timeblock = $timePreference->timeblock;
                        $weekday = "";
                        $timeslot = "";
                        switch ($day) {
                            case 1:
                                $weekday = "Monday";
                                break;
                            case 2:
                                $weekday = "Tuesday";
                                break;
                            case 3:
                                $weekday = "Wednesday";
                                break;
                            case 4:
                                $weekday = "Thursday";
                                break;
                            case 5:
                                $weekday = "Friday";
                                break;
                            case 6:
                                $weekday = "Saturday";
                                break;
                            case 7:
                                $weekday = "Sunday";
                                break; } 

                        switch ($timeblock) {
                            case 1:
                                $timeslot = "8:00 AM - 12:00 PM";
                                break;
                            case 2:
                                $timeslot = "12:00PM - 4:00 PM";
                                break;
                            case 3:
                                $timeslot = "4:00 PM - 8:00 PM";
                                break;
                            case 4:
                                $timeslot = "8:00 PM - 12:00 AM";
                                break; }
                                ?>
                        <tr> <td><?php echo $weekday; ?></td> <td><?php echo $timeslot; ?> </td>  
                        <td> 
                            <form action="<?php echo URLROOT . "/patients/deleteTime/" . $patientId ."/". $timeblock. "/". $day ?>" method="POST">
                            <input type="submit" name="delete" value="Delete" class="sectionButton">
                            </form> 
                        </td></tr>
                    <?php } ?>   
                </table>

            <?php } ?>
            

        </div>
    </div>
</div>
