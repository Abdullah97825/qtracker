<?php 

require 'config/config.php';
require_once(__DIR__.'/includes/classes/Patient.php');
require_once(__DIR__.'/includes/classes/Queue.php');

$email = $_POST["email"];
$password = $_POST["password"];


if($con){
    //echo "connected....!";
    $result = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    if(!$result){
        echo "Error: " . mysqli_error($con);
    }

    $row = mysqli_fetch_array($result);
    $patientID = $row['patientID'];

    $result = mysqli_query($con, "SELECT * FROM queue WHERE patientID='$patientID'");        

    //Check if patient is any queue
    if(mysqli_num_rows($result) > 0){
        //Patient is in queue
        //Return queue information to the app
        $q = new Queue($con, $result['patientID'], $result['doctor']);
        echo $q->getPeopleAhead() . ',' . $q->getExpectedWaitTime() . ',' . $q->getServiceTime();

    } else {
        //Patient is not in queue
        echo "0";
    }
    

}

?>