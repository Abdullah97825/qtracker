<?php

require '../../../config/config.php';

//Declaring variables to prevent errors
$id = ""; 
$doctorID = ""; //First Name
$category = '';


if(isset($_POST['enqueue_patient'])){
	//Registration form values

	//id
	$id = strip_tags($_POST['enqueue_id']); //Remove html tags
	$id = str_replace(' ', '', $id); //remove spaces
	$id = ucfirst(strtolower($id)); //Uppercase first letter
	$_SESSION['enqueue_id'] = $id; //Stores id into session variable

	//Doctor's name
	//$maker = mysql_real_escape_string($_POST['selected_text']);
	$category = strip_tags($_POST['category']); //Remove html tags
	$category = str_replace(' ', '', $category); //remove spaces
	$_SESSION['selected_text'] = $category; //Stores first name into session variable


    $queueName = 'er_' . $category;

		$query = mysqli_query($con, "INSERT INTO er_q VALUES ('$id', '$category', CURRENT_TIMESTAMP)");

        if(!$query){
            echo "Error (insert in er_q): " . mysqli_error($con);
        }

		$query = mysqli_query($con, "INSERT INTO $queueName VALUES ('$id', CURRENT_TIMESTAMP)");

        if(!$query){
            echo "Error (insert in category queue): " . mysqli_error($con);
        }

		


}

header("Location: ../../index.php");
exit();


?>




