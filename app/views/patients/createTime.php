<?php
    require APPROOT . '/views/includes/header4.php';

    $patientId = $data['patientId'];
?>

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

    <div class="container" style="margin-left: 250px; background-color: white;">
        <h2 class="pageTitle">
            Add New Time Preference
        </h2>

        <form class="selection-form" action="<?php echo URLROOT. "/patients/createTime/" .$patientId ?>" method="POST">

            <h2 class="sectionTitle"> Day </h2>
            <select name="day" id="day" style="margin-left: 50px;">
                <option value="" disabled selected>Choose Day</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
                <option value="7">Sunday</option>
            </select>

            <h2 class="sectionTitle"> Time Slot </h2> 
            <select name="timeblock" id="timeblock" style="margin-left: 50px; padding-bottom: 10px; margin-bottom: 30px;">
                <option value="" disabled selected>Choose Time Slot</option>
                <option value="1">8:00 AM - 12:00 PM</option>
                <option value="2">12:00PM - 4:00 PM</option>
                <option value="3">4:00 PM - 8:00 PM</option>
                <option value="4">8:00 PM - 12:00 AM</option>
            </select>
            <br> <br>
            <button class="sectionButton" style="margin-left: 50px;" type="submit">Submit</button>
            <button class="sectionAddButton"><a class="sectionButton" href="<?php echo URLROOT. "/patients/preference/" .$patientId ?>" >Cancel</a> </button>
        </form>
    </div>

</div>