<?php 

    class Patients extends Controller {

        public function __construct()
        {
            $this->patientModel = $this->model('Patient');
        }

        public function Dashboard() {
            // Get the patient info
            $patient = $this->patientModel->getPatient();
            
            // Get all the appoints one patient has
            $appointments = $this->patientModel->getAllPatientAppointmentsById($patient[0]->patientId);

            $data = [
                'patient' => $patient,
                'appointments' => $appointments
            ];

            $this->view('patients/Dashboard', $data);
        }

        public function declinePatientAppointment($patietnId, $appointId) {
            //header("Location: " . URLROOT . "/patients/Dashboard");

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                if($this->patientModel->declinePatientAppointment($patietnId, $appointId)) {
                    if($this->patientModel->updateAppointmentAvailability($appointId,1)) {
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

        public function AcceptPatientAppointment($patietnId, $appointId) {
            //header("Location: " . URLROOT . "/patients/Dashboard");

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                if($this->patientModel->AcceptPatientAppointment($patietnId, $appointId)) {
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

        public function CancelPatientAppointment($patietnId, $appointId) {
            //header("Location: " . URLROOT . "/patients/Dashboard");

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                if($this->patientModel->CancelPatientAppointment($patietnId, $appointId)) {
                    if($this->patientModel->updateAppointmentAvailability($appointId,1)) {
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

        public function preference($id) {
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
            $data = [
                'patientId' => $patientId,
                'timeblock' => '',
                'day' => ''


            ];

            if(isset($_POST['submit'])) {
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
    