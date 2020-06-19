<?php 

require 'config/config.php';
$id = $_POST["pid"];


if($con){
    //echo "connected....!";
    $q = "DELETE FROM queue WHERE patientID = '$id'";
    mysqli_query($con, $q);
    echo "Dequeued successfully!" ;
    }

?>