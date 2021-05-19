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
    margin-left: 100px;
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
<div class="section">
            <?php if (sizeof($appointments) > 0) { ?>
                <table>
                    <tr> <th>Date</th> <th>Time Slot</th> <th>Availablilty</th> </tr>
                    <?php foreach ($appointments as $appointment) {
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
                        <tr> <td><?php echo $date ?></td> <td><?php echo $timeslot; ?> </td> <td><?php echo $ava; ?></td> </tr>
                    <?php } ?>   
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