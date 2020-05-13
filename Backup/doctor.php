<?php 

  require 'config/config.php';

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
        <img src="profilepic.jpg" alt="">
        <h5>UserName</h5>
      </div>
      <div>
        <button type="button" id="serveBtn" class="btn" data-toggle="modal" data-target="#queueModal">
          <i class='fas fa-plus'></i> Adjust Service Time
        </button>
      </div>
    </div>


  <!-- Service Time Modal-->
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
