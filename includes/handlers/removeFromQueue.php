<?php

//Connect to the database
require '../../config/config.php';

if(isset($_POST['remove_Patient'])){

    if(isset($_SESSION['id']) And isset($_SESSION['docQueue']))
    {
        $id = $_SESSION['id'];
        $queueName = $_SESSION['docQueue'];
    }
    else{
        //patient id
        $id = strip_tags($_POST['remove_id']); //Remove html tags
        $id = str_replace(' ', '', $id);       //remove spaces

        //Get the rows from the database
        //$result = mysqli_query($con, "SELECT * FROM queue WHERE patientID='$patientID'");

        //Get the first row
        //$row = mysqli_fetch_array($result);   

        //Get the doctor's queue name
        //$queueName = 'q' . $row['doctor'];
        $queueName = strip_tags($_POST['doc_queue']); //Remove html tags
        $queueName = str_replace(' ', '', $queueName);//remove spaces
    }

    //Delete patient from the doctor's queue
	$query = mysqli_query($con, "DELETE FROM $queueName WHERE patientID='$id'");

    //Delete patient from the general queue
    $query = mysqli_query($con, "DELETE FROM queue WHERE patientID='$id'");

/*
    //Run the simulation
    $outPutFile = fopen("input.txt", "a") or die("Unable to open file");

    $query = mysqli_query($con, "SELECT * FROM $queueName");
	if(!$query){
		echo "Error (Read doctor queue enqueu.php): " . mysqli_error($con);
	}

	while($row = mysqli_fetch_array($query)){
		$line = $row['patientID'] . " " . $row['arrivalTime'] . " " . $row['serviceTime'] . " " . $row['departureTime'] . " " . $row['waitingTime'] . " " . $row['tsb'] . " " . $row['timeInSystem'] . "\n";  
        fwrite($outPutFile, $line);
    }

	fclose($outPutFile);

    //Run the program
    shell_exec("simulation/untitled1.exe");
    sleep(1);

    $readFile = "queue.txt";
    $fileContents = file_get_contents($readFile);
    $parameters = explode(',', $fileContents);

    foreach($parameters as $param){
        $query = mysqli_query($con, "UPDATE $queueName SET arrivalTime='$param[1]', serviceTime='$param[2]', departureTime='$param[3]', waitingTime='$param[4]', tsb='$param[5]', timeInSystem='$param[6]' WHERE patientID='$param[0]'");
        if(!$query){
            echo "Error (Update queue parameters enqueue.php): " . mysqli_error($con);
        }
    }    
*/
}



$_SESSION['id'] = "";
$_SESSION['docQueue'] = "";

header("Location: ../../doctor.php");
exit();

?>


