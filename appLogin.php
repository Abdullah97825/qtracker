<?php 

require 'config/config.php';

$email = $_POST["email"];
$password = $_POST["password"];


if($con){
    //echo "connected";

    $q = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $s = "SELECT * FROM users INNER JOIN queue ON users.id = queue.patientID WHERE users.email='$email'";

    $result = mysqli_query($con, $q);
    $result2 = mysqli_query($con, $s);

    if(mysqli_num_rows($result) > 0){
        if(mysqli_num_rows($result2) > 0){
            echo "login successful 1";

        }
        else{
            echo "login successful 0";
        }
        
        
    } else {
        echo "login failed";
    }
}

?>
