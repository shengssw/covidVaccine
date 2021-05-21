<?php
    require APPROOT . '/views/includes/header4.php';
    $patientId = $data['patientId'];
    $patient = $data['patient'][0];
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
                    <a href="<?php echo URLROOT."/patients/preference/".$patientId?>">
                        <i class="pe-7s-portfolio"></i>
                        <p>Preference</p>
                    </a>
                </li>
                <li class= "active">
                    <a href="<?php echo URLROOT."/patients/Setting/"?>">
                        <i class="pe-7s-portfolio"></i>
                        <p>Setting</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>





    <div class="container" style="margin-left:242px; width:100%; background-color: #f5f5f5;">
    <form class="well form-horizontal"  action="<?php echo URLROOT . "/patients/updateUserInfo/" .$patientId ?>" method="post"  id="user_form">
        <fieldset>
            <!-- Form Name -->
            <h3 style="text-align: center; margin-bottom: 40px; font-size: 26px;">Update your Information</h3>

            <!-- Text input first name-->

            <div class="form-group">
                <label class="col-md-4 control-label">Name</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"></i></span>
                            <input name="name" id="loc" placeholder="<?php echo $patient->name; ?>" class ="form-control" type="text">
                        </div>
                    </div>
                </div>  

            <div class="form-group">
                <label class="col-md-4 control-label">Birthday Date</label>
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"></span>
                        <input name="birthday" placeholder="Date" class="form-control"  type="date" id="dobfield" onchange="getAge()">
                    </div>
                    <div class="registrationFormAlert" id="divCheckAge">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Address</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"></i></span>
                            <input name="address" placeholder="<?php echo $patient->address; ?>" class ="form-control" type="text">
                        </div>
                    </div>
                </div>    


            <div class="form-group">
                            <label class="col-md-4 control-label">Email Address</label>
                            <div class="col-md-4 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <input name="email" placeholder="<?php echo $patient->email; ?>" class="form-control"  type="text">
                                </div>
                            </div>
            </div>

            <div class="form-group">
                            <label class="col-md-4 control-label">Phone #</label>
                            <div class="col-md-4 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <input name="phone" placeholder="<?php echo $patient->phone; ?>" id="mobile" class="form-control" type="text" onkeyup="validatenumber();">
                                </div>
                                <div class="registrationFormAlert" style="color: green" id="divChecknumber">
                                </div>
                            </div>
                        </div>


            <div class="form-group">
                            <label class="col-md-4 control-label">SSN</label>
                            <div class="col-md-4 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <input name="ssn" placeholder="<?php echo $patient->ssn; ?>" class="form-control"  type="text">
                                </div>
                            </div>
                        </div>




                        <div class="form-group" >
                            <label class="col-md-4 control-label"></label>
                            <div class="col-md-4">
                                <button type="submit" id="button" class="btn" name="sign_up" >Update</button>
                            </div>
                        </div>

        </fieldset>
    </form>
</div>
