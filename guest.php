<!DOCTYPE html>

	<head>
		<title>RAIHN Guest</title>
	</head>

    <?php
    include 'assets/includes/header.php';
    include 'assets/includes/nav.php';
    include 'handlers/guest_handler.php';
    ?>


	<body>
	<?php

		echo getCongregationSchedules();


		print_r(createSchedule(1));


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