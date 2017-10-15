<?php
  include 'handlers/login_handler.php';
?>

<html>

<?php
  include 'assets/includes/header.php';
  include 'assets/includes/nav.php';
?>

<body>
<div class="container login-container">
  <div class="login">
    <div class="login-title">
      <img src="assets/img/raihn-logo.png" alt="Raihn Logo">
    </div>
    <div class="form-group row">
      <div class="col-7">
        <input type="text" class="form-control" placeholder="email">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-7">
        <input type="text" class="form-control" placeholder="password">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-7">
        <button type="submit" class="submit-button">Login</button>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-7">
        <a class="forgot-password" href="#" target="_blank">Forgot your password?</a>
      </div>
    </div>
  </div>
</div>

<?php
echo "hello I am going to print the users here";
echo getUsers();
?>

<?php
  include 'assets/includes/footer.php';
?>

</body>
<script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/vendor/popper.js" type="text/javascript"></script>
<script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/fullcalendar/lib/moment.min.js" type="text/javascript"></script>
<script src="assets/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="assets/js/scripts.min.js" type="text/javascript"></script>
</html>