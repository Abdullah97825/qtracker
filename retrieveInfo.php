<?php 

require 'config/config.php';
require_once(__DIR__.'/includes/classes/Patient.php');
require_once(__DIR__.'/includes/classes/Queue.php');

$email = $_POST["email"];
$password = $_POST["password"];


if($con){
    //echo "connected";
    $result = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    if(!$result){
        echo "Error: " . mysqli_error($con);
    }

    $row = mysqli_fetch_array($result);
    $patientID = $row['id'];

    $result = mysqli_query($con, "SELECT * FROM queue WHERE patientID='$patientID'");       

    //Check if patient is any queue
    if(mysqli_num_rows($result) > 0){
        //Patient is in a queue
        //Return queue information to the app
        $row = mysqli_fetch_array($result); 
        $q = new Queue($con, $row['patientID'], $row['doctor']);
        echo $q->getPeopleAhead() . ',' . $patientID . ',' . $q->getServiceTime(). ',' . $q->getWaitingTime(). ',' . $q->getTimeInSystem();

    }
    

}


?>
