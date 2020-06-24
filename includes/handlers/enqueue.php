<?php

require '../../config/config.php';

//Declaring variables to prevent errors
$id = ""; 
$doctorID = ""; //First Name

//Start clock
if(isset($_POST['enqueue_patient'])){
	//Registration form values

	//id
	$id = strip_tags($_POST['enqueue_id']); //Remove html tags
	$id = str_replace(' ', '', $id); //remove spaces
	$id = ucfirst(strtolower($id)); //Uppercase first letter
	$_SESSION['enqueue_id'] = $id; //Stores id into session variable

	//Doctor's name
	$doctorName = strip_tags($_POST['selected_text']); //Remove html tags
	$doctorName = str_replace(' ', '', $doctorName); //remove spaces
	$_SESSION['selected_text'] = $doctorName; //Stores first name into session variable

	$docSSN = mysqli_query($con, "SELECT ssn FROM employees WHERE lname='$doctorName'");
	
	if(!$docSSN){
		echo "Error: " . mysqli_error($con);
	}

	//Get the doctor's queue name
	$row = mysqli_fetch_array($docSSN);
	$doctorID = $row['ssn'];
    $queueName = 'q' . $row['ssn'];
	
	//Run the simulation

	$outPutFile_Dir = "../../simulation/" . $queueName . "/" . "input.txt";
	$outPutFile = fopen($outPutFile_Dir, "a") or die("Unable to open file");

	$query = mysqli_query($con, "SELECT * FROM $queueName ORDER By ts ASC");
	if(!$query){
		echo "Error (Read doctor queue enqueu.php): " . mysqli_error($con);
	}

	$pid = 0;
	while($row = mysqli_fetch_array($query)){
		$pid++;
		$line = $pid . " " . $row['arrivalTime'] . " " . $row['serviceTime'] . " " . $row['departureTime'] . " " . $row['waitingTime'] . " " . $row['tsb'] . " " . $row['timeInSystem'] . "\n";  
        fwrite($outPutFile, $line);
    }

	fclose($outPutFile);

	//Insert the patient into the queue with default performance measures
	$query = mysqli_query($con, "INSERT INTO $queueName VALUES ('$id', CURRENT_TIMESTAMP, 0,0,0,0,0,0)");

    if(!$query){
        echo "Error (insert in queue1): " . mysqli_error($con);
    }

	$query = mysqli_query($con, "INSERT INTO queue VALUES ('$id', '$doctorID')");

    if(!$query){
        echo "Error (insert in queue2): " . mysqli_error($con);
    }



	//Run the program

	$mode = "1";	//Simulation mode = arrival

	$simulation_Input_Dir = $queueName . "/";

	echo ("simulation/Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");
    shell_exec(dirname(dirname(dirname(__FILE__))) ."simulation/Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");

	//Read the updated performance measures
    $readFile = dirname(dirname(dirname(__FILE__))) . '\\' . 'simulation\\' . $queueName . '\\' . 'queue.txt';
    $fileContents = file_get_contents($readFile);
    $parameters = explode(',', $fileContents);

	//Update the PM's for the queue

	$query = mysqli_query($con, "SELECT * FROM $queueName ORDER By ts ASC");
	if(!$query){
		echo "Error (Read doctor queue enqueu.php): " . mysqli_error($con);
	}
	while($row = mysqli_fetch_array($query)){
		foreach($parameters as $param){
			$patientID = $row['patientID'];
			$query = mysqli_query($con, "UPDATE $queueName SET arrivalTime='$param[1]', serviceTime='$param[2]', departureTime='$param[3]', waitingTime='$param[4]', tsb='$param[5]', timeInSystem='$param[6]' WHERE patientID='$patientID'");
				if(!$query){
					echo "Error (Update queue parameters enqueue.php): " . mysqli_error($con);
				}
			}    
    }

    
}

//End
header("Location: ../../index.php");
exit();


?>




