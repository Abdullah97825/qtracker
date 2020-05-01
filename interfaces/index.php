<?php 

  require '../config/config.php';

  if (isset($_SESSION['username'])) {
    /*
	  $userLoggedIn = $_SESSION['username'];
	  $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	  $user = mysqli_fetch_array($user_details_query);*/
  }
  else {
	  header("Location: ../login.php");
  }

?> 

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width = device-width, intial-scale=1">
    <title>QTracker</title>
<!-- These links tags add bootstrap and jQuery to the code as well as link the
style.css and script.js files-->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="script.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="navBar">
      <div class="navItems">
        <h1>QTracker</h1>
        <img src="profilepic.jpg" alt="">
        <h5>UserName</h5>
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
          <div class="modal-body">
            <div class="modalBody">
              <label for="patientSearch">Patient ID*</label>
              <label for="doctorSearch">Doctor*</label>
              <input id="patientSearch" type="text" placeholder="search">
              <select class="selectList" name="">
                <option value="1">Dr Enver Ever</option>
                <option value="2">Dr Owilla</option>
                <option value="3">Dr Wumpus</option>
                <option value="4">Dr Mohammed Sayed</option>
              </select>
              <div id="radioOptions">
                <label for="radioOptions">Visit Type*</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                  <label class="form-check-label" for="exampleRadios1">
                    Normal Visit
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                  <label class="form-check-label" for="exampleRadios2">
                    Appointment
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Add</button>
          </div>
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
                <option value="1">Dr Enver Ever</option>
                <option value="2">Dr Owilla</option>
                <option value="3">Dr Wumpus</option>
                <option value="4">Dr Mohammed Sayed</option>
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
          <div class="modal-body">
            <div class="modalBody">
              <label for="patientFName">First Name*</label>
              <input id="patientFName"type="text" name="" value="">
              <label for="patientLName">Last Name*</label>
              <input id="patientLName"type="text" name="" value="">
              <label for="patientAge">Age*</label>
              <input id="patientAge"type="text" name="" value="">
              <label for="patientNID">National ID*</label>
              <input id="patientNID"type="text" name="" value="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Add</button>
          </div>
        </div>
      </div>
    </div>

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
        <div class="column">
          Exp Service Time
        </div>
        <div class="column">
          Doc.Name
        </div>
        <div class="column">
          Q Number
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
        <div class="column">
         Name
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
