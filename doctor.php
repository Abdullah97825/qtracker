<?php

  require 'config/config.php';

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
        <label class="switch">
          <input type="checkbox">
          <span class="slider round"></span>
        </label>
        <?php
          $email = $_SESSION['emailDoc'];
          $doctorsEntries = mysqli_query($con, "SELECT * FROM doctors WHERE email='$email'");
          if(!$doctorsEntries){
              echo "Error: " . mysqli_error($con);
          }
          $row = mysqli_fetch_array($doctorsEntries);
          $ssn = $row['ssn'];

          $doctorsEntries = mysqli_query($con, "SELECT * FROM employees WHERE ssn='$ssn'");
          $row = mysqli_fetch_array($doctorsEntries);
          echo "<h5>" . $row['name'] . " " . $row['lname'] . "</h5>";
        ?>
      </div>

      <div>
        <button type="button" id="serveBtn" class="btn" data-toggle="modal" data-target="#serviceModal">
          <i class='fas fa-plus'></i> Adjust Service Time
        </button>
      </div>
    </div>


    </div>

    

<!--
    <div id="queueModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Service Time</h4>
          </div>
          <div class="modal-body">
            <div class="modalBody">
              <label for="newTime">New Time*</label>
              <input type="number" name="" value="00" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Add</button>
          </div>
        </div>
      </div>
    </div>-->


    <div id="serviceModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Service Time</h4>
          </div>
          <div class="modal-body">
            <form class="modalBody" action="includes/handlers/adjustServiceTime.php" method="post" id="patientForm">
              <label for="patientNote">Add Service Time</label>
              <!--<textarea name="name" rows="8" cols="80" form="patientForm">...</textarea>-->
              <input type="text" name="amount" placeholder="Enter amount (minutes)" value="<?php 
                  if(isset($_SESSION['amount'])) {
                    echo $_SESSION['amount'];
                  } 
                  ?>">
              <input  type="submit" name="adjust_service" value="Next Patient" class="btn btn-default">
              <?php
                    $email = $_SESSION['emailDoc'];
                    $doctorsEntries = mysqli_query($con, "SELECT * FROM doctors WHERE email='$email'");
                    if(!$doctorsEntries){
                      echo "Error: (doctorEntries) " . mysqli_error($con);
                    }

                    $row = mysqli_fetch_array($doctorsEntries);
                    $queueName = 'q' . $row['ssn'];

                    $_SESSION['docQueue'] = $queueName;
                    $_SESSION['docPostID'] = $row['ssn'];

                    $queueEntries = mysqli_query($con, "SELECT * FROM $queueName ORDER By ts ASC");
                    if(!$queueEntries){
                            echo "Error: (queueEntries) " . mysqli_error($con);
                    }

                    $row = mysqli_fetch_array($queueEntries);
                    $patientID = $row['patientID'];
                    $_SESSION['id'] = $patientID;
                ?>

            </form>
          </div>
        </div>
      </div>
    </div>


    <div class="wrapper">
      <div class="sideBar">
        <div class="section1">
          <a href="#" id="queuetab">Queue</a>
          <a href="#" id="patienttab">Patient Folders</a>
          <input  type="button" name="remove_Patient" value="Next Patient" class="nextPatientBtn" data-toggle="modal" data-target="#nextPatientModal">
        </div>
        <div class="section2">
          <a href="#">Help</a>
        </div>
      </div>
      <div class="queueblock">
        <div class="column">
          ID
        </div>
        <div class="column">
          Patient Name
        </div>
        <div class="column">
          Arrival Time
        </div>
        <?php
        $email = $_SESSION['emailDoc'];
        $doctorsEntries = mysqli_query($con, "SELECT * FROM doctors WHERE email='$email'");
              if(!$doctorsEntries){
                echo "Error: (doctorEntries) " . mysqli_error($con);
              }

        $row = mysqli_fetch_array($doctorsEntries);
        $queueName = 'q' . $row['ssn'];

        $queueEntries = mysqli_query($con, "SELECT * FROM $queueName ORDER By ts ASC");
        if(!$queueEntries){
                echo "Error: (queueEntries) " . mysqli_error($con);
        }

        while($row = mysqli_fetch_array($queueEntries)){
            $patientID = $row['patientID'];
            $patientEntries = mysqli_query($con, "SELECT * FROM patients WHERE id='$patientID'");
            if(!$patientEntries){
              echo "Error: (patientEntries)" . mysqli_error($con);
            }
            $patientRow = mysqli_fetch_array($patientEntries);
            $patientName = $patientRow['name'];
            echo "<div><a href=\"patientProfile.php?id=" . $patientID . "\">". $patientID . "</a></div>" . "<div>". $patientName . "</div>" . "<div>". $row['ts'] . "</div>" ;
        }
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

    <!-- Next Patient Modal -->
    <div id="nextPatientModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Patient Notes</h4>
          </div>
          <div class="modal-body">
            <form class="modalBody" action="includes/handlers/removeFromQueue.php" method="post" id="patientForm">
              <label for="patientNote">Doctors Remarks*</label>
              <!--<textarea name="name" rows="8" cols="80" form="patientForm">...</textarea>-->
              <input type="text" name="note" placeholder="Write a note here" value="<?php 
                  if(isset($_SESSION['note'])) {
                    echo $_SESSION['note'];
                  } 
                  ?>">
              <input  type="submit" name="remove_Patient" value="Next Patient" class="btn btn-default">
              <?php
                    $email = $_SESSION['emailDoc'];
                    $doctorsEntries = mysqli_query($con, "SELECT * FROM doctors WHERE email='$email'");
                    if(!$doctorsEntries){
                      echo "Error: (doctorEntries) " . mysqli_error($con);
                    }

                    $row = mysqli_fetch_array($doctorsEntries);
                    $queueName = 'q' . $row['ssn'];

                    $_SESSION['docQueue'] = $queueName;
                    $_SESSION['docPostID'] = $row['ssn'];

                    $queueEntries = mysqli_query($con, "SELECT * FROM $queueName ORDER By ts ASC");
                    if(!$queueEntries){
                            echo "Error: (queueEntries) " . mysqli_error($con);
                    }

                    $row = mysqli_fetch_array($queueEntries);
                    $patientID = $row['patientID'];
                    $_SESSION['id'] = $patientID;


                    echo "<input type=\"hidden\" name=\"remove_id\" id=\"selected_text\" value=\"" . $patientID . "/>";
                    echo "<input type=\"hidden\" name=\"doc_queue\" id=\"selected_text\" value=\"" . $queueName . "/>";
                ?>

            </form>
          </div>
        </div>
      </div>
    </div>




  </body>
</html>
