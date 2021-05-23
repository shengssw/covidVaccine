<?php
/**
 * Database query for Account/ register/ login
 * 
 * @author Sheng
 */

    class User {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function login($username, $password) {
            $this->db->query('SELECT * FROM Account WHERE username = :username');

            //Bind value
            $this->db->bind(':username', $username);
    
            $row = $this->db->single();
    
            $hashedPassword = $row->password;
    
            if (password_verify($password, $hashedPassword)) {
            //if ($password == $hashedPassword) {
                return $row;
            } else {
                return false;
            }
        }

        public function findPatient($id){
            $this->db->query('SELECT * FROM Patient WHERE patientId = :id');

            //Bind value
            $this->db->bind(':id', $id);
    
            $row = $this->db->single();
            return $row;

        }

        public function findProvider($id){
            $this->db->query('SELECT * FROM Provider WHERE providerId = :id');

            //Bind value
            $this->db->bind(':id', $id);
    
            $row = $this->db->single();
            return $row;
            
        }

        public function findIdByRoleId($id) {
           $this->db->query("SELECT * FROM Role WHERE roleId = :id;");
           $this->db->bind(':id', $id);
           // execute
           $result = $this->db->single();
           return $result;  
        }

        public function getCurrentMaxId($type){
            if ($type == 1) {
                //provider
                $this->db->query("SELECT max(providerId) m FROM Provider;");
                // execute
                $result = $this->db->single();
                return $result; 
            } else {
                //patient
                $this->db->query("SELECT max(patientId) m FROM Patient;");
                // execute
                $result = $this->db->single();
                return $result; 
            }

        }

        public function getCurrentMaxRoleId(){
            //patient
            $this->db->query("SELECT max(roleId) r FROM Role;");
            // execute
            $result = $this->db->single();
            return $result; 
        }

        public function insertRoleId($type, $roleId, $id) {
            if ($type == 1) {
                //provider
                $this->db->query("INSERT INTO Role VALUES (:roleId, null, :id);");
                $this->db->bind(':roleId', $roleId);
                $this->db->bind(':id', $id);
                // execute
                if ($this->db->execute()) {
                    return true;
                } else {
                    return false;
                } 
            } else {
                //patient
                $this->db->query("INSERT INTO Role VALUES (:roleId, :id, null);");
                $this->db->bind(':roleId', $roleId);
                $this->db->bind(':id', $id);
                // execute
                if ($this->db->execute()) {
                    return true;
                } else {
                    return false;
                } 
            }
        }

        public function checkAddress($add) {
            $this->db->query("SELECT * FROM Address WHERE address= :add;");
            $this->db->bind(':add', $add);
            // execute
            $result = $this->db->single();
            return $result; 
        }

        public function insertAddress($address,$la, $lo)
        {
            $this->db->query("INSERT INTO Address VALUES (:add, :la, :lo);");
                $this->db->bind(':add', $address);
                $this->db->bind(':la', $la);
                $this->db->bind(':lo', $lo); 
                // execute
                if ($this->db->execute()) {
                    return true;
                } else {
                    return false;
                }  
        
         }


         public function insertProvider($data)
         {
             $this->db->query("INSERT INTO Provider VALUES (:id, :na, :add, :ph, :pt);");
                 $this->db->bind(':id', $data['providerId']);
                 $this->db->bind(':na', $data['name']);
                 $this->db->bind(':add', $data['address']);
                 $this->db->bind(':ph', $data['phone']); 
                 $this->db->bind(':pt', $data['providerType']);  
                 // execute
                 if ($this->db->execute()) {
                     return true;
                 } else {
                     return false;
                 }  
         }


         public function insertPatient($data)
         {
             $this->db->query("INSERT INTO Patient VALUES (:id, :na, :dob, :ssn, :add, :ph, :email, 5, 0, null);");
                 $this->db->bind(':id', $data['patientId']);
                 $this->db->bind(':na', $data['name']);
                 $this->db->bind(':dob', $data['birthday']);
                 $this->db->bind(':ssn', $data['ssn']);
                 $this->db->bind(':add', $data['address']);
                 $this->db->bind(':ph', $data['phone']); 
                 $this->db->bind(':email', $data['email']);
                 if ($this->db->execute()) {
                     return true;
                 } else {
                     return false;
                 }  
         }

         public function insertAccount($data) {
            $this->db->query("INSERT INTO Account VALUES (:us, :pa, :ro);");
            $this->db->bind(':us', $data['username']);
            $this->db->bind(':pa', $data['password']);
            $this->db->bind(':ro', $data['roleId']);
            // execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }   
         }
    }

?>