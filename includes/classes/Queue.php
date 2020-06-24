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
		    $this->queueEntries = mysqli_query($con, "SELECT * FROM $qName ORDER BY ts");
        }

        public function getPeopleAhead() {
            
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

        /*public function getWaitingTime(){
            return 122;
        }

        public function getTimeInSystem(){
            return 137;
        }*/

        public function getWaitingTime(){
            $qName = 'q' . $this->ssn;
            $this->queueEntries = mysqli_query($this->con, "SELECT * FROM $qName WHERE patientID='$this->pID'");
            $row = mysqli_fetch_array($this->queueEntries);
            $waitingTime = $row['waitingTime'];

            return($waitingTime);

        }

	    public function getTimeInSystem(){
            $qName = 'q' . $this->ssn;
            $this->queueEntries = mysqli_query($this->con, "SELECT * FROM $qName WHERE patientID='$this->pID'");
            $row = mysqli_fetch_array($this->queueEntries);
            $timeInSystem = $row['timeInSystem'];

            return($timeInSystem);
        }

    }


?>
