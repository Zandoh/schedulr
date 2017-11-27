<html>

<?php
    //begin session
    session_start(); 
    //Check if the SESSION is already set
    if (!isset($_SESSION['userLogin'])) {
        //if the user is not logged in, redirect them to the login page
        header("Location:login.php");
    }
    // logged in, check which page to redirect to
    elseif(strcasecmp($_SESSION['userType'],"b") == 0){
      header("Location: bus-avail.php");
    }
    //user is a congregation lead
    elseif(strcasecmp($_SESSION['userType'],"c") == 0){
      header("Location: blackouts.php");
    }

    include 'assets/includes/header.php';
    ?>

  <body>
    <!-- navigation for logged in user -->
    <?php
      include 'assets/includes/nav.php';
    ?>

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
      </div>
      <div class="row justify-content-md-center">
        <div class="col-md-3 text-center landing-boxes">
          <h2>Congregations</h2>
          <a href="congregations.php">
            <span></span>
          </a>
        </div>
        <div class="col-md-3 text-center landing-boxes">
          <h2>Manage Congregations</h2>
          <a href="manage-congregation.php">
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