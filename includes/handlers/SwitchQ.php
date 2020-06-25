<?php 

require '../../config/config.php';
$id = $_POST["pid"];
$name = $_POST["name"];
$lname = $_POST["lname"];


if($con){
    //echo "connected....!";
    //Implementation here.


    /**************Start of removal from old Queue*************************/

    $result = mysqli_query($con, "SELECT * FROM queue WHERE patientID='$id'");
    if(!$result){
		echo "Error (Read doctor info 1 SwitchQ.php): " . mysqli_error($con);
	}

    $oldRow = mysqli_fetch_array($result);

    $oldDoc = $oldRow['ssn'];
    $oldQueue = 'q' . $oldRow['ssn'];

    //Delete patient from the doctor's queue
	$query = mysqli_query($con, "DELETE FROM $oldQueue WHERE patientID='$id'");

    //Delete patient from the general queue
    $query = mysqli_query($con, "DELETE FROM queue WHERE patientID='$id'");

    $outPutFile_Dir = $oldQueue . "/" . "input.txt";
	$outPutFile = fopen($outPutFile_Dir, "w") or die("Unable to open file");

	$query = mysqli_query($con, "SELECT * FROM $oldQueue ORDER By ts ASC");
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

	$mode = "5";	//Simulation mode = departure

	$simulation_Input_Dir = $oldQueue . "/";

	echo ("Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");
    shell_exec("Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");


	//Read the updated performance measures

	$readFile = $oldQueue . '/' . 'queue.txt';


	//Open queue.txt file to get the updated queue
	$queueFile = fopen($readFile, "r") or die("Unable to open queue.txt");

	if ($queueFile) {

		$query = mysqli_query($con, "SELECT * FROM $oldQueue ORDER By ts ASC");
		if(!$query){
			echo "Error (Read doctor queue enqueue.php): " . mysqli_error($con);
		}

    	while (($line = fgets($queueFile)) !== false) {
        	// process the line read.
			$parameters = explode(',', $line);
			$row = mysqli_fetch_array($query);
			$patientID = $row['patientID'];
			echo "\nID is: " . $patientID;
			$query2 = mysqli_query($con, "UPDATE $oldQueue SET arrivalTime='$parameters[1]', serviceTime='$parameters[2]', departureTime='$parameters[3]', waitingTime='$parameters[4]', tsb='$parameters[5]', timeInSystem='$parameters[6]' WHERE patientID='$patientID'");
			if(!$query2){
				echo "Error (Update queue parameters enqueue.php): " . mysqli_error($con);
			}
			echo "params: " . ($parameters[1] . "-" .$parameters[2] . "-" .$parameters[3]. "-" . $parameters[4]. "-" .$parameters[5]. "-" .$parameters[6]);

    	}


	}

    /*****************End of removal from old queue**********************/









    //******************Insert into new Queue*****************************

    $query = mysqli_query($con, "SELECT * FROM employees WHERE name='$name' AND lname='$lname'");
	if(!$query){
		echo "Error (Read doctor info 2 SwitchQ.php): " . mysqli_error($con);
	}

    //Get the doctor's queue name
	$row = mysqli_fetch_array($query);
	$doctorID = $row['ssn'];
    $queueName = 'q' . $row['ssn'];

    //Run the simulation

    $id = $_POST["pid"];

	$outPutFile_Dir = $queueName . "/" . "input.txt";
	$outPutFile = fopen($outPutFile_Dir, "w") or die("Unable to open file");

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

	echo ("Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");

	shell_exec("Simulation.exe \"".$mode."\" \"".$simulation_Input_Dir."\"");
	sleep(1);
	
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





    echo "Switched successfully!" ;

    
    }

?>
