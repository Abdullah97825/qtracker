<?php

/*
//Declaring variables to prevent errors
$ssn = ""; //Social security number
$em = ""; //email
$em2 = ""; //email 2
$password = ""; //password
$password2 = ""; //password 2
$date = ""; //Sign up date 
$error_array = array(); //Holds error messages*/

if(isset($_POST['register_button']) && ($type === "receptionist")){

	//Registration form values

	//First name
	$ssn = strip_tags($_POST['reg_ssn']); //Remove html tags
	$ssn = str_replace(' ', '', $ssn); //remove spaces
	$ssn = ucfirst(strtolower($ssn)); //Uppercase first letter
	$_SESSION['reg_ssn'] = $ssn; //Stores first name into session variable

	//email
	$em = strip_tags($_POST['reg_email']); //Remove html tags
	$em = str_replace(' ', '', $em); //remove spaces
	$em = ucfirst(strtolower($em)); //Uppercase first letter
	$_SESSION['reg_email'] = $em; //Stores email into session variable

	//email 2
	$em2 = strip_tags($_POST['reg_email2']); //Remove html tags
	$em2 = str_replace(' ', '', $em2); //remove spaces
	$em2 = ucfirst(strtolower($em2)); //Uppercase first letter
	$_SESSION['reg_email2'] = $em2; //Stores email2 into session variable

	//Password
	$password = strip_tags($_POST['reg_password']); //Remove html tags
	$password2 = strip_tags($_POST['reg_password2']); //Remove html tags

	$date = date("Y-m-d"); //Current date

	if($em == $em2) {
		//Check if email is in valid format 
		if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			//Check if email already exists 
			$e_check = mysqli_query($con, "SELECT email FROM receptionists WHERE email='$em'");

			//Count the number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0) {
				array_push($error_array, "Email already in use<br>");
			}

		}
		else {
			array_push($error_array, "Invalid email format<br>");
		}


	}
	else {
		array_push($error_array, "Emails don't match<br>");
	}


	if(strlen($ssn) > 25 || strlen($ssn) < 2) {
		array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
	}

	if($password != $password2) {
		array_push($error_array,  "Your passwords do not match<br>");
	}
	else {
		if(preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Your password can only contain english characters or numbers<br>");
		}
	}

/*
	if(strlen($password > 30 || strlen($password) < 5)) {
		array_push($error_array, "Your password must be betwen 5 and 30 characters<br>");
	}*/


	if(empty($error_array)) {
		$password = md5($password); //Encrypt password before sending to database


		$query = mysqli_query($con, "INSERT INTO receptionists VALUES ('$ssn', '$em', '$password')");


		array_push($error_array, "<span style='color: #14C800;'>You have successfully been registered.</span><br>");

		//Clear session variables 
		$_SESSION['reg_ssn'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";
		$_SESSION['reg_password'] = "";
		$_SESSION['reg_password2'] = "";
	}

}
?>