<?php

    class Doctor
    {
        private $ssn;
        private $con;
        private $fname;
        private $lname;
        private $email;
        
        public function __construct($con, $ssn)
        {
            $this->con = $con;
		    $ssn_details_query = mysqli_query($con, "SELECT * FROM employees WHERE ssn='$ssn'");
		    $this->ssn = mysqli_fetch_array($ssn_details_query);
        }

        public function getSSN() {
            return $this->ssn['ssn'];
        }

        public function getEmail() {
            $email_details_query = mysqli_query($con, "SELECT * FROM doctors WHERE ssn='$ssn'");
            $this->email = mysqli_fetch_array($email_details_query);
            return $this->email['email'];
        }


        public function getAvailability() {
            return $this->ssn['available'];
        }

        public function getName(){
            return $this->ssn['name'];
        }

        public function getLname(){
            return $this->ssn['lname'];
        }

        public function getQueueName(){
            return (q . getSSN());
        }

    }


?>