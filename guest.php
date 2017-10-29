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


		$sundayArr = getDateForSpecificDayBetweenDates('2017-01-01', '2017-12-31', 0);

		$tableScheduleStr = '<table>
							  <tr>
							    <th>Start of Week</th>
							    <th>Scheduled Congregation</th>
							  </tr>';
		foreach($sundayArr as $sunday){
			$tableScheduleStr .= '<tr>
								    <td>'.$sunday.'</td>
								    <td>A congregation</td>
								  </tr>';

		}
		$tableScheduleStr .= '</table>';
		echo $tableScheduleStr;


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