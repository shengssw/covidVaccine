<?php
/*include('../../config/config.php');
//require("header.php");

if (isset($_REQUEST['username'])){
    // removes backslashes
$username = stripslashes($_REQUEST['username']);
$name = stripslashes($_REQUEST['name']);
$address = stripslashes($_REQUEST['address']);
$mobile = $_POST['mobile'];

    //escapes special characters in a string
$username = mysqli_real_escape_string($connection,$username);
$name = mysqli_real_escape_string($connection,$name);
$address = mysqli_real_escape_string($connection,$address);


$patient = $_POST['rpatient'];


$sql= $connection ->prepare("SELECT * FROM account WHERE username = ?");
$sql ->bind_param('s', $username);
$sql->execute();

$result = $sql->get_result();;

if(mysqli_num_rows($result)!=0){
	echo"Username already exists!!";
} else {

$quer = "select max(roleId) m from account";
$role = mysqli_query($connection,$quer);
$row = mysqli_fetch_assoc($role);
$roleid = $row['m'] + 1;

if($patient == "no") {

    $quer2 = "select max(providerId) m from provider";
    $prole = mysqli_query($connection,$quer2);
    $prow = mysqli_fetch_assoc($prole);
    $providerid = $prow['m'] + 1;
  
    
    $adda = $connection ->prepare("INSERT into `address` 
    VALUE (?, -74, 40)");
    $adda->bind_param('s', $address);
    $adda->execute();
    
    $resulta = $adda->get_result();
    


    $addp = $connection ->prepare("INSERT into `Provider` 
    VALUE (?, ?,?,?, null)");
    $addp ->bind_param('isss', $providerid, $name, $address, $mobile);
    $addp->execute();
    $result2 = $addp->get_result();

    
    $addr = $connection ->prepare("INSERT into `role` 
    VALUES (?, null, ?)");
    $addr -> bind_param('ii', $roleid, $providerid);
    $addr->execute();
    $result3 = $addr->get_result();

}  else {
    $quer3 = "select max(patientId) m from patient";
    $parole = mysqli_query($connection,$quer3);
    $parow = mysqli_fetch_assoc($parole);
    $patientid = $parow['m'] + 1;

    $dob = stripslashes($_REQUEST['dob']);
    $email = stripslashes($_REQUEST['email']);
    $group = (int) $_POST['group'];
    $ssn = stripslashes($_REQUEST['ssn']);

    $dob = mysqli_real_escape_string($connection,$dob);
    $email = mysqli_real_escape_string($connection,$email);
    $ssn = mysqli_real_escape_string($connection,$ssn);
  

    $adda = $connection ->prepare("INSERT into `address` 
    VALUE (?, -74, 40)");
    $adda ->bind_param('s', $address);
    $adda->execute();
    
    $resulta = $adda->get_result();


    $addp = $connection ->prepare("INSERT into `patient` 
    VALUE (?,?,?,?, ?,?,?,?, null, null)");
    $addp ->bind_param ('issssssi',$patientid, $name, $dob,  $ssn, $address, $mobile, $email, $group);
    $addp->execute();
    $result2 = $addp->get_result();



    $addr = $connection ->prepare("INSERT into `role` 
    VALUES (?, ?, null)");
    $addr -> bind_param('ii', $roleid, $patientid);
    $addr->execute();
    $result3 = $addr->get_result(); 

}
$password = stripslashes($_REQUEST['password']);
$password = mysqli_real_escape_string($connection,$password);
$hash = password_hash($password, PASSWORD_DEFAULT);



$query1 = $connection ->prepare("INSERT into `account` 
VALUES (?, ?, ?)");
$query1-> bind_param('ssi',$username, $hash, $roleid);
$query1->execute();

$sql1= $connection ->prepare("SELECT * FROM account WHERE username = ?");
$sql1 ->bind_param('s', $username);
$sql1->execute();
$result1 = $sql1->get_result();

if(mysqli_num_rows($result1)!=0){
        echo "<div class='form'>
        <h3>You are registered successfully.</h3>
        <br/>Click here to <a href='login.php'>Login</a></div>";
} else {
        echo("failed account1");
}

} 
} */

?>

<?php
    require APPROOT . '/views/includes/header3.php';
?>

<div style="  background: #50a3a2;
  background: -webkit-linear-gradient(top left, #D8E2DC 20%, #a5c7d6 100%);
  background: linear-gradient(to bottom right, #D8E2DC 20%, #a5c7d6 100%);
  position: absolute;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;">

    <div class="container">

        <form class="well form-horizontal" action="<?php echo URLROOT; ?>/users/register" method="post"  id="user_form">
            <fieldset>

                <!-- Form Name -->
                <h3 style="text-align: center">Create Your Account</h3>

                <!-- Text input first name-->

                <div class="form-group">
                    <label class="col-md-4 control-label">Name</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input pattern="[A-Za-z]{3}"   name="name" id="first_name" placeholder="Full Name" class="form-control"  type="text">
                        </div>


                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Username</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input pattern="[A-Za-z]{3}"   name="username" id="username" placeholder="username" class="form-control"  type="text">
                        </div>


                    </div>
                </div>
    
                <!-- Text input email -->
                <div class="form-group">
                    <label class="col-md-4 control-label">Location</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input name="address" id="loc" placeholder="Enter your address " class ="form-control" type="text">
                        </div>

                    </div>
                </div>
                <!-- Text input passwd -->
                <div class="form-group">
                    <label class="col-md-4 control-label" >Password</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
                            <input name="password" id="txt_passwd" placeholder="Create Password" class="form-control"  type="password">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" >Confirm Password</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
                            <input name="confirmed_password"  id="txt_confirm_passwd" placeholder="Confirm Password" class="form-control"   type="password" onkeyup="checkpassmatch();">
                        </div>
                        <div class="registrationFormAlert" style="color: green" id="divCheckPasswordMatch">
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Phone #</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                            <input name="mobile" placeholder="01XXXXXXXXX" id="mobile" class="form-control" type="text" onkeyup="validatenumber();">
                        </div>
                        <div class="registrationFormAlert" style="color: green" id="divChecknumber">
                        </div>
                    </div>
                </div>


                <!-- Text input mobile-->


                <div class="form-group">
                    <label class="col-md-4 control-label">Register as a Patient?</label>
                    <div class="col-md-4">
                        <div class="radio">
                            <label>
                                <input type="radio" id=radio_yes name="rpatient" value="yes" /> Yes
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" id=radio_no name="rpatient" value="no" checked="No" /> No
                            </label>
                        </div>
                    </div>
                </div>


                <!-- Text input dob-->
                <div class="form-group" id="dob_on" style="display: none">
                    <label class="col-md-4 control-label">Date Of Birth</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input name="dob" placeholder="Date Of Birth" class="form-control"  type="date" id="dobfield" onchange="getAge()">

                        </div>
                        <div class="registrationFormAlert" id="divCheckAge">
                        </div>
                    </div>
                </div>


                <!-- Text input
                <div class="form-group" id=bg_on style="display: none">
                    <label class="col-md-4 control-label">Priority Group</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <select name="group" class="form-control selectpicker" >
                                <option value=" " >Select your Priority Group </option>
                                <option>1</option>
                                <option >2</option>
                                <option >3</option>
                                <option >4</option>
                                <option >5</option>
                            </select>
                        </div>
                    </div>
                </div> -->

                <div class="form-group" id=sub_district_on style="display: none;">
                    <label class="col-md-4 control-label">SSN</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                            <input name="ssn" placeholder="SSN number" class="form-control"  type="text">
                        </div>
                    </div>
                </div>


                <!-- Text input google_loc -->

                <div class="form-group" id=location style="display: none;">
                    <label class="col-md-4 control-label">Email Address</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
                        </div>
                    </div>
                </div>


                <!-- Button -->
                <div class="form-group" >
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4">
                        <button type="submit" id="button" class="btn" name="sign_up" >Sign-Up<span class="glyphicon glyphicon-send"></span></button>
                    </div>
                </div>



            </fieldset>

        </form>
    </div>
</div>



<?php
    require APPROOT . '/views/includes/footer.php';
?>

