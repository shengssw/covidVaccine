<?php

/*session_start();
if(!isset($_SESSION['providerId'])){
    header("Location: /covidVaccine/app/views/users/login.php");
}

echo $_SESSION['patientId'];;
$current_file = basename($_SERVER['PHP_SELF']); */
?>


<?php
    require 'header.php';
    echo $_SESSION['userid'];
?>





		
		

		
		
		
 <!--   Core JS Files   -->
        <script src=" <?php echo URLROOT; ?>/public/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
        <script src="<?php echo URLROOT; ?>/public/assets/js/bootstrap.min.js" type="text/javascript"></script>

        <!--  Checkbox, Radio & Switch Plugins -->


        <!--  Google Maps Plugin    -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>



        <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->


        </body>
</html>