<?php
require 'config/config.php';

    function getAvgVisitTime($con) {

        $sumOfAverages = 0;
        $n = 0;

        $result = mysqli_query($con, "SELECT * FROM doctors");
        if(!$result){
            echo "Error: " . mysqli_error($con);
        }

        while($row = mysqli_fetch_array($result)){
            $doctorID = $row['ssn'];
            $queueName = 'q' . $row['ssn'];

            $queueEntries = mysqli_query($con, "SELECT AVG(waitingTime) AS average FROM $queueName ");
            $row2 = mysqli_fetch_array($queueEntries);

            $sumOfAverages = $sumOfAverages + $row2['average'];
            $n = $n + 1;

        }

        return($sumOfAverages/$n);
    }

    if($con){

       echo getAvgVisitTime($con);
    }

?>
