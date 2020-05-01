<?php  

$error_array = array();

if(isset($_POST['login_button'])) {

	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //sanitize email

	$_SESSION['log_email'] = $email; //Store email into session variable 
	$password = md5($_POST['log_password']); //Get password


	$check_database_query = mysqli_query($con, "SELECT * FROM doctors WHERE email='$email' AND password='$password'");
	$check_login_query = mysqli_num_rows($check_database_query);
	if($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);
		$username = $row['email'];

		$_SESSION['emailDoc'] = $username;
		header("Location: doctor.php");
		exit();
	}

	$check_database_query = mysqli_query($con, "SELECT * FROM receptionists WHERE email='$email' AND password='$password'");
	$check_login_query = mysqli_num_rows($check_database_query);
	if($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);
		$username = $row['email'];

		$_SESSION['email'] = $username;
		header("Location: index.php");
		exit();
	}

	$check_database_query = mysqli_query($con, "SELECT * FROM er_doctors WHERE email='$email' AND password='$password'");
	$check_login_query = mysqli_num_rows($check_database_query);
	if(!$check_database_query){
		echo "Error " . mysqli_error($con);
	}
	if($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);
		$username = $row['email'];

		$_SESSION['emailDoc'] = $username;
		header("Location: ER/doctor.php");
		exit();
	}

	$check_database_query = mysqli_query($con, "SELECT * FROM er_receptionists WHERE email='$email' AND password='$password'");
	$check_login_query = mysqli_num_rows($check_database_query);
	if($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);
		$username = $row['email'];

		$_SESSION['email'] = $username;
		header("Location: ER/index.php");
		exit();
	}

	else {
		array_push($error_array, "Email or password was incorrect<br>");
	}


}

?>