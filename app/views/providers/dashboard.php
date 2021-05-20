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
    width: 100%;
    margin-left: 260px;
}

table, th, td {
    border-top: 1px solid #f5f8f6;
    border-bottom: 1px solid #f5f8f6;
}

th, td {
    background-color: white;
    padding-right: 60px;
    padding-left: 20px;
    padding-top: 15px;
    padding-bottom: 15px;
    font-size: 18px;
    font-weight: 200;
    text-align: left;
}

</style>

<h2 class="sectionTitle" style="margin-left: 280px; font-size:23px">Active Appointments</h2>
<div class="section">
            <?php if (sizeof($appointments) > 0) { ?>
                <table>
                    <tr> <th>Date</th> <th>Time Slot</th> <th>Availablilty</th> </tr>
                    <?php foreach ($appointments as $appointment) {
                        $today = date("Y-m-d");
                        if ($today <= $appointment->date) {
                        $date = $appointment->date;
                        $timeblock = $appointment->timeblock;
                        $ava = $appointment->availability;
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
                        <tr> <td><?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?></td> <td><?php echo htmlspecialchars($timeslot, ENT_QUOTES, 'UTF-8');?> </td> <td><?php echo htmlspecialchars($ava, ENT_QUOTES, 'UTF-8'); ?></td> </tr>
                    <?php } }?>   
                </table>

            <?php } ?>

    </div>

    <h2 class="sectionTitle" style="margin-left: 280px; margin-top: 100px; font-size:23px">Past Appointments</h2>
    <div class="section">
                <?php if (sizeof($appointments) > 0) { ?>
                    <table>
                        <tr> <th>Date</th> <th>Time Slot</th> <th>Availablilty</th> </tr>
                        <?php foreach ($appointments as $appointment) {
                            $today = date("Y-m-d");
                            if ($today > $appointment->date) {
                            $date = $appointment->date;
                            $timeblock = $appointment->timeblock;
                            $ava = $appointment->availability;
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
                            <tr> <td><?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?></td> <td><?php echo htmlspecialchars($timeslot, ENT_QUOTES, 'UTF-8');?> </td> <td><?php echo htmlspecialchars($ava, ENT_QUOTES, 'UTF-8'); ?></td> </tr>
                        <?php } }?>   
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