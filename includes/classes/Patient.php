<?php

    class Patient
    {
        private $patient;
        private $con;
		private $email;
		private $doctorSSN;
        
        public function __construct($con, $patient)
        {
            $this->con = $con;
		    $patient_details_query = mysqli_query($con, "SELECT * FROM patients WHERE id='$patient'");
		    $this->patient = mysqli_fetch_array($patient_details_query);
        }

    public function getEmail() {
		$patient_email_query = mysqli_query($con, "SELECT * FROM users WHERE id='$patient'");
		$this->email = mysqli_fetch_array($patient_email_query);
		return $this->email['email'];
	}

	public function getID() {
		return $this->patient['id'];
	}

    public function getPhone() {
		return $this->patient['phone'];
	}

	public function getName() {
		return $this->patient['name'];
	}

	public function getDoctorSSN(){
		$patient_queue_ssn = mysqli_query($con, "SELECT * FROM queue WHERE patientID='$patient'");
		$this->doctorSSN = mysqli_fetch_array($patient_queue_ssn);
		return $this->doctorSSN['doctor'];
	}


    }


?>