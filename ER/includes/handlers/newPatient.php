<?php
require '../../../config/config.php';

//Declaring variables to prevent errors
$id = ""; 
$fname = ""; //First Name
$lname = ""; //Last Name
$address = ""; //Address
$phone = ""; //Phone number 

if(isset($_POST['register_patient'])){
	//Registration form values

	//id
	$id = strip_tags($_POST['reg_id']); //Remove html tags
	$id = str_replace(' ', '', $id); //remove spaces
	$id = ucfirst(strtolower($id)); //Uppercase first letter
	$_SESSION['reg_id'] = $id; //Stores id into session variable

	//First Name
	$fname = strip_tags($_POST['reg_fname']); //Remove html tags
	$fname = str_replace(' ', '', $fname); //remove spaces
	$fname = ucfirst(strtolower($fname)); //Uppercase first letter
	$_SESSION['reg_fname'] = $fname; //Stores first name into session variable

    //Last Name
	$lname = strip_tags($_POST['reg_lname']); //Remove html tags
	$lname = str_replace(' ', '', $lname); //remove spaces
	$lname = ucfirst(strtolower($lname)); //Uppercase first letter
	$_SESSION['reg_lname'] = $lname; //Stores last name into session variable

	//Address
	$address = strip_tags($_POST['reg_address']); //Remove html tags
	$address = str_replace(' ', '', $address); //remove spaces
	$address = ucfirst(strtolower($address)); //Uppercase first letter
	$_SESSION['reg_address'] = $address; //Stores address into session variable

    //Phone
	$phone = strip_tags($_POST['reg_phone']); //Remove html tags
	$phone = str_replace(' ', '', $phone); //remove spaces
	$phone = ucfirst(strtolower($phone)); //Uppercase first letter
	$_SESSION['reg_phone'] = $phone; //Stores phone into session variable

    $closed = "yes";
    $name = $fname . " " . $lname;
	
		$query = mysqli_query($con, "INSERT INTO patients VALUES ('$id', '$name', '$phone', '$address', '$closed')");

        if(!$query){
            echo "Error: " . mysqli_error($con);
        }


}

	$_SESSION['reg_fname'] = "";
	$_SESSION['reg_lname'] = "";
    $_SESSION['reg_id'] = "";
	$_SESSION['reg_phone'] = "";
	$_SESSION['reg_address'] = "";

	header("Location: ../../index.php");
	exit();

?>




