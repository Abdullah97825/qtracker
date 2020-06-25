<?php

  require '../config/config.php';

  if (isset($_SESSION['emailDoc'])) {
    /*
	  $userLoggedIn = $_SESSION['username'];
	  $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	  $user = mysqli_fetch_array($user_details_query);*/
  }
  else {
	  header("Location: login.php");
  }


?>


<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width = device-width, intial-scale=1">
    <title>QTracker Doctor UI</title>
<!-- These links tags add bootstrap and jQuery to the code as well as link the
style.css and script.js files-->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/doctor.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="assets/js/doctor.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="navBar">
      <div class="navItems">
        <h1>QTracker</h1>
        <h3>Doctors Interface</h3>

      </div>
	<div class="dynamicButton ">
        <button type="button" id="queueBtn" class="btn">
          <i class='fas fa-plus'></i>
          <form action="includes/handlers/removeFromQueue.php" method="POST">
            <input type="submit" name="remove_Patient" value="Next Patient" class="pButton">
          </form>
        </button>
      </div>
    </div>


    <div class="wrapper">
      <div class="sideBar">
        <div class="section1">
          <a href="#" id="queuetab">Queue</a>
          <a href="#" id="patienttab">Patient Folders</a>
        </div>
        <div class="section2">
          <a href="#">Help</a>
        </div>
      </div>
      <div class="queueblock">
        <div class="column">
          Queue A
        </div>
        <div class="column">
          Queue B
        </div>
        <div class="column">
          Queue C
        </div>
        <div class="column">
          Queue D
        </div>
        <?php
        $queueEntries = mysqli_query($con, "SELECT * FROM er_a");
        if(!$queueEntries){
                echo "Error: (queue a) " . mysqli_error($con);
        }
        echo "<div>";
        while($row = mysqli_fetch_array($queueEntries)){
            $patientID = $row['patientID'];
            $patientEntries = mysqli_query($con, "SELECT * FROM patients WHERE id='$patientID'");
            if(!$patientEntries){
              echo "Error: (patientEntries)" . mysqli_error($con);
            }
            $patientRow = mysqli_fetch_array($patientEntries);
            $patientName = $patientRow['name'];
            echo $patientName . "<br>";
        }
        echo "</div>";


        $queueEntries = mysqli_query($con, "SELECT * FROM er_b");
        if(!$queueEntries){
                echo "Error: (queue b) " . mysqli_error($con);
        }
        echo "<div>";
        while($row = mysqli_fetch_array($queueEntries)){
            $patientID = $row['patientID'];
            $patientEntries = mysqli_query($con, "SELECT * FROM patients WHERE id='$patientID'");
            if(!$patientEntries){
              echo "Error: (patientEntries)" . mysqli_error($con);
            }
            $patientRow = mysqli_fetch_array($patientEntries);
            $patientName = $patientRow['name'];
            echo $patientName . "<br>";
        }
        echo "</div>";



        $queueEntries = mysqli_query($con, "SELECT * FROM er_c");
        if(!$queueEntries){
                echo "Error: (queue c) " . mysqli_error($con);
        }
        echo "<div>";
        while($row = mysqli_fetch_array($queueEntries)){
            $patientID = $row['patientID'];
            $patientEntries = mysqli_query($con, "SELECT * FROM patients WHERE id='$patientID'");
            if(!$patientEntries){
              echo "Error: (patientEntries)" . mysqli_error($con);
            }
            $patientRow = mysqli_fetch_array($patientEntries);
            $patientName = $patientRow['name'];
            echo $patientName . "<br>";
        }
        echo "</div>";



        $queueEntries = mysqli_query($con, "SELECT * FROM er_d");
        if(!$queueEntries){
                echo "Error: (queue d) " . mysqli_error($con);
        }
        echo "<div>";
        while($row = mysqli_fetch_array($queueEntries)){
            $patientID = $row['patientID'];
            $patientEntries = mysqli_query($con, "SELECT * FROM patients WHERE id='$patientID'");
            if(!$patientEntries){
              echo "Error: (patientEntries)" . mysqli_error($con);
            }
            $patientRow = mysqli_fetch_array($patientEntries);
            $patientName = $patientRow['name'];
            echo $patientName . "<br>";
        }
        echo "</div>";

        ?>

      </div>

      <div class="patientblock">
        <div class="column">
          ID
        </div>
        <div class="column">
          Patient Name
        </div>
        <div class="column">
          History
        </div>
      </div>
    </div>
  </body>
</html>
