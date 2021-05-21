<?php 

    class Patients extends Controller {

        public function __construct()
        {
            $this->patientModel = $this->model('Patient');
        }

        public function Dashboard() {
            if (!isLoggedIn()) {
                header("Location: " . URLROOT . "/pages/index");
            } elseif (isset($_SESSION['type'])){
                if($_SESSION['type']!='patient') {
                    header("Location: " . URLROOT . "/pages/index");
                }
            }

            // Get the patient info
            $patient = $this->patientModel->getPatient($_SESSION['userid']);
            
            // Check any expired appointments
            $expired = $this->patientModel->getexpireAppointment($patient[0]->patientId);
            
            // Update appointments status to expired
            if (sizeof($expired)>0) {
                for ($i=0; $i<sizeof($expired); $i++) {
                    // Set the patientappoint status to expired
                    $this->patientModel->setexpireAppointment( $expired[$i]->patientId, $expired[$i]->appointId);

                    $patientId = $expired[$i]->patientId;
                    $appointId = $expired[$i]->appointId;
                     // Find the date and timeblock of the declined appointment and check if it is out of date
                     $app = $this->patientModel->getAppointmentById($appointId);

                     if($app) {
                        // Find another patient to match the declined appointment 
                        $p = $this->patientModel->findAnotherMatchPatient($patientId, $appointId, $app->date, $app->timeblock);

                           // If there is such patient
                           if($p) {
                            // Insert the new patient
                            if($this->patientModel->insertNewPatientAppointment($p->patientId, $appointId)) {

                                // Update the availability 
                                if(!($this->patientModel->updateAppointmentAvailability($appointId,0))) {
                                    die('Something went wrong!');
                                } 

                            } else {
                                die('Something went wrong!');
                            }
                        } 

                     } 

                }
            } 

             // Get all the appoints one patient has
             $appointments = $this->patientModel->getAllPatientAppointmentsById($patient[0]->patientId);

            $data = [
                'patient' => $patient,
                'appointments' => $appointments
            ];

            $this->view('patients/Dashboard', $data);
        }

        public function Setting(){
            if (!isLoggedIn()) {
                header("Location: " . URLROOT . "/pages/index");
            } elseif (isset($_SESSION['type'])){
                if($_SESSION['type']!='patient') {
                    header("Location: " . URLROOT . "/pages/index");
                }
            }

            $patientId = $_SESSION['userid'];

           // Get the patient info
            $patient = $this->patientModel->getPatient($_SESSION['userid']);

            $data = [
                'patientId' => $patientId,
                'patient' => $patient
            ];


            $this->view('patients/Setting', $data);
        }

        public function updateUserInfo($patientId) {


            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
             
                $data = [
                    'patientId' => $patientId,
                    'birthday' => trim($_POST['birthday']),
                    'address'  => $_POST['address'],
                    'email'  => $_POST['email'],
                    'ssn'  => $_POST['ssn'],
                    'phone'  => $_POST['phone'],
                    'name'  => $_POST['name']
                ]; 

                if (!empty($_POST['name'])) {
                    if (!($this->patientModel->updateName($data))) {
                        die("Something went wrong, please try again!");
                    } 
                }

                if (!empty($_POST['ssn'])) {
                    if (!($this->patientModel->updateSSN($data))) {
                        die("Something went wrong, please try again!");
                    } 
                }

                if (!empty($_POST['birthday'])) {
                    if (!($this->patientModel->updateBirthday($data))) {
                        die("Something went wrong, please try again!"); 
                    } 
                }

                if (!empty($_POST['phone'])) {
                    if (!($this->patientModel->updatePhone($data))) {
                        die("Something went wrong, please try again!");
                    } 
                }

                if (!empty($_POST['email'])) {
                    if (!($this->patientModel->updateEmail($data))) {
                        die("Something went wrong, please try again!");
                    } 
                }

                if (!empty($_POST['address'])) {
                    $address1 = $data['address'];
                    $r = $this->patientModel-> checkAddress($address1);
                    $latitude = 40;
                    $longitude = -74;
                    
            
                    if (!$r) {
                        if($this->patientModel->insertAddress($address1, $latitude, $longitude)){
                            if (!($this->patientModel->updateAddress($data))) {
                                die("Something went wrong, please try again!");
                            } 
                        } else {
                            die("Something went wrong, please try again!");
                        }
                    } else {
                        if (!($this->patientModel->updateAddress($data))) {
                            die("Something went wrong, please try again!");
                        }  
                    }
                }

                header("Location: " . URLROOT . "/patients/setting");
            }
          
       } 



        public function declinePatientAppointment($patientId, $appointId) {
             
            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                if($this->patientModel->declinePatientAppointment($patientId, $appointId)) {
                    if($this->patientModel->updateAppointmentAvailability($appointId,1)) {
                        // Find the date and timeblock of the declined appointment 
                        $app = $this->patientModel->getAppointmentById($appointId);

                        // Find another patient to match the declined appointment 
                        $p = $this->patientModel->findAnotherMatchPatient($patientId, $appointId, $app->date, $app->timeblock);

                        if($p) {
                            // Insert the new patient
                            if($this->patientModel->insertNewPatientAppointment($p->patientId, $appointId)) {

                                // Update the availability 
                                if(!($this->patientModel->updateAppointmentAvailability($appointId,0))) {
                                    die('Something went wrong!');
                                } 
                            } else {
                                die('Something went wrong!');
                            }
                        } 

                        // Find the patient another available appointment 
                        $appointment = $this->patientModel->findAnotherMatchAppointment($patientId, $appointId);

                        if($appointment) {
                            // Insert New Patient Appointment
                            if($this->patientModel->insertNewPatientAppointment($patientId, $appointment->appointId)) {

                                // Update the availability 
                                if($this->patientModel->updateAppointmentAvailability($appointment->appointId,0)) {
                                    header("Location: " . URLROOT . "/patients/Dashboard");
                                } else {
                                    die('Something went wrong!');
                                } 
                            } else {
                                die('Something went wrong!');
                            }
                            
                        } 

                        header("Location: " . URLROOT . "/patients/Dashboard"); 

                    }else {
                        die('Something went wrong!');
                    }
                } else {
                   die('Something went wrong!');
                }
            }
          
        }



        public function AcceptPatientAppointment($patientId, $appointId) {
            //header("Location: " . URLROOT . "/patients/Dashboard");

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                if($this->patientModel->AcceptPatientAppointment($patientId, $appointId)) {
                    if($this->patientModel->updateAppointmentAvailability($appointId,0)) {
                        header("Location: " . URLROOT . "/patients/Dashboard");
                    }
                    else {
                        die('Something went wrong!');
                    }
                } else {
                   die('Something went wrong!');
                }
            }
          
        }

        public function CancelPatientAppointment($patientId, $appointId) {
       
            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Update the status of the PatientAppointment 
                if($this->patientModel->CancelPatientAppointment($patientId, $appointId)) {

                    // Update the availability of the appointment to 1
                    if($this->patientModel->updateAppointmentAvailability($appointId,1)) {

                        // Find the date and timeblock of the cancelled appointment 
                        $app = $this->patientModel->getAppointmentById($appointId);

                           // Find another patient to match the cancelled appointment 
                           $p = $this->patientModel->findAnotherMatchPatient($patientId, $appointId, $app->date, $app->timeblock);

                           if($p) {
                               // Insert the new patient
                               if($this->patientModel->insertNewPatientAppointment($p->patientId, $appointId)) {

                                    // Update the availability 
                                    if(!($this->patientModel->updateAppointmentAvailability($appointId,0))) {
                                        die('Something went wrong!');
                                    } 
                                } else {
                                    die('Something went wrong!');
                                }
                            } 

                        // Find the patient another available appointment 
                        $appointment = $this->patientModel->findAnotherMatchAppointment($patientId, $appointId);

                        if($appointment) {
                            // Insert New Patient Appointment
                            if($this->patientModel->insertNewPatientAppointment($patientId, $appointment->appointId)) {

                                // Update the availability 
                                if($this->patientModel->updateAppointmentAvailability($appointment->appointId,0)) {
                                    header("Location: " . URLROOT . "/patients/Dashboard");
                                } else {
                                    die('Something went wrong!');
                                } 
                            } else {
                                die('Something went wrong!');
                            }
                            
                        } 

                        header("Location: " . URLROOT . "/patients/Dashboard"); 
                                   

                    } else {
                        die('Something went wrong!');
                    } 

                } else {
                    die('Something went wrong!');
                }

            }

            header("Location: " . URLROOT . "/patients/Dashboard"); 
        }

    
        public function preference($id) {

            if (!isLoggedIn()) {
                header("Location: " . URLROOT . "/pages/index");
            } elseif ($_SESSION['userid'] != $id) {
                header("Location: " . URLROOT . "/pages/index");
            }  elseif (isset($_SESSION['type'])){
                if($_SESSION['type']!='patient') {
                    header("Location: " . URLROOT . "/pages/index");
                }
            }

            // GET THE PATIENT PRGERENCE
           $timePreferences = $this->patientModel->getTimePreferencesById($id);
           $distance = $this->patientModel->getDistanceById($id);
           
           $data = [
            'timePreferences' => $timePreferences,
            'distance' => $distance,
            'patientId' => $id
           ];

           // If there is any update to the preference 
           $this->view('patients/preference', $data);
        }

        public function createTime($patientId) {
            if (!isLoggedIn()) {
                header("Location: " . URLROOT . "/pages/index");
            } elseif ($_SESSION['userid'] != $patientId) {
                header("Location: " . URLROOT . "/pages/index");
            }  elseif (isset($_SESSION['type'])){
                if($_SESSION['type']!='patient') {
                    header("Location: " . URLROOT . "/pages/index");
                }
            }

            $data = [
                'patientId' => $patientId,
                'timeblock' => '',
                'day' => ''
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $day = 0;
                $timeblock = 0;
                if(!empty($_POST['timeblock'])) {
                    $timeblock = $_POST['timeblock'];
                }

                if(!empty($_POST['day'])) {
                    $day = $_POST['day'];
                }

                $data = [
                    'patientId' => $patientId,
                    'timeblock' => $timeblock,
                    'day' => $day
                ];

                if ($this->patientModel->createTime($data)) {
                    //header("Location: " . URLROOT . "/patients/preference/".$patientId);

                    // See if there is available appointment to match
                    $app = $this->patientModel->findMatchAppointment($patientId);

                    if($app) {
                        // Insert New Patient Appointment
                        if($this->patientModel->insertNewPatientAppointment($patientId, $app->appointId)) {

                            // Update the availability 
                            if($this->patientModel->updateAppointmentAvailability($app->appointId,0)) {
                                header("Location: " . URLROOT . "/patients/preference/".$patientId); 
                            } else {
                                die('Something went wrong!');
                            } 
                        } else {
                            die('Something went wrong!');
                        }
                        
                    }

                    header("Location: " . URLROOT . "/patients/preference/".$patientId); 
                } else {
                    die("Something went wrong, please try again!");
                }
            }

            $this->view('patients/createTime',$data);
           
        }

   
        public function updateDistance($patientId) {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'patientId' => $patientId,
                    'distancepreference' => trim($_POST['distance']),
                ];

                if(empty($data['distancepreference'])) {
                    $data['distancepreference'] = 0;
                } 

                if ($this->patientModel->updateDistance($data)) {
                    //header("Location: " . URLROOT . "/patients/preference/".$patientId);
                    // See if there is available appointment to match
                    $app = $this->patientModel->findMatchAppointment($patientId);

                    if($app) {
                        // Insert New Patient Appointment
                        if($this->patientModel->insertNewPatientAppointment($patientId, $app->appointId)) {

                            // Update the availability 
                            if($this->patientModel->updateAppointmentAvailability($app->appointId,0)) {
                                header("Location: " . URLROOT . "/patients/preference/".$patientId); 
                            } else {
                                die('Something went wrong!');
                            } 
                        } else {
                            die('Something went wrong!');
                        }
                        
                    } 

                    header("Location: " . URLROOT . "/patients/preference/".$patientId); 
                } else {
                    die("Something went wrong, please try again!");
                }
            }

        }

        public function deleteTime($patientId, $timeblock, $day) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                if($this->patientModel->deleteTime($patientId, $timeblock, $day)) {
                        header("Location: " . URLROOT . "/patients/preference/".$patientId);
                } else {
                   die('Something went wrong!');
                }
            }
        }

    }
    