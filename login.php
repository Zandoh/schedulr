<html>

<?php

    include 'assets/includes/header.php';
    include 'assets/includes/common.php';
    require_once('handlers/DBcore.class.php');

    // begin session
    session_start();
    session_name("LoginSession"); 
    // Check if the form has been submitted and the SESSION is already set

    if (isset($_SESSION['userLogin'])) {
        // logged in, check which page to redirect to
        if(strcasecmp($_SESSION['userType'],"b") == 0){
          header("Location: bus-avail.php");
        }
        // user is a congregation lead
        elseif(strcasecmp($_SESSION['userType'],"c") == 0){
          header("Location: blackouts.php");
        }
        else{
          // user is a raihn employee
          header("Location:login_landing.php");
        }
    }
    else{
        // if the login button was pressed
        if(isset($_POST['LoginSubmit'])){
            $email = sanitize($_POST['account']);
            $_SESSION['user_email'] = $email;
            $pass = sanitize($_POST['secure']);
            $DBcore = new DBcore();
            $userArr = array();
            $userResult = $DBcore->login($email,$pass);

			      // Call database function to pull the user type
			      // Set session user role
			
            if($userResult){
              // successful login
              $userType = $DBcore->selectUserType($email);
              $userID =  $DBcore->selectUserID($email);
              $_SESSION['userID'] = $userID;
              $_SESSION['userLogin'] = $email;
              $_SESSION['userType'] = $userType;
              $_SESSION['loginStatus'] = "Pass"; 
              // user is a bus driver
              if(strcasecmp($userType,"b") == 0){
                // redirect the busdriver to put in availability
                header("Location: bus-avail.php");
              }
              // user is a congregation lead
              elseif(strcasecmp($userType,"c") == 0){
                // redirect the congregation lead to put in blackout dates
                header("Location: blackouts.php");

              }
              else{
                // user is a raihn employee
      				  header("Location:login_landing.php");
              }
            }else{
              // not a successful login
              $_SESSION['loginStatus'] = "Fail";
            }            
        }
    }

?>

  <!-- nav not included; don't need nav links on the homepage -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/index.php">
      <img src="assets/img/raihn-logo.png" width="187" height="60" class="d-inline-block" alt="RAIHN Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

  <!-- login container for RAIHN admin -->

  <body class="init_login">
    <div class="container login-container">
      <div class="login">
        <form method="POST" onsubmit="return validateLogin();" name="loginForm" action="login.php">
          <div class="login-title">
            <img src="assets/img/raihn-logo.png" alt="Raihn Logo">
          </div>
          <div class="form-group row">
            <div class="col-7">
              <input type="text" name="account" class="form-control" placeholder="Email">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-7">
              <input type="password" name="secure" class="form-control" placeholder="Password">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-7">
              <button type="submit" name="LoginSubmit" class="submit-button" value="Login">Login</button>
              <?php 
                // if the submitted form failed, display error message
                if(isset($_SESSION['loginStatus'])) {
                  if($_SESSION['loginStatus'] == "Fail") {
                    echo "<label class='error' style='margin-top: .5rem;'>Invalid Email and/or Password.</label>";
                    unset($_SESSION['loginStatus']);
                  }
                }
              ?>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-7">
              <a class="forgot-password" href="forgot-password.php">Forgot your password?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php 
        include 'assets/includes/footer.php';
        ?>
  </body>
  <script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery.validate.min.js"></script>
  <script src="assets/js/vendor/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery-ui.multidatespicker.js" text="text/javascript"></script>
  <script src="assets/js/vendor/popper.js" type="text/javascript"></script>
  <script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/js/scripts.min.js" type="text/javascript"></script>
</html>