<?php 

require 'config/config.php';
$id = $_POST["pid"];


if($con){
    //echo "connected....!";
    $docs = mysqli_query($con, "SELECT * FROM queue WHERE patientID='$id'");
    $row = mysqli_fetch_array($docs);
    $docID = $row['doctor'];
    $tableName = "q" . $docID; 

    $q1 = "DELETE FROM ".$tableName." WHERE patientID = '$id'";
    $q2 = "DELETE FROM queue WHERE patientID = '$id'";
    mysqli_query($con, $q1);
    mysqli_query($con, $q2);
    //echo "Dequeued successfully!" ;
    echo $tableName ;
    }

?>
