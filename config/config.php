<?php

ob_start();
session_start();

$timeZone = date_default_timezone_set("Asia/Nicosia");

$con = mysqli_connect("localhost", "root", "", "QTracker");

if(mysqli_connect_errno()){
    echo "Failed to connect" . mysqli_connect_errno();
}


?>