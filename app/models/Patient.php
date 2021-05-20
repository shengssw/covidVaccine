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

        public function getexpireAppointment($id) {
            $this->db->query("SELECT * FROM PatientAppointment WHERE patientId= :id
            and now()>deadline and replyTime is null and status='pending';");

            // Bind values
            $this->db->bind(':id', $id);
            
            // Get results
            $result = $this->db->resultSet();
            return $result;
        }

        public function getAppointmentById($id) {
            $this->db->query("SELECT * From Appointment WHERE appointId= :appointId and Appointment.date > (curdate()+2) ;");

            $this->db->bind(':appointId', $id);

            // Get results
            $result = $this->db->single();
            return $result;
        }

        public function setexpireAppointment($id, $appointId) {
            $this->db->query("UPDATE PatientAppointment SET status='expired' WHERE patientId= :id and appointId= :appointId ;"); 
            $this->db->bind(':appointId', $appointId);
            $this->db->bind(':id', $id);

            if($this->db->execute()) {
                return true;
            } else {
                return false;
            }

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


        // Find match patient that is not current patient 
        public function findAnotherMatchPatient($patientId, $appointId, $date, $timeblocak) {
            $this->db->query("WITH T AS
            (Select patientId, latitude, longitude, distancepreference, qualifyTime, Patient.groupId
                FROM Patient LEFT JOIN Address on Patient.address = Address.address left join PriorityGroup on Patient.groupId = PriorityGroup.groupId
                Where patientId != :patientId and patientId in (
                Select patientId
                FROM TimePreference WHERE day = WEEKDAY(:d)+1
             and timeblock =:tb and patientId NOT IN
            (SELECT patientId
            from patientAppointment
            where status = 'pending' or status = 'accepted' or status = 'vaccinated' or appointId = :appointId))
            ORDER by Patient.groupId)

            SELECT T.patientId
            FROM T, (SELECT * From Appointment a natural join Provider p natural join Address WHERE a.appointId=:appointId ) AS R
            WHERE R.date >= T.qualifyTime and (T.distancepreference >= (6371 * acos( 
                cos( radians(T.latitude) ) 
              * cos( radians( R.latitude ) ) 
              * cos( radians( R.longitude ) - radians(T.longitude) ) 
              + sin( radians(T.latitude) ) 
              * sin( radians( R.latitude ) )
                ) ) or (6371 * acos( 
                cos( radians(T.latitude) ) 
              * cos( radians( R.latitude ) ) 
              * cos( radians( R.longitude ) - radians(T.longitude) ) 
              + sin( radians(T.latitude) ) 
              * sin( radians( R.latitude ) )
                ) ) is null)
            ");
            
            $this->db->bind(':patientId', $patientId);
            $this->db->bind(':appointId', $appointId);
            $this->db->bind(':d', $date);
            $this->db->bind(':tb', $timeblocak); 

            // execute
            $result = $this->db->single();
            return $result; 
        }



        public function findMatchAppointment($patientId) {
            $this->db->query("with T as
            (Select latitude, longitude, distancepreference, qualifyTime
            FROM Patient LEFT JOIN Address on Patient.address = Address.address left join PriorityGroup on Patient.groupId = PriorityGroup.groupId 
            Where patientId not in 
            (SELECT patientId
            from patientAppointment
            where status = 'pending' or status = 'accepted' or status = 'vaccinated') and patientId = :patientId
            )
            SELECT R.appointId
            FROM T, (SELECT * From Appointment a natural join Provider p natural join Address WHERE a.availability=1 and a.date>(curdate()+2) and a.appointId not in (
                select appointId from PatientAppointment where patientId = :patientId and status='declined' or status='cancelled')) AS R
            WHERE R.date >= T.qualifyTime and (T.distancepreference >= (6371 * acos( 
                cos( radians(T.latitude) ) 
              * cos( radians( R.latitude ) ) 
              * cos( radians( R.longitude ) - radians(T.longitude) ) 
              + sin( radians(T.latitude) ) 
              * sin( radians( R.latitude ) )
                ) ) or (6371 * acos( 
                cos( radians(T.latitude) ) 
              * cos( radians( R.latitude ) ) 
              * cos( radians( R.longitude ) - radians(T.longitude) ) 
              + sin( radians(T.latitude) ) 
              * sin( radians( R.latitude ) )
                ) ) is null) and (R.timeblock ,(weekday(R.date)+1)) in (SELECT timeblock, day from TimePreference where patientId = :patientId);");

            
            $this->db->bind(':patientId', $patientId);

             // execute
             $result = $this->db->single();
             return $result;
        }    
        
        public function findAnotherMatchAppointment($patientId, $appointId) {
            $this->db->query("with T as
            (Select latitude, longitude, distancepreference, qualifyTime
            FROM Patient LEFT JOIN Address on Patient.address = Address.address left join PriorityGroup on Patient.groupId = PriorityGroup.groupId 
            Where patientId not in 
            (SELECT patientId
            from patientAppointment
            where status = 'pending' or status = 'accepted' or status = 'vaccinated') and patientId = :patientId
            )
            SELECT R.appointId
            FROM T, (SELECT * From Appointment a natural join Provider p natural join Address WHERE a.appointId != :appointId and a.availability=1 and a.date>(curdate()+2) and a.appointId not in (
                select appointId from PatientAppointment where patientId = :patientId and status='declined' or status='cancelled') ) AS R
            WHERE R.date >= T.qualifyTime and (T.distancepreference >= (6371 * acos( 
                cos( radians(T.latitude) ) 
              * cos( radians( R.latitude ) ) 
              * cos( radians( R.longitude ) - radians(T.longitude) ) 
              + sin( radians(T.latitude) ) 
              * sin( radians( R.latitude ) )
                ) ) or (6371 * acos( 
                cos( radians(T.latitude) ) 
              * cos( radians( R.latitude ) ) 
              * cos( radians( R.longitude ) - radians(T.longitude) ) 
              + sin( radians(T.latitude) ) 
              * sin( radians( R.latitude ) )
                ) ) is null) and (R.timeblock ,(weekday(R.date)+1)) in (SELECT timeblock, day from TimePreference where patientId = :patientId);");

            
            $this->db->bind(':patientId', $patientId);
            $this->db->bind(':appointId', $appointId);

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

     
        public function declinePatientAppointment($patientId, $appointId) {
           //Prepare statement 
           $this->db->query("UPDATE PatientAppointment SET status='declined', replyTime=now() WHERE patientId= :patientId and appointId= :appointId;");

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
            $this->db->query("UPDATE PatientAppointment SET status='accepted', replyTime=now() WHERE patientId= :patientId and appointId= :appointId;");

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

        public function locktable($tablename){
            $this->db->query("LOCK TABLES :table WRITE;");
            $this->db->bind(':table', $tablename);
 
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } 

        public function unlocktable($tablename){
            $this->db->query("UNLOCK TABLES;");
 
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }
