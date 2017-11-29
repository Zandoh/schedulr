<?php
require_once('DBcore.class.php');

	function getAvailableDrivers($date){
		$DBcore = new DBcore();
		$driverArr = array();
		$driverArr = $DBcore->selectAllAvailableBusDriversOnDate($date);
		print_r($driverArr);

	}

?>