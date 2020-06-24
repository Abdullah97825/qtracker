<?php 
    require 'config/config.php';
    require_once(__DIR__.'/includes/classes/Doctor.php');
    require_once(__DIR__.'/includes/classes/Patient.php');


    $patientID = $_GET['id'];

    //Get Patient info
    $patient = new Patient($con, $patientID);

    $patient_Name = $patient->getName();

    $query = mysqli_query($con, "SELECT * FROM posts WHERE patientID='$patientID' ORDER BY ts ASC");
	if(!$query){
		echo "Error (Couldnt fetch posts): " . mysqli_error($con);
	}



    
    //Get doctor info
    //$doc = new Doctor($con, $patientID, $docID);
    
    //$doc_Name = $doc->getName();
    //$doc_Lname = $doc->getLname();



?>

    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width = device-width, initial-scale=1.0">
        <title>Patient Profile</title>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/profilePage.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="navBar">
        <div class="navItems">
            <h1>QTracker Patient Profile</h1>
        </div>
        </div>
        <div class="pageWrapper">
        <div class="profileCard">
            <div class="upper-container">
            <div class="image-container">
                <img src="assets/css/profile.jpg" alt="Profile Picture">
            </div>
            </div>
            <div class="lower-container">
            <div class="line">
                <h3>Name: </h3>
                <h3><?php echo $patient_Name ?></h3>
            </div>
            <div class="line">
                <h4>Gender: </h4>
                <h4> Male</h4>
            </div>
            <div class="line">
                <h4>Age: </h4>
                <h4> 32</h4>
            </div>
            <div class="line">
                <h4>Address: </h4>
                <h4> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h4>
            </div>
            </div>
        </div>
        <div class="timeline">
            <div class="timeline-body">

            <?php
                while($row = mysqli_fetch_array($query)){
                    //Get doctor info
                    $time = $row['ts'];
                    $note = $row['note'];
                    $docID = $row['ssn'];

                    $doc_details_query = mysqli_query($con, "SELECT * FROM employees WHERE ssn='$docID'");
		            $doc = mysqli_fetch_array($doc_details_query);

                    $doc_Name = $doc['name'];
                    $doc_Lname = $doc['lname'];
                    $docName = $doc_Name . " " . $doc_Lname;

                    /*
                    $doc = new Doctor($con, $patientID, $docID);                    
                    $doc_Name = $doc->getName();
                    $doc_Lname = $doc->getLname();
                    $docName = $doc_Name . " " . $doc_Lname;*/

                    echo "<div class=\"timeline-post\">
                    <p class=\"date\">" .date("F j", strtotime($row['ts'])). "</p>
                    <div class=\"content\">
                    <h3 class=\"doctorName\">$docName</h3>
                    <p>$note</p>
                    </div>
                    </div>";
                    //unset($doc);
                }
            
            ?>


            <div class="timeline-post">
                <p class="date">June 24</p>
                <div class="content">
                <h3 class="doctorName">Dr.Woompus</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate.</p>
                </div>
            </div>
            </div>
        </div>
        </div>
    </body>
    </html>

