<?php
require 'config/config.php';
require 'includes/handlers/userType.php';
require 'includes/handlers/newDoctor.php';
require 'includes/handlers/newReceptionist.php';
require 'includes/handlers/newUser.php';
require 'includes/form_handlers/login_handler.php';


?>


<html>

<head>
    <title>Welcome to QTracker</title>
    <link rel="stylesheet" type="text/css" href="assets/css/login_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/login.js"></script>
</head>

<script>
	$(document).ready(function() {
		$("#first").show();
		$("#second").hide();
	});


</script>

<body>

<div class="wrapper">

    <div class="login_box">

        <div class="login_header">
            <h1>QTracker</h1>
        </div>
        <br>
        <div id="first">
            <form action="login.php" method="POST">
					<input type="email" name="log_email" placeholder="Email Address" value="<?php 
					if(isset($_SESSION['log_email'])) {
						echo $_SESSION['log_email'];
					} 
					?>" required>
					<br>
					<input type="password" name="log_password" placeholder="Password">
					<br>
                    <input type="submit" name="login_button" value="Login">
					<br>
                    <?php if(in_array("Email or password was incorrect<br>", $error_array)) echo "Email or password was incorrect<br>";?>
                    <a href="#" id="signup" class="signup">Need an account? Register here!</a>
                
                </form>
        </div>

        <div id="second">

				<form action="login.php" method="POST">
					<input type="text" name="reg_ssn" placeholder="SSN or ID" value="<?php 
					if(isset($_SESSION['reg_ssn'])) {
						echo $_SESSION['reg_ssn'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your SSN/ID must be between 2 and 25 characters<br>", $error_array)) echo "Your first ssn must be between 2 and 25 characters<br>"; ?>
					
					<input type="email" name="reg_email" placeholder="Email" value="<?php 
					if(isset($_SESSION['reg_email'])) {
						echo $_SESSION['reg_email'];
					} 
					?>" required>
					<br>

					<input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
					if(isset($_SESSION['reg_email2'])) {
						echo $_SESSION['reg_email2'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>"; 
					else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
					else if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>"; ?>


					<input type="password" name="reg_password" placeholder="Password" required>
					<br>
					<input type="password" name="reg_password2" placeholder="Confirm Password" required>
					<br>
					<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>"; 
					else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
					else if(in_array("Your password must be betwen 5 and 30 characters<br>", $error_array)) echo "Your password must be betwen 5 and 30 characters<br>"; ?>


					<input type="submit" name="register_button" value="Register">
					<br>

					<?php if(in_array("<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>", $error_array)) echo "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>"; ?>
					<a href="#" id="signin" class="signin">Already have an account? Sign in here!</a>
				</form>
			</div>


    </div>

</div>


</body>


</html>