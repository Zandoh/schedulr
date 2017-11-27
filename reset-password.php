<?php
    include 'assets/includes/header.php';
    include 'assets/includes/nav.php';
    include 'handlers/guest_handler.php';

    require_once('handlers/DBcore.class.php');
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    // if there's no key parameter, kick the user back to the login
    if(!isset($_GET['key'])) {
      header("Location: login.php");
    }

    if(isset($_POST['NewPassword'])) {
        if (isset($_GET['key'])) {
          $key = $_GET['key'];
          
          $email = $_SESSION['email'];
          $password = $_POST['password'];
          $DBcore = new DBcore();
          $newPasswordResult = $DBcore->updatePassword($email, $password, $key);

          //if returns true, show that the password was updated
          if($newPasswordResult) {
            $_SESSION['newPasswordResult'] = "Updated";
          } else {
            $_SESSION['newPasswordResult'] = "Failed";
          }
      } else {
        $_SESSION['newPasswordResult'] = "Failed";
      }
    }

?>

<body class="forgot-password init_login">
  <div class="container forgot-password-container">
    <div class="forgot-password-form">
      <form method="POST" onsubmit="return validatePassword();" name="newFormPassword" action="">
        <div class="login-title">
          <img src="assets/img/raihn-logo.png" alt="Raihn Logo">
        </div>
        <h2 class="text-center">Reset Password</h2>
        <p></p>
        <div class="form-group row">
          <div class="col-7">
            <input type="password" name="password" class="form-control" placeholder="Password" id="newPassword"
            <?php
              // if the password was put in, disable the form fields
              if(isset($_SESSION['newPasswordResult'])) {
                if ($_SESSION['newPasswordResult'] == "Updated") {
                  echo " disabled";
                }
              }
            ?>
            >
          </div>
        </div>
        <div class="form-group row">
          <div class="col-7">
            <input type="password" name="confirm" class="form-control" placeholder="Confirm Password"
            <?php
              // if the password was put in, disable the form fields
              if(isset($_SESSION['newPasswordResult'])) {
                if ($_SESSION['newPasswordResult'] == "Updated") {
                  echo " disabled";
                }
              }
            ?>
            >
          </div>
        </div>
        <div class="form-group row">
          <div class="col-7">
            <button type="submit" name="NewPassword" class="submit-button" value="NewPassword"
            <?php 
              // if the password was put in, disable the button
              if(isset($_SESSION['newPasswordResult'])) {
                if ($_SESSION['newPasswordResult'] == "Updated") {
                  echo " disabled";
                }
              }
            ?>
            >Reset Password</button>
            <?php 
              //TODO: If form fails to submit, tell them. Else say success!
              if(isset($_SESSION['newPasswordResult'])) {
                if($_SESSION['newPasswordResult'] == "Failed") {
                  echo "<label class='error' style='margin-top: .5rem;'>There was an error. Your new password may be the same as your old one. Please contact RAIHN.</label>";
                  unset($_SESSION['newPasswordResult']);
                } else if ($_SESSION['newPasswordResult'] == "Updated") {
                  echo "<div class='alert alert-success' role='alert'>
                          Your password has been updated! Click <a href='login.php'>here</a> to login.
                        </div>";
                  unset($_SESSION['newPasswordResult']);
                }
              }
              ?>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
    <script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="assets/js/vendor/jquery.validate.min.js"></script>
    <script src="assets/js/vendor/additional-methods.min.js"></script>
    <script src="assets/js/vendor/popper.js" type="text/javascript"></script>
    <script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/fullcalendar/lib/moment.min.js" type="text/javascript"></script>
    <script src="assets/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="assets/js/scripts.min.js" type="text/javascript"></script>
</html>