<?php

    class Queue
    {
        private $ssn;
        private $con;
        private $pID;
        private $peopleAhead = 0;
        private $queueEntries;
        
        public function __construct($con, $pID, $ssn)
        {
            $this->pID = $pID;
            $this->ssn = $ssn;
            $qName = 'q' . $this->ssn;
    
            $this->con = $con;
		    $this->queueEntries = mysqli_query($con, "SELECT * FROM $qName ORDER BY ts ASC");
        }

        public function getPeopleAhead() {
            
            $this->queueEntries = mysqli_query($con, "SELECT * FROM $qName ORDER BY ts ASC");
            while($row = mysqli_fetch_array($this->queueEntries)){
                if($this->pID === $row['patientID']){
                    return $this->peopleAhead;
                }
                else{
                    $this->peopleAhead = $this->peopleAhead + 1;
                }
            }
        }

        public function getExpectedWaitTime(){
            return ($this->peopleAhead * 15);
        }

        public function getServiceTime(){
            return 15;
        }
	//public function getWaitingTime(){}
	//public function getTimeInSystem(){}

	    public function getWaitingTime(){
            $this->queueEntries = mysqli_query($con, "SELECT * FROM $qName WHERE patientID='$pID'");
            $row = mysqli_fetch_array($this->queueEntries);
            $waitingTime = $row['waitingTime'];

            return($waitingTime);

        }

	    public function getTimeInSystem(){
            $this->queueEntries = mysqli_query($con, "SELECT * FROM $qName WHERE patientID='$pID'");
            $row = mysqli_fetch_array($this->queueEntries);
            $timeInSystem = $row['timeInSystem'];

            return($timeInSystem);
        }

    }


?>
