<?php 

require '../../config/config.php';
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


    //Print the queue to the input.txt file
    $outPutFile_Dir = $tableName . "/" . "input.txt";
	$outPutFile = fopen($outPutFile_Dir, "w") or die("Unable to open file");

	$query = mysqli_query($con, "SELECT * FROM $tableName ORDER By ts ASC");
	if(!$query){
		echo "Error (Read doctor queue Dequeue.php): " . mysqli_error($con);
	}

	$pid = 0;
	while($row = mysqli_fetch_array($query)){
		$pid++;
		$line = $pid . " " . $row['arrivalTime'] . " " . $row['serviceTime'] . " " . $row['departureTime'] . " " . $row['waitingTime'] . " " . $row['tsb'] . " " . $row['timeInSystem'] . "\n";  
        fwrite($outPutFile, $line);
    }

	fclose($outPutFile);


    //Run the program

	$mode = "4";	//Simulation mode = Line number Cancellation

	$simulation_Input_Dir = $tableName . "/";

	echo ("Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");

	shell_exec("Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");
	sleep(1);

	$readFile = $tableName . '/' . 'queue.txt';

	$queueFile = fopen($readFile, "r") or die("Unable to open queue.txt");

	if ($queueFile) {

		$query = mysqli_query($con, "SELECT * FROM $tableName ORDER By ts ASC");
		if(!$query){
			echo "Error (Read doctor queue enqueue.php): " . mysqli_error($con);
		}

    	while (($line = fgets($queueFile)) !== false) {
        	// process the line read.
			$parameters = explode(',', $line);
			$row = mysqli_fetch_array($query);
			$patientID = $row['patientID'];
			$query2 = mysqli_query($con, "UPDATE $tableName SET arrivalTime='$parameters[1]', serviceTime='$parameters[2]', departureTime='$parameters[3]', waitingTime='$parameters[4]', tsb='$parameters[5]', timeInSystem='$parameters[6]' WHERE patientID='$patientID'");
			if(!$query2){
				echo "Error (Update queue parameters enqueue.php): " . mysqli_error($con);
			}

    	}


	}


    }

?>
