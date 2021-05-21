<?php 

/**
 * Default controller for provider
 * 
 * @author Sheng
 */

class Providers extends Controller{
    public function __construct()
    {
        $this->providerModel = $this->model('Provider');

    }
    public function Dashboard() {
        if (!isLoggedIn()) {
            header("Location: " . URLROOT . "/pages/index");
        }  elseif (isset($_SESSION['type'])){
            if($_SESSION['type']!='provider') {
                header("Location: " . URLROOT . "/pages/index");
            }
        }
        // Get the provider info
        $provider = $this->providerModel->getProvider($_SESSION['userid']);

        // Get all the appoints one provider has
        $appointments = $this->providerModel->getAllProviderAppointmentsById($provider[0]->providerId);
        
        $data = [
            'provider' => $provider,
            'appointments' => $appointments
        ];

        $this->view('providers/Dashboard', $data);
    }

    public function allapps() {
        if (!isLoggedIn()) {
            header("Location: " . URLROOT . "/pages/index");
        }  elseif (isset($_SESSION['type'])){
            if($_SESSION['type']!='provider') {
                header("Location: " . URLROOT . "/pages/index");
            }
        }

        $statusfilter = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
 
            $status = $_POST['status'];
            if($status) {
                $statusfilter = $status;
            }
            
        }

        // Get the provider info
        $provider = $this->providerModel->getProvider($_SESSION['userid']);

        // Get all the appoints one provider has
        $appointments = $this->providerModel->getAllProviderAppointmentsById($provider[0]->providerId);


        $data = [
            'provider' => $provider,
            'appointments' => $appointments,
            'statusfilter' => $statusfilter
        ];
        
        $this->view('providers/allapps', $data);
    }

    public function singleApp($patientId, $appointId) {
        if (!isLoggedIn()) {
            header("Location: " . URLROOT . "/pages/index");
        }  elseif (isset($_SESSION['type'])){
            if($_SESSION['type']!='provider') {
                header("Location: " . URLROOT . "/pages/index");
            }
        }

        // find appointment patient
        $patient = $this->providerModel->getPatientById($patientId);
        $app = $this->providerModel->getPatientAppointmentById($patientId, $appointId);
        $appointment = $this->providerModel->getAppointmentById($appointId);

        $data = [
            'patientId' => $patientId,
            'appointId' => $appointId,
            'patient' => $patient,
            'patientappointment' => $app,
            'appointment' => $appointment
        ];

        $this->view('providers/singleApp', $data);
    }

    public function updateStatus($patientId, $appointId) {

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
 
            $status = $_POST['status'];
            //echo $status;

            if(!$status) {
                header("Location: " . URLROOT . "/providers/singleApp/".$patientId."/".$appointId); 
            }

            // Call the model function to update 
            if($this->providerModel->updatePatientAppointmentStatus($appointId, $patientId, $status)){
                header("Location: " . URLROOT . "/providers/singleApp/".$patientId."/".$appointId);  
            } else {
                die("Something went wrong, please try again!");  
            } 
            
        } 

        header("Location: " . URLROOT . "/providers/singleApp/".$patientId."/".$appointId);  
    }

    public function addapps(){
        if (!isLoggedIn()) {
            header("Location: " . URLROOT . "/pages/index");
        }  elseif (isset($_SESSION['type'])){
            if($_SESSION['type']!='provider') {
                header("Location: " . URLROOT . "/pages/index");
            }
        }

        $data = [
            'appointId' => '',
            'providerId' => '',
            'date' => '',
            'timeblock' => '',
            'availability' => '',
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Get current appointId 
            //Id
            $old_id = $this->providerModel->getCurrentMaxId();
            $new_id = $old_id->m + 1;

            $providerId = (int)$_SESSION['userid'];
            $date = '';
            $timeblock = 0;
            $ava = 0;

            if(!empty($_POST['timeblock'])) {
                $timeblock = (int)$_POST['timeblock'];
            }

            if(!empty($_POST['apptDate'])) {
                $date = stripslashes($_POST['apptDate']);
            }

            if(!empty($_POST['num'])) {
                $ava = (int)$_POST['num'];
            }

            for ($i = 0; $i < $ava; $i++) {
                $data = [
                    'appointId' => $new_id + $i,
                    'providerId' => $providerId,
                    'date' => $date,
                    'timeblock' => $timeblock,
                    'availability' => $ava,
                ];  

                // Insert New Appointment
                if ( $this->providerModel->addapps($data)) {
                     // Find match patients
                     $patient = $this->providerModel->findMatchPatient($new_id+$i, $date, $timeblock);

                     if ($patient->patientId) {
                         // Insert An new patientappointment
                         if($this->providerModel->insertNewPatientAppointment($patient->patientId, $data['appointId'])){
                             // Update Appointment Availability
                             if($this->providerModel->updateAppointment($data['appointId'])){
                                 continue;
                             } else {
                                 die("Something went wrong, please try again!");   
                             }
                         } else {
                             die("Something went wrong, please try again!");  
                         }
                     }

                } else {
                    die('Something went wrong!');
                } 
            }
            
            header("Location: " . URLROOT . "/providers/Dashboard");
            
            
           
           
        }
        $this->view('providers/addapps',$data);
    } 

   

}


?>