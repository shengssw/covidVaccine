<?php
    require 'header.php';

    $patientId = $data['patientId'];
    $appointId = $data['appointId'];
    $patient = $data['patient'];
    $app = $data['appointment'];
    $papp = $data['patientappointment']
?>

<style>
    .styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 800px;
    max-width: 800px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    margin-left: 50px;
    border-radius:10px;
    }

    .styled-table th,
    .styled-table td {
    padding: 12px 15px;
   
    }
    .styled-table tbody tr {
    border-bottom: 1px solid #dddddd;
}

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr.active-row {
        font-weight: bold;
        background-color: #009879;
        color: white;
        border-top-left-radius:10px;
        border-top-right-radius: 10px;
    }

</style>

<div style="margin-left: 260px;">
    <h2 class="sectionTitle" style="margin-left: 50px; font-size:23px; font-weight:400;">Appointment <?php echo $appointId;?></h2>
    <h3 class="sectionTitle" style="margin-left: 50px; font-size:18px">Patient Info</h3>
    <table class="styled-table">
        <tbody>
            <tr class="active-row">
                <td>Patient Name:</td>
                <td><?php echo htmlspecialchars($patient->name, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><?php echo htmlspecialchars($patient->birthday, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
                <td>SSN:</td>
                <td><?php echo htmlspecialchars($patient->ssn, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><?php echo htmlspecialchars($patient->phone, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
                <td>Priority Group:</td>
                <td><?php echo htmlspecialchars($patient->groupId, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        
        </tbody>

    </table>

    <h3 class="sectionTitle" style="margin-left: 50px; font-size:18px">Appointment Info</h3>
    <table class="styled-table">
        <tbody>
            <tr class="active-row">
                <td>Appointment Date:</td>
                <td><?php echo htmlspecialchars($app->date, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
                <td>Appointment Time:</td>
                <td><?php 
                 switch ($app->timeblock) {
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
                
                echo htmlspecialchars($timeslot, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><?php echo htmlspecialchars($papp->status, ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
            <?php if($papp->status == 'accepted'){?>
            <tr>
                <td>Update Status To: </td>
                <td>
                     <form action="<?php echo URLROOT . "/providers/updateStatus/".$patientId. "/". $appointId ?>" method="POST" style="font-size: 12px; font-weight:100;">
                        <label style="margin-right:20px;">
                                    <input type="radio" id="vaccinated" name="status" value="vaccinated"/>  Vaccinated
                        </label>
                        <label style="margin-right:20px;">
                                    <input type="radio" id="noshow" name="status" value="noshow"/>  No Show
                        </label>
                        <button type="submit" style="margin-top:10px;" >Confirm</button>
                    </form> 
                </td>
            </tr>
            <?php }?>
            <?php if($papp->status == 'declined'||$papp->status == 'cancelled' ){?>
            <tr>
                <td>Update Time: </td>
                <td><?php echo htmlspecialchars($papp->replyTime, ENT_QUOTES, 'UTF-8'); ?> 
                </td>
            </tr>
            <?php }?>
           
        
        </tbody>

    </table>


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