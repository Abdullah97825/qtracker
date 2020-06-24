<?php

//Connect to the database
require '../../config/config.php';

if(isset($_POST['add_post'])){

    if(isset($_SESSION['id']) And isset($_SESSION['doctorSSN']))
    {
        $patientID = $_SESSION['id'];
        $doctorSSN = $_SESSION['doctorSSN'];
        $note = $_SESSION['note'];
    }

    $query = mysqli_query($con, "INSERT INTO posts VALUES ('$id', '$doctorSSN', '$note', CURRENT_TIMESTAMP)");
	
	if(!$query){
		echo "Error: " . mysqli_error($con);
	}

}



$_SESSION['id'] = "";
$_SESSION['doctorSSN'] = "";
$_SESSION['note'] = "";

header("Location: ../../doctor.php");
exit();

?>