<?php
  include 'handlers/login_handler.php';
?>
<html>
<head>
<?php
  include 'assets/includes/header.php';
  include 'assets/includes/nav.php';
  //include 'handlers/congregation_handler.php';
  include 'handlers/schedule_handler.php';
?>
<body>







<?php  

echo createBusScheduling();
//echo generateCongregationSchedule();
  ?>









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