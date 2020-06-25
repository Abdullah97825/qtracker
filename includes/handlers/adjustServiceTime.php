<?php

//Connect to the database
require '../../config/config.php';

if(isset($_POST['adjust_service'])){

    if(isset($_SESSION['id']) And isset($_SESSION['docQueue']))
    {
        $id = $_SESSION['id'];
        $queueName = $_SESSION['docQueue'];
    }
    else{
        //patient id
        $id = strip_tags($_POST['remove_id']); //Remove html tags
        $id = str_replace(' ', '', $id);       //remove spaces

        $queueName = strip_tags($_POST['doc_queue']); //Remove html tags
        $queueName = str_replace(' ', '', $queueName);//remove spaces
    }

	//Get new ammount
	$amountStr = strip_tags($_POST['amount']);
    $amount = (int)$amountStr;

	echo "sent: " . "doc: " . $queueName . " and amount: " . $amount;

	$query = mysqli_query($con, "SELECT * FROM $queueName ORDER By ts ASC");
	if(!$query){
		echo "Error (Read doctor queue enqueu.php): " . mysqli_error($con);
	}

	while($row = mysqli_fetch_array($query)){
		$patientID = $row['patientID'];
		$waitingTime = $row['waitingTime'];

		$newTime = $waitingTime + $amount;

		$query2 = mysqli_query($con, "UPDATE $queueName SET waitingTime='$newTime' WHERE patientID='$patientID'");
		if(!$query2){
			echo "Error (Update waitingTime adjustServiceTime.php): " . mysqli_error($con);
		}

    }



	//Simulation Part
	$outPutFile_Dir = $queueName . "/" . "input.txt";
	$outPutFile = fopen($outPutFile_Dir, "w") or die("Unable to open file");

	$query = mysqli_query($con, "SELECT * FROM $queueName ORDER By ts ASC");
	if(!$query){
		echo "Error (Read doctor queue SwitchQ.php): " . mysqli_error($con);
	}

	$pid = 0;
	while($row = mysqli_fetch_array($query)){
		$pid++;
		$line = $pid . " " . $row['arrivalTime'] . " " . $row['serviceTime'] . " " . $row['departureTime'] . " " . $row['waitingTime'] . " " . $row['tsb'] . " " . $row['timeInSystem'] . "\n";  
        fwrite($outPutFile, $line);
    }

	fclose($outPutFile);

    //Run the simulation program

	$mode = "3";	//Simulation mode = departure

	$simulation_Input_Dir = $queueName . "/";

	echo ("Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");
    shell_exec("Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");


	//Read the updated performance measures

	$readFile = $queueName . '/' . 'queue.txt';


	//Open queue.txt file to get the updated queue
	$queueFile = fopen($readFile, "r") or die("Unable to open queue.txt");

	if ($queueFile) {

		$query = mysqli_query($con, "SELECT * FROM $queueName ORDER By ts ASC");
		if(!$query){
			echo "Error (Read doctor queue enqueue.php): " . mysqli_error($con);
		}

    	while (($line = fgets($queueFile)) !== false) {
        	// process the line read.
			$parameters = explode(',', $line);
			$row = mysqli_fetch_array($query);
			$patientID = $row['patientID'];
			echo "\nID is: " . $patientID;
			$query2 = mysqli_query($con, "UPDATE $queueName SET arrivalTime='$parameters[1]', serviceTime='$parameters[2]', departureTime='$parameters[3]', waitingTime='$parameters[4]', tsb='$parameters[5]', timeInSystem='$parameters[6]' WHERE patientID='$patientID'");
			if(!$query2){
				echo "Error (Update queue parameters enqueue.php): " . mysqli_error($con);
			}
			echo "params: " . ($parameters[1] . "-" .$parameters[2] . "-" .$parameters[3]. "-" . $parameters[4]. "-" .$parameters[5]. "-" .$parameters[6]);

    	}


	}



/*
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

    //Run the simulation program

	$mode = "2";	//Simulation mode = departure

	$simulation_Input_Dir = $queueName . "/";

	echo ("simulation/Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");
    shell_exec(dirname(dirname(dirname(__FILE__))) ."simulation/Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");

    //Delete patient from the doctor's queue
	$query = mysqli_query($con, "DELETE FROM $queueName WHERE patientID='$id'");

    //Delete patient from the general queue
    $query = mysqli_query($con, "DELETE FROM queue WHERE patientID='$id'");

	//Read the updated queue and performance measures
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



$_SESSION['id'] = "";
$_SESSION['docQueue'] = "";
*/
//header("Location: ../../doctor.php");
}
exit();

?>


