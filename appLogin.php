<?php 

require 'config/config.php';

$email = $_POST["email"];
$password = $_POST["password"];


if($con){
    //echo "connected....!";

    $q = "SELECT * FROM users WHERE email='$email' AND password='$password'";

    $result = mysqli_query($con, $q);

    if(mysqli_num_rows($result) > 0){
        echo "login successful";
    } else {
        echo "login failed";
    }
}

?>