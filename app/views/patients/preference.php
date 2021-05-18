<?php
    require APPROOT . '/views/includes/header.php';
?>

<?php

    // Global variables
    $distance = $data['distance']->distancepreference;
    $timePreferences = $data['timePreferences'];
    $patientId = $data['patientId'];
 ?>

<div class="container">
    <h1 class="pageTitle"> Preference</h1>

    <h2 class="sectionTitle">Distance</h2>
    <p class="sectionNoti">You can edit your preferred distance for vaccination location here (in miles).</p>
    <div class="section">
        <h3 style="font-size: 18px; font-weight:200;">Your Currenr Distance Preference: <?php echo $distance; ?> mile(s)</h3>   
        <form action="<?php echo URLROOT . "/patients/updateDistance/" . $patientId ?>" method="POST">
            <label for="distance" style="font-size: 18px; font-weight: 200;"> Max Distance:</label>
            <input type="text" id="distance" name="distance" style="font-size: 18px;padding:10px; border-radius:10px; border: none; margin-left: 10px;"><br><br>
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
