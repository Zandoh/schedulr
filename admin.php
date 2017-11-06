<html>
<?php
    //begin session
    session_start(); 
    //Check if the SESSION is already set
    if (isset($_SESSION['userLogin'])) {
        // logged in
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
            <a class="nav-link" href="login_landing.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </nav>



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