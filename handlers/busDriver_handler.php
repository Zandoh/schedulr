<?php
require_once('DBcore.class.php');

	function returnAvailabilityOnDay($date) {
    $DBcore = new DBcore();
    $driverArr = array();
    $driverArr = $DBcore->selectAllAvailableBusDriversOnDate($date);
    $json = array();

    foreach($driverArr as $row) {
        $user = array(
					'userID' => $row['user_ID'],
					'firstName' => $row['first_name'],
					'lastName' => $row['last_name'],
					'time' => $row['availability_time_of_day']	
        );
        array_push($json, $user);
    }

    $jsonstring = json_encode($json);

    return $jsonstring;
	}
?>