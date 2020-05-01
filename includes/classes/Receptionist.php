<?php

    class 
    {
        private $Receptionist;
        private $con;
        
        public function __construct($con, $Receptionist)
        {
            $this->con = $con;
		    $Receptionist_details_query = mysqli_query($con, "SELECT * FROM receptionists WHERE ssn='$Receptionist'");
		    $this->Receptionist = mysqli_fetch_array($Receptionist_details_query);
        }

	public function getSSN() {
		return $this->Receptionist['ssn'];
	}

    public function getEmail() {
		return $this->Receptionist['email'];
	}

    }


?>