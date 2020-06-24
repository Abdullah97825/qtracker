<?php

    class Doctor
    {
        private $ssn;
        private $con;
        private $fname;
        private $lname;
        private $email;
        private $doc;
        
        public function __construct($con, $ssn)
        {
            $this->con = $con;
		    $ssn_details_query = mysqli_query($con, "SELECT * FROM employees WHERE ssn='$ssn'");
		    $this->doc = mysqli_fetch_array($ssn_details_query);
        }

        public function getSSN() {
            return $this->doc['ssn'];
        }

        public function getEmail() {
            $ssn = $this->doc['ssn'];
            $email_details_query = mysqli_query($this->con, "SELECT * FROM doctors WHERE ssn='$ssn'");
            $this->email = mysqli_fetch_array($email_details_query);
            return $this->email['email'];
        }


        public function getAvailability() {
            return $this->doc['available'];
        }

        public function getName(){
            return $this->doc['name'];
        }

        public function getLname(){
            return $this->doc['lname'];
        }

        public function getQueueName(){
            return ("q" . $this->getSSN());
        }

    }


?>