<?php 

    class Users extends Controller {

        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function login() {
            $data = [
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];
    
            //Check for post
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
                $data = [
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['passwd']),
                    'usernameError' => '',
                    'passwordError' => '',
                ];
    
                //Check if all errors are empty
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if ($loggedInUser) {
                    echo "here";
                     // Find id of patient or provider
                      $ids = $this->userModel->findIdByRoleId($loggedInUser->roleId);

                     // Get user
                     $patientId = $ids->patientId;
                     $providerId = $ids->providerId;
                     if ($patientId) {
                         $user = $this->userModel->findPatient($patientId);
                        $this->createUserSession($user,0);
                     } else {
                            $user = $this->userModel->findProvider($providerId);
                        $this->createUserSession($user,1);
                     }
                    
                } else {
                    echo "there";

                    $this->view('users/login', $data);
                }
              
    
            } else {
                $data = [
                    'username' => '',
                    'password' => '',
                    'usernameError' => '',
                    'passwordError' => ''
                ];
            }
            $this->view('users/login', $data);
        }

        public function register() {
            $data = [
                'providerId' => '',
                'roleId' => '',
                'name' => '', 
                'address' => '',
                'latitude' => '',
                'longitude' => '',
                'phone' => '',
                'providerType' => '',
                'username' => '',
                'password' => '' ,
                'confirmPassword' => '',
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];
         

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                if($_POST['rpatient'] == "no") {
                    // Register Provider

                    //Id
                    $old_id = $this->userModel->getCurrentMaxId(1);
                    $new_id = $old_id->m + 1;
    

                    //Address
                    $insertAddress = true;
                    $address = trim($_POST['address']);
                    $r = $this->userModel-> checkAddress($address);
                    $latitude = 40;
                    $longitude = -74;
                    if (!empty($r)) {
                        $latitude = $r->latitude;
                        $longitude = $r->longitude;
                        $insertAddress = false;
                    } 

                    //Role
                    $old_rid = $this->userModel->getCurrentMaxRoleId();
                    $roleId = $old_rid->r + 1;
                  
                    // Password
                    $password = trim($_POST['password']);
                    $password = stripslashes($password);
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    
                    $data = [
                        'providerId' => $new_id,
                        'roleId' => $roleId,
                        'name' => trim($_POST['name']), 
                        'address' => $address,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'phone' => trim($_POST['mobile']),
                        'providerType' => 'Vaccation Site',
                        'username' => trim($_POST['username']),
                        'password' => $hash ,
                        'confirmPassword' => trim($_POST['confirmed_password']),
                    ];

        
                    // Insert Address
                        if ($insertAddress) {
                            if ( $this->userModel->insertAddress($address, $latitude, $longitude) ) {
                                // Insert Provider
                                if ($this->userModel->insertProvider($data)){
                                    //Insert Role
                                    if  ($this->userModel->insertRoleId(1, $roleId, $new_id)){
                                        // Insert Account
                                        if ($this->userModel->insertAccount($data)) {
                                            header("Location: " . URLROOT . "/users/login");
                                            echo "<div class='form'>
                                            <h3>You are registered successfully.</h3>
                                            <br/>Click here to <a href='login.php'>Login</a></div>";
                                        } else {
                                            echo("failed account1");
                                            die('Something went wrong.'); 
                                        }
                                    } else {
                                        die('Something went wrong.');   
                                    }
                                } else {
                                    die('Something went wrong.');  
                                }
                                
                            } else {
                                die('Something went wrong.');  
                            }
                        } else {
                            // Insert Provider
                            if ($this->userModel->insertProvider($data)){
                                //Insert Role
                                if  ($this->userModel->insertRoleId(1, $roleId, $new_id)){
                                     // Insert Account
                                     if ($this->userModel->insertAccount($data)) {
                                        header("Location: " . URLROOT . "/users/login");
                                        echo "<div class='form'>
                                            <h3>You are registered successfully.</h3>
                                            <br/>Click here to <a href='login.php'>Login</a></div>";
                                    } else {
                                        die('Something went wrong.'); 
                                    }
                               } else {
                                   die('Something went wrong.');   
                               }
                            } else {
                                die('Something went wrong.');  
                            }
                        }


                } else {
                    // Register Patient  
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                    //Id
                    $old_id = $this->userModel->getCurrentMaxId(0);
                    $new_id = $old_id->m + 1;
    

                    //Address
                    $insertAddress = true;
                    $address = trim($_POST['address']);
                    $r = $this->userModel-> checkAddress($address);
                    $latitude = 40;
                    $longitude = -74;
                    if (!empty($r)) {
                        $latitude = $r->latitude;
                        $longitude = $r->longitude;
                        $insertAddress = false;
                    } 

                    //Role
                    $old_rid = $this->userModel->getCurrentMaxRoleId();
                    $roleId = $old_rid->r + 1;
                  
                    // Password
                    $password = trim($_POST['password']);
                    $password = stripslashes($password);
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    
                    $data = [
                        'patientId' => $new_id,
                        'roleId' => $roleId,
                        'name' => trim($_POST['name']), 
                        'address' => $address,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'phone' => trim($_POST['mobile']),
                        'username' => trim($_POST['username']),
                        'password' => $hash ,
                        'confirmPassword' => trim($_POST['confirmed_password']),
                        'birthday' => trim($_POST['dob']),
                        'ssn' => trim($_POST['ssn']),
                        'email' =>  trim($_POST['email'])
                    ];

        
                    // Insert Address
                        if ($insertAddress) {
                            if ( $this->userModel->insertAddress($address, $latitude, $longitude) ) {
                                // Insert Provider
                                if ($this->userModel->insertPatient($data)){
                                    //Insert Role
                                    if  ($this->userModel->insertRoleId(0, $roleId, $new_id)){
                                        // Insert Account
                                        if ($this->userModel->insertAccount($data)) {
                                            header("Location: " . URLROOT . "/users/login");
                                            echo "<div class='form'>
                                            <h3>You are registered successfully.</h3>
                                            <br/>Click here to <a href='login.php'>Login</a></div>";
                                        } else {
                                            echo("failed account1");
                                            die('Something went wrong.'); 
                                        }
                                    } else {
                                        die('Something went wrong.');   
                                    }
                                } else {
                                    die('Something went wrong.');  
                                }
                                
                            } else {
                                die('Something went wrong.');  
                            }
                        } else {
                            // Insert Provider
                            if ($this->userModel->insertPatient($data)){
                                //Insert Role
                                if  ($this->userModel->insertRoleId(0, $roleId, $new_id)){
                                     // Insert Account
                                     if ($this->userModel->insertAccount($data)) {
                                        header("Location: " . URLROOT . "/users/login");
                                        echo "<div class='form'>
                                            <h3>You are registered successfully.</h3>
                                            <br/>Click here to <a href='login.php'>Login</a></div>";
                                    } else {
                                        die('Something went wrong.'); 
                                    }
                               } else {
                                   die('Something went wrong.');   
                               }
                            } else {
                                die('Something went wrong.');  
                            }
                        }
                   
                    }

            }
            
            $this->view('users/register', $data);
        }

        public function createUserSession($user,$type) {
            if ($type==1) {
                $_SESSION['userid'] = $user->providerId;
                $_SESSION['username'] = $user->name;
                $_SESSION['type'] = 'provider';
                header('location:' . URLROOT . '/providers/Dashboard');
            } else {
                $_SESSION['userid'] = $user->patientId;
                $_SESSION['username'] = $user->name;
                $_SESSION['type'] = 'patient';
                header('location:' . URLROOT . '/patients/Dashboard');
            }
        }
    
        public function logout() {
            unset($_SESSION['userid']);
            unset($_SESSION['username']);
            header('location:' . URLROOT . '/users/login');
        }



    }