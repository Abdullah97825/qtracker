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

    }


?>