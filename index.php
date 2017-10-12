<?php
 include 'handlers/login_handler.php';

?>

<html>
<head>
  <title></title>
  <link rel="stylesheet" href= "assets/css/vendor/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href= "assets/fullcalendar/fullcalendar.min.css" type="text/css">
  <link rel="stylesheet" href= "assets/fullcalendar/fullcalendar.print.css" type="text/css">
  <link rel="stylesheet" href= "assets/css/styles.css" type="text/css">
</head>
<!-- <nav class="navbar navbar-inverse fixed-top bg-primary ">
    <a class="navbar-brand" href="#">RAIHN Management Tool</a>
</nav> -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="">
    <img src="assets/img/raihn-logo.png" width="30" height="30" class="d-inline-block align-top" alt="RAIHN Logo">
      RAIHN Management Tool
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home</a>
      </li>
    </ul>
    <ul class="navbar-nav pull-right">
      <li class="nav-item">
        <a class="nav-link" href="#">View</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Manage</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Logout</a>
      </li>
    </ul>
  </div>
</nav>
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
echo getUsers();
echo 'server document root '.$_SERVER["DOCUMENT_ROOT"];
?>

<footer class="container wrapper">
  <div class="row">
    <div class="center flex">
      <a class="donate" href="http://www.raihn.org/financial-support"><button>Donate</button></a>
      <a class="facebook" href="https://www.facebook.com/RochesterAreaInterfaithHospitalityNetwork" target="_blank" rel="noopener noreferrer"><i class="fa fa-facebook-square fa-3x" aria-hidden="true"></i></a>
      <a class="twitter" href="https://twitter.com/raihnshelter" target="_blank" rel="noopener noreferrer"><i class="fa fa-twitter-square fa-3x" aria-hidden="true"></i></a>
    </div>
  </div>
  <div class="row">
    <div class="center">
      <span><em>142 Webster Avenue, Rochester, NY 14609</em> &nbsp; &#124; &nbsp;</span>
      <span><em>Office: 585-506-9050</em> &nbsp; &#124; &nbsp;</span>
      <span><em><a href="mailto:director@raihn.org">director@raihn.org</a></em></span>
    </div>
  </div>
  <div class="row">
    <div class="center">
      <span><em>&copy; 2018 Rochester Area Interfaith Hospitality Network</em></span>
    </div>
  </div>
</footer>
</body>
<script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/vendor/popper.js" type="text/javascript"></script>
<script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/fullcalendar/lib/moment.min.js" type="text/javascript"></script>
<script src="assets/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="assets/js/scripts.min.js" type="text/javascript"></script>ÏÏÏÏÏÏÏÏÏÏ
</html>