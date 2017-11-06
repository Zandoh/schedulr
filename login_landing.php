<html>

<?php
    //begin session
    session_start(); 
    //Check if the SESSION is already set
    if (isset($_SESSION['userLogin'])) {
        // logged in
      //user is a bus driver
      if($_SESSION['userType'] == "B"){
        //redirect the busdriver to put in availability
        header("Location: bus-avail.php");
      }
      //user is a congregation lead
      elseif($_SESSION['userType'] == "C"){
        //redirect the congregation lead to put in blackout dates
        header("Location: cong-avail.php");

      }
      //else user is an admin and can stay on this page
    }
    else{
        //not logged in
        header("Location:login.php");
    }

    include 'assets/includes/header.php';
    ?>

  <body>
    <!-- navigation for logged in user -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="/schedulr">
        <img src="assets/img/raihn-logo.png" width="187" height="60" class="d-inline-block" alt="RAIHN Logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/login.php">Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- need to check if admin, show admin panel, else just show bus + cong -->
    <div class="container-fluid landing-container">
      <div class="row justify-content-md-center">
        <div class="col-md-3 text-center landing-boxes">
          <h2>Edit Users</h2>
          <a href="admin.php">
            <span></span>
          </a>
        </div>
        <div class="col-md-3 text-center landing-boxes">
          <h2>Bus Drivers</h2>
          <a href="bus-drivers.php">
            <span></span>
          </a>
        </div>
        <div class="col-md-3 text-center landing-boxes">
          <h2>Congregations</h2>
          <a href="congregations.php">
            <span></span>
          </a>
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
  <script src="assets/js/scripts.min.js" type="text/javascript"></script>

</html>