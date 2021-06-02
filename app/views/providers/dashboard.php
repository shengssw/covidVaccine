<?php

// Global variables
$provider = $data['provider'][0];
$appointments = $data['appointments']; ?>


<?php
    require 'header.php';
?>
<style>
table {
    border-collapse: collapse;
    width: 85%;
    margin-left: 260px;
}

table, th, td {
    border-top: 1px solid #f5f8f6;
    border-bottom: 1px solid #f5f8f6;
}

th, td {
    background-color: white;
    margin-left: 80px;
    padding-right:100px;
    padding-left: 10px;
    padding-top: 15px;
    padding-bottom: 15px;
    font-size: 18px;
    font-weight: 200;
    text-align: left;
}

</style>

<h2 class="sectionTitle" style="margin-left: 280px; font-size:23px">Upcoming Appointments</h2>
<div class="section">
            <?php if (sizeof($appointments) > 0) { ?>
                <table>
                <tr> <th></th> <th>Date</th> <th>Time Slot</th> <th>status</th> <th>Availablilty</th> <th>Detail</th> </tr>
                    <?php
                        $sequence = 0; 
                        foreach ($appointments as $appointment) {
                        $today = date("Y-m-d");
                            if ($today <= $appointment->date) {
                            $sequence = $sequence +1;
                            $date = $appointment->date;
                            $timeblock = $appointment->timeblock;
                            $ava = $appointment->availability;
                            if (!empty($appointment->status)) {
                                $status = $appointment->status; 
                            } else {
                                $status = "unmatched";
                            }

                            if ($appointment->patientId) {
                                $patientId = $appointment->patientId;
                            } else {
                                $patientId = NULL;
                            };
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
                            <tr> <td style="padding-left: 20px;"><?php echo $sequence; ?></td>
                                <td><?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?></td> 
                                <td><?php echo htmlspecialchars($timeslot, ENT_QUOTES, 'UTF-8');?> </td> 
                                <td><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($ava, ENT_QUOTES, 'UTF-8'); ?></td> 
                                <td> <?php if(is_null($patientId)==false) {?> 
                                    <a href="<?php echo URLROOT. "/providers/singleApp/".$patientId."/".$appointId?>"><i class="pe-7s-angle-right-circle"></i></a>
                                    <?php } ?></td>
                            </tr>
                    <?php }} ?>   
                </table>

            <?php } ?>

    </div>

   
	
		
 <!--   Core JS Files   -->
        <script src=" <?php echo URLROOT; ?>/public/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
        <script src="<?php echo URLROOT; ?>/public/assets/js/bootstrap.min.js" type="text/javascript"></script>

        <!--  Checkbox, Radio & Switch Plugins -->


        <!--  Google Maps Plugin    -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>



        <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->


        </body>
</html>