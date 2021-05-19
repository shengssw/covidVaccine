<?php

    class Provider {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getProvider($id) {
            // Prepare statement 
            $this->db->query("SELECT * FROM Provider WHERE providerId=:id;");

            $this->db->bind(':id', $id);

            // Get results
            $result = $this->db->resultSet();
            return $result;
        }

        public function getAllProviderAppointmentsById($id) {
            //Prepare statement 
            $this->db->query("SELECT * FROM Appointment WHERE providerId= :id;");

            // Bind values
            $this->db->bind(':id', $id);

            // Get results
            $result = $this->db->resultSet();
            return $result;
        }

        public function getCurrentMaxId(){
            //appointment
            $this->db->query("SELECT max(appointId) m FROM Appointment;");
            // execute
            $result = $this->db->single();
            return $result; 
        }

        public function addapps($data)
        {
          
            $this->db->query("INSERT INTO Appointment VALUES (:appoint, :providerId, :d, :tb, 1);");
            $this->db->bind(':appoint', $data['appointId']);
            $this->db->bind(':providerId', $data['providerId']);
            $this->db->bind(':d', $data['date']);
            $this->db->bind(':tb', $data['timeblock']); 
        
            // execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }   
            
        }

        // Find match patient when inserting a new appointment 
        public function findMatchPatient($appointId, $date, $timeblocak) {
            $this->db->query("WITH T AS
            (Select patientId, latitude, longitude, distancepreference, qualifyTime
                FROM Patient LEFT JOIN Address on Patient.address = Address.address left join PriorityGroup on Patient.groupId = PriorityGroup.groupId
                Where patientId in (
                Select patientId
                FROM TimePreference WHERE day = WEEKDAY(:d)+1
             and timeblock =:tb and patientId NOT IN
            (SELECT patientId
            from patientAppointment
            where status = 'pending' or status = 'accepted' or status = 'vaccinated')))
            SELECT T.patientId
            FROM T, (SELECT * From Appointment a natural join Provider p natural join Address WHERE a.appointId=:appointId ) AS R
            WHERE R.date >= T.qualifyTime and T.distancepreference >= (6371 * acos( 
                            cos( radians(T.latitude) ) 
                          * cos( radians( R.latitude ) ) 
                          * cos( radians( R.longitude ) - radians(T.longitude) ) 
                          + sin( radians(T.latitude) ) 
                          * sin( radians( R.latitude ) )
                            ) );
            ");
            
            $this->db->bind(':appointId', $appointId);
            //$this->db->bind(':pr', $data['providerId']);
            $this->db->bind(':d', $date);
            $this->db->bind(':tb', $timeblocak); 

            // execute
            $result = $this->db->single();
            return $result; 
        }

        // Insert the new patientAppointment into table
        public function insertNewPatientAppointment($patientId, $appointId) {
            $this->db->query('INSERT INTO PatientAppointment VALUES(:appoint, :patient, NOW(), DATE_ADD(NOW(), INTERVAL 2 day), null, "pending");');
            $this->db->bind(':appoint', $appointId);
            $this->db->bind(':patient', $patientId);

            // execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }   

        }

        // Update the appointment availability
        public function updateAppointment($appointId)
        {
            $this->db->query("UPDATE Appointment SET availability=0 WHERE appointId =:app;");

            $this->db->bind(':app',$appointId);

            // execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }    
        }



    }