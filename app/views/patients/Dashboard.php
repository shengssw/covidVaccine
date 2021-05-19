<?php
    require APPROOT . '/views/includes/header4.php';

?>

<?php

// Global variables
$patient = $data['patient'][0];
$appointments = $data['appointments']; ?>

<style>
table {
    border-collapse: collapse;
    width: 100%;
    margin-left: 300px;
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
    <div class="sidebar">

        <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->


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

    <nav class="navbar navbar-default navbar-fixed">
    <div class="container-fluid">
     <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">


            <ul class="nav navbar-nav navbar-right">
           
              
              <li><a href="<?php echo URLROOT; ?>/users/logout">Log out</a></li>

            
            </ul>
        </div>
    </div>
    </nav>

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

  

 </div>


                            </body>
                            </html>

