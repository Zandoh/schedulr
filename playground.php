<?php
  include 'handlers/login_handler.php';
?>
<html>
<head>
<?php
  include 'assets/includes/header.php';
  include 'assets/includes/nav.php';
?>
<body>
<div class="container-fluid">
  <div class="row justify-content-md-center">
    <div class="col-md-8">
      <p>Date: <input type="text" id="datepicker"></p>
    </div>
  </div>
</div>

<?php 
  include 'assets/includes/footer.php';
?>
</body>
<script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="assets/js/vendor/popper.js" type="text/javascript"></script>
<script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/scripts.min.js" type="text/javascript"></script>
</html>