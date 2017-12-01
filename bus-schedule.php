<html>

<?php
    // begin session
    session_start(); 
    // Check if the SESSION is already set
   if (!isset($_SESSION['userLogin'])) {
        // if the user is not logged in, redirect them to the login page
        header("Location:login.php");
    }
    // logged in, check which page to redirect to
    elseif(strcasecmp($_SESSION['userType'],"b") == 0){
      header("Location: bus-avail.php");
    }
    // user is a congregation lead
    elseif(strcasecmp($_SESSION['userType'],"c") == 0){
      header("Location: blackouts.php");
    }
    include 'handlers/login_handler.php';
    include 'assets/includes/header.php';
    include 'handlers/busDriver_handler.php';
    ?>

    <!-- container used for scheduling bus drivers -->
    <body class="bus-schedule">
      <?php include 'assets/includes/nav.php'; ?>
      <div class="container-fluid bus-schedule-container">
        <div class="row justify-content-md-center">
          <div class="col-md-5">
            <h1>Bus Scheduling</h1>
            <div id="bus-schedule"></div>
            <input id="alt-Input" type="hidden" value="test">
          </div>
          <div class="col-md-5">
            <h1>Day: <span id="schedule-header-date"></span></h1>
            <div id="availErrorContainer">
            </div>
            <table class="table table-hover table-bordered" id="schedule-list">
              <thead>
                <tr>
                  <th>Driver Name</th>
                  <th>Time</th>
                  <th>Role</th>
                </tr>
              </thead>
              <tbody> 
              </tbody>
            </table>
            <button type="submit" class="submit" id="busScheduleSubmit">Submit</button>
          </div>
        </div>
      </div>

    <?php include 'assets/includes/footer.php'; ?>
  </body>
  <script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery-ui.multidatespicker.js" text="text/javascript"></script>
  <script src="assets/js/vendor/popper.js" type="text/javascript"></script>
  <script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
  <script srx="assets/js/vendor/jspdf.min.js" type="text/javascript"></script>
  <script src="assets/js/scripts.min.js" type="text/javascript"></script>

</html>