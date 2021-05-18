<?php

    class Patient {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getPatient($id) {
            // Prepare statement 
            $this->db->query("SELECT * FROM Patient WHERE patientId=:id;");

            $this->db->bind(':id', $id);

            // Get results
            $result = $this->db->resultSet();
            return $result;
        }

        public function getAllPatientAppointmentsById($id) {
            //Prepare statement 
            $this->db->query("SELECT * FROM PatientAppointment NATURAL JOIN Appointment WHERE patientId= :id;");

            // Bind values
            $this->db->bind(':id', $id);

            // Get results
            $result = $this->db->resultSet();
            return $result;
        }

        public function updateAppointmentAvailability($appointId, $num)
        {
             // Update appointment 
             $this->db->query("UPDATE Appointment SET availability= :num WHERE appointId= :appointId;"); 
             $this->db->bind(':appointId', $appointId);
             $this->db->bind(':num', $num);  
             if($this->db->execute()) {
                 return true;
             } else {
                 return false;
             }
        }

     
        public function declinePatientAppointment($patientId, $appointId) {
           //Prepare statement 
           $this->db->query("UPDATE PatientAppointment SET status='declined' WHERE patientId= :patientId and appointId= :appointId;");

           // Bind values
           $this->db->bind(':patientId', $patientId);
           $this->db->bind(':appointId', $appointId); 

           if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

    
        public function AcceptPatientAppointment($patientId, $appointId) {
            //Prepare statement 
            $this->db->query("UPDATE PatientAppointment SET status='accepted' WHERE patientId= :patientId and appointId= :appointId;");

            // Bind values
            $this->db->bind(':patientId', $patientId);
            $this->db->bind(':appointId', $appointId); 

             if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function CancelPatientAppointment($patientId, $appointId) {
            //Prepare statement 
            $this->db->query("UPDATE PatientAppointment SET status='cancelled' WHERE patientId= :patientId and appointId= :appointId; ");
    
            // Bind values
            $this->db->bind(':patientId', $patientId);
            $this->db->bind(':appointId', $appointId); 

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    

        public function getTimePreferencesById($id) {
            // Prepare statment
            $this->db->query('SELECT * FROM TimePreference WHERE patientId = :id;');
            
            //Bind value
            $this->db->bind(':id', $id);

            // Get results
            $result = $this->db->resultSet();
            return $result;
        }

        public function getDistanceById($id) {
            // Prepare statment
            $this->db->query('SELECT distancepreference FROM Patient WHERE patientId = :id;');
            
            //Bind value
            $this->db->bind(':id', $id);

            // Get result
            $result = $this->db->single();
            return $result;

        }

        public function createTime($data){
            $this->db->query('INSERT INTO TimePreference VALUES ( :patientId, :timeblock, :day);');

            $this->db->bind(':patientId', $data['patientId']);
            $this->db->bind(':timeblock', $data['timeblock']);
            $this->db->bind(':day', $data['day']);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            } 
        }

        public function deleteTime($patientId, $timeblock, $day){
            $this->db->query('DELETE FROM TimePreference WHERE patientId = :patientId and timeblock =:timeblock and day =:day');

            $this->db->bind(':patientId', $patientId);
            $this->db->bind(':timeblock', $timeblock);
            $this->db->bind(':day', $day);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function updateDistance($data) {
            //Prepare statement 
           $this->db->query("UPDATE Patient SET distancepreference=:distance WHERE patientId= :patientId; ");

           // Bind values
           $this->db->bind(':patientId', $data['patientId']);
           $this->db->bind(':distance', $data['distancepreference']); 

           if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
