<?php
    require APPROOT . '/views/includes/header.php';

    $patientId = $data['patientId'];
?>

<div class="container">
    <h1 class="pageTitle">
        Add New Time Preference
    </h1>

    <form class="selection-form" action="<?php echo URLROOT. "/patients/createTime/" .$patientId ?>" method="POST">

        <h2 class="sectionTitle"> Day </h2>
        <select name="day" id="day">
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
        <select name="timeblock" id="timeblock">
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