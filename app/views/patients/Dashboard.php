<?php
    require APPROOT . '/views/includes/header.php';
?>

<?php

echo "this is the patient's dashboard!!";

// Global variables
$patient = $data['patient'][0];
$appointments = $data['appointments'];
echo "The patient is " .$patient->name; ?>

<a href="<?php echo URLROOT . "/patients/preference/" . $patient->patientId ?>"> Preference </a>

<div class="section">
        <?php if (sizeof($appointments) > 0) { ?>
            <table>
                <tr> <th>Date</th> <th>Time Slot</th> <th>Status</th> <th>Action</th></tr>
                <?php foreach ($appointments as $appointment) {
                    $date = $appointment->date;
                    $timeblock = $appointment->timeblock;
                    $status = $appointment->status;
                    $appointId = $appointment->appointId;
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
                    <tr> <td><?php echo $date ?></td> <td><?php echo $timeslot; ?> </td> <td><?php echo $status; ?></td>  
                    <td> <?php if ($status == "pending") {?>  
                        <form action="<?php echo URLROOT . "/patients/AcceptPatientAppointment/" . $patient->patientId ."/". $appointId ?>" method="POST">
                            <input type="submit" name="accept" value="Accept" class="sectionButton">
                        </form>
                        <form action="<?php echo URLROOT . "/patients/declinePatientAppointment/" . $patient->patientId ."/". $appointId ?>" method="POST">
                            <input type="submit" name="decline" value="Decline" class="sectionButton">
                        </form>
                        <?php } else if ($status =="accepted") { ?>
                            <form action="<?php echo URLROOT . "/patients/CancelPatientAppointment/" . $patient->patientId ."/". $appointId ?>" method="POST">
                            <input type="submit" name="cancel" value="Cancel" class="sectionButton">
                            </form> 
                        <?php } ?>
                    </td></tr>
                <?php } ?>   
            </table>

        <?php } ?>
        

    </div>


