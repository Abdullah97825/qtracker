<?php

require '../../config/config.php';

//Declaring variables to prevent errors
$id = ""; 
$doctorID = ""; //First Name


if(isset($_POST['enqueue_patient'])){
	//Registration form values

	//id
	$id = strip_tags($_POST['enqueue_id']); //Remove html tags
	$id = str_replace(' ', '', $id); //remove spaces
	$id = ucfirst(strtolower($id)); //Uppercase first letter
	$_SESSION['enqueue_id'] = $id; //Stores id into session variable

	//Doctor's name
	//$maker = mysql_real_escape_string($_POST['selected_text']);
	$doctorName = strip_tags($_POST['selected_text']); //Remove html tags
	$doctorName = str_replace(' ', '', $doctorName); //remove spaces
	$_SESSION['selected_text'] = $doctorName; //Stores first name into session variable

	$docSSN = mysqli_query($con, "SELECT ssn FROM employees WHERE lname='$doctorName'");
	
	if(!$docSSN){
		echo "Error: " . mysqli_error($con);
	}

	$row = mysqli_fetch_array($docSSN);
    $queueName = 'q' . $row['ssn'];

		$query = mysqli_query($con, "INSERT INTO $queueName VALUES ('$id', CURRENT_TIMESTAMP, 0,0,0,0,0,0)");

        if(!$query){
            echo "Error (insert in queue1): " . mysqli_error($con);
        }

		$doctorID = $row['ssn'];
		$query = mysqli_query($con, "INSERT INTO queue VALUES ('$id', '$doctorID')");

        if(!$query){
            echo "Error (insert in queue2): " . mysqli_error($con);
        }

	//Run the simulation
	$outPutFile = fopen("output.txt", "a") or die("Unable to open file");

	$query = mysqli_query($con, "SELECT * FROM $queueName");
	if(!$query){
		echo "Error (Read doctor queue enqueu.php): " . mysqli_error($con);
	}

	while($row = mysqli_fetch_array($query)){
		$line = $row['patientID'] . "," . $row['arrivalTime'] . "," . $row['serviceTime'] . "," . $row['departureTime'] . "," . $row['waitingTime'] . "," . $row['tsb'] . "," . $row['timeInSystem'] . "\n";  
        fwrite($outPutFile, $line);
    }

	fclose($outPutFile);
}

header("Location: ../../index.php");
exit();


?>




