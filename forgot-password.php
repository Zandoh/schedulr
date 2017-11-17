<?php
    include 'assets/includes/header.php';
    include 'assets/includes/nav.php';
    include 'handlers/guest_handler.php';

    require_once('handlers/DBcore.class.php');
    require_once('assets/php/EmailUser.class.php');
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    //TODO: Check if the form was submitted and if the session is already set

    if(isset($_POST['PasswordResetSubmit'])) {
      $email = $_POST['account'];
      $DBcore = new DBcore();
      $userResult = $DBcore->emailExists($email);

      //if returns true, send user an email
      if($userResult) {
        $EmailUser = new EmailUser();
        $emailResult = $EmailUser->emailUser($email);

        if($emailResult) {
          $_SESSION['emailResult'] = "Sent";
        } else {
          $_SESSION['emailResult'] = "Fail";
        }

      } else {
        $_SESSION['emailSent'] = "Fail";
      }
    }
?>

<body class="forgot-password init_login">
  <div class="container forgot-password-container">
    <div class="forgot-password-form">
      <form method="POST" onsubmit="return validateEmail();" name="passwordReset" action="forgot-password.php">
        <div class="login-title">
          <img src="assets/img/raihn-logo.png" alt="Raihn Logo">
        </div>
        <h2 class="text-center">Forgot your password?</h2>
        <p></p>
        <div class="form-group row">
          <div class="col-7">
            <input type="text" name="account" class="form-control" placeholder="Email">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-7">
            <button type="submit" name="PasswordResetSubmit" class="submit-button" value="PasswordReset">Send Recovery Email</button>
            <?php 
                // if the submitted form failed, display error message
                if(isset($_SESSION['emailSent'])) {
                  if($_SESSION['emailSent'] == "Fail") {
                    echo "<label class='error' style='margin-top: .5rem;'>Sorry, we don't have an account with that email.</label>";
                    unset($_SESSION['emailSent']);
                  }
                }

                // if the email sent fails, let the user know
                if(isset($_SESSION['emailResult'])) {
                  if($_SESSION['emailResult'] == "Fail") {
                    echo "<label class='error' style='margin-top: .5rem;'>Sorry, the email failed to send. Please contact RAIHN for help.</label>";
                    unset($_SESSION['emailResult']);
                  } else if ($_SESSION['emailResult'] == "Sent") {
                    echo "<div class='alert alert-success' role='alert'>
                            We've just sent you an email. Click the link in it to reset your password.
                          </div>";
                    unset($_SESSION['emailResult']);
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