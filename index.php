<?php

  require 'config/config.php';
  require 'includes/handlers/newPatient.php';

  if (isset($_SESSION['email'])) {
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
    <title>QTracker Receptionist UI</title>
<!-- These links tags add bootstrap and jQuery to the code as well as link the
style.css and script.js files-->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/receptionist.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="assets/js/receptionist.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="navBar">
      <div class="navItems">
        <h1>QTracker</h1>
        <h3>Receptionists Interface</h3>
        <?php
          $email = $_SESSION['email'];
          $recepEntries = mysqli_query($con, "SELECT * FROM receptionists WHERE email='$email'");
          if(!$recepEntries){
              echo "Error: " . mysqli_error($con);
          }
          $row = mysqli_fetch_array($recepEntries);
          $ssn = $row['ssn'];

          $recepEntries = mysqli_query($con, "SELECT * FROM employees WHERE ssn='$ssn'");
          $row = mysqli_fetch_array($recepEntries);
          echo "<h5>" . $row['name'] . " " . $row['lname'] . "</h5>";
        ?>
      </div>

      <div class="dynamicButton">
        <button type="button" id="queueBtn" class="btn" data-toggle="modal" data-target="#queueModal">
          <i class='fas fa-plus'></i> Add To Queue
        </button>
        <button type="button" id="appointBtn" class="btn" data-toggle="modal" data-target="#appointModal">
          <i class='fas fa-plus'></i> Add Appointment
        </button>
        <button type="button" id="patientBtn" class="btn" data-toggle="modal" data-target="#patientModal">
          <i class='fas fa-plus'></i> Add Patient
        </button>
      </div>
    </div>

  <!-- Modals -->
  <!-- Queue Modal-->
    <div id="queueModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>New Queue Number</h4>
          </div>
                <div class="modal-body" >
                  <form class="modalBody" action="includes/handlers/enqueue.php" method="POST">

                  <input type="text" name="enqueue_id" placeholder="ID"
                  value="<?php
                  if(isset($_SESSION['enqueue_id'])) {
                    echo $_SESSION['enqueue_id'];
                  }
                  ?>" required>
                  <br>

                  <select class="" name="selected_text">
                    <?php
                    $doctorsEntries = mysqli_query($con, "SELECT * FROM employees WHERE position=1");
                    $i = 1;
                    if(!$doctorsEntries){
                      echo "Error: " . mysqli_error($con);
                    }
                      while($row = mysqli_fetch_array($doctorsEntries)){
                          echo "<option value=\"" . $row['lname'] . "\">Dr " . $row['lname'] . "</option>";
                          $i = $i + 1;
                      }
                    ?>
                  </select>

                  <input type="submit" name="enqueue_patient" value="Enqueue">

                  <br>
                </form>
                </div>
              </div>
            </div>
          </div>


        <!--Commented this out modal footer out because it was causing the problem in the display.
            if you need it, add it into the modal div not outside -->


        <!--  <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Add</button>
          </div> -->
        </div>
      </div>
    </div>

  <!-- Appointment Modal-->

    <div id="appointModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>New Appointment</h4>
          </div>
          <div class="modal-body">
            <div class="modalBody">
              <label for="patientSearch">Patient ID*</label>
              <label for="doctorSearch">Doctor*</label>
              <input id="patientSearch" type="text" placeholder="search">
              <select class="" name="">
                <?php
                  $doctorsEntries = mysqli_query($con, "SELECT * FROM employees WHERE position=1");
                  $i = 1;
                  if(!$doctorsEntries){
                    echo "Error: " . mysqli_error($con);
                  }
                    while($row = mysqli_fetch_array($doctorsEntries)){
                         echo "<option value=\"" . $i . "\">Dr " . $row['name'] . " " . $row['lname'] . "</option>";
                         $i = $i + 1;
                    }
                ?>
              </select>
              <label for="appointDate"></label>
              <label for=""></label>
              <input id="appointDate" type="date" name="" value="2019-12-21">
              <input id="appointTime" type="time" name="" >
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Add</button>
          </div>
        </div>
      </div>
    </div>

<!-- patient Modal -->
    <div id="patientModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>New Patient</h4>
          </div>
          <div class="modal-body" >
            <form class="modalBody" action="includes/handlers/enqueue.php" method="POST">

            <input type="text" name="reg_id" placeholder="ID"
            value="<?php
            if(isset($_SESSION['reg_id'])) {
              echo $_SESSION['reg_id'];
            }
            ?>" required>
            <br>

            <input type="text" name="reg_fname" placeholder="Name"
            value="<?php
            if(isset($_SESSION['reg_fname'])) {
              echo $_SESSION['reg_fname'];
            }
            ?>" required>
            <br>
            <input type="text" name="reg_lname" placeholder="Surname"
            value="<?php
            if(isset($_SESSION['reg_lname'])) {
              echo $_SESSION['reg_lname'];
            }
            ?>" required>
            <br>

            <input type="text" name="reg_address" placeholder="address"
            value="<?php
            if(isset($_SESSION['reg_address'])) {
              echo $_SESSION['reg_address'];
            }
            ?>" required>
            <br>

            <input type="text" name="reg_phone" placeholder="phone"
            value="<?php
            if(isset($_SESSION['reg_phone'])) {
              echo $_SESSION['reg_phone'];
            }
            ?>" required>
            <br>

            <input type="submit" name="register_patient" value="Register">
            <br>
				  </form>

          </div>
        </div>
      </div>
    </div>
<!--End of Modals-->

    <div class="wrapper">
      <div class="sideBar">
        <div class="section1">
          <a href="#" id="queuetab">Queue</a>
          <a href="#" id="appointtab">Appointments</a>
          <a href="#" id="patienttab">Patient Folders</a>
        </div>
        <div class="section2">
          <a href="#">Settings</a>
          <a href="#">Help</a>
        </div>
      </div>
      <div class="queueblock">
        <div class="column">
          ID
        </div>
        <div class="column">
          Name
        </div>
        <div class="column">
          Arrival Time
        </div>
      </div>

      <div class="appointmentblock">
        <div class="column">
          ID
        </div>
        <div class="column">
          Patient Name
        </div>
        <div class="column">
          Date
        </div>
        <div class="column">
          Time
        </div>
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
