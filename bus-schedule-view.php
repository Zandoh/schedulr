<html>

<?php
    // begin session
    session_start(); 
    // Check if the SESSION is already set
    if (!isset($_SESSION['userLogin'])) {
        // if the user is not logged in, redirect them to the login page
        header("Location:login.php");
    }
    // user is a congregation lead
    elseif(strcasecmp($_SESSION['userType'],"c") == 0){
      header("Location: blackouts.php");
    }
    include 'handlers/login_handler.php';
    include 'assets/includes/header.php';
    ?>

  <body class="bus-view">
    <?php include 'assets/includes/nav.php'; ?>
    <?php include 'handlers/schedule_handler.php'; ?>
    <div class="container-fluid bus-view-container">
      <div class="row justify-content-md-center">
        <!-- bus schedule view will go here -->
        <div class="col-md-8">
        <?php
          echo createBusScheduling();
        ?>
        </div>
      </div>
    </div>

    <?php 
        include 'assets/includes/footer.php';
    ?>
  </body>
  <script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery-ui.multidatespicker.js" text="text/javascript"></script>
  <script src="assets/js/vendor/popper.js" type="text/javascript"></script>
  <script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jspdf.min.js" type="text/javascript"></script>
  <script src="assets/js/scripts.min.js" type="text/javascript"></script>

</html>