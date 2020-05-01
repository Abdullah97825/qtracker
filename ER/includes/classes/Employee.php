<?php

    class 
    {
        private $Employee;
        private $con;
        
        public function __construct($con, $Employee)
        {
            $this->con = $con;
		    $Employee_details_query = mysqli_query($con, "SELECT * FROM employees WHERE ssn='$Employee'");
		    $this->Employee = mysqli_fetch_array($Employee_details_query);
        }

	public function getSSN() {
		return $this->Employee['ssn'];
	}

    public function getPhone() {
		return $this->Employee['phone'];
	}

	public function getName() {
		return $this->Employee['name'];
	}

    public function getLastName() {
		return $this->Employee['lname'];
	}

    public function getAddress() {
		return $this->Employee['address'];
	}

    public function getPosition() {
		return $this->Employee['position'];
	}


    }


?>