<?php
require_once('DBcore.class.php');

	function getCongregationSchedule(){
		$DBcore = new DBcore();
		$congArr = array();
		$congArr = $DBcore->selectAllCongregationSchedule();
		$congStr = '';
		foreach($congArr as $row){
			$congregation_schedule_ID = $row['congregation_schedule_ID'];
			$congregation_schedule_name = $row['congregation_schedule_name'];
			$congregation_schedule_start_date = $row['congregation_schedule_start_date'];
			$congregation_schedule_end_date = $row['congregation_schedule_end_date'];
			
			$congStr .= '<p>ScheduleID: '.$congregation_schedule_ID.'</br>';
			$congStr .= 'Name: '.$congregation_schedule_name.'</br></p>';
			$congStr .= 'Start Date: '.$congregation_schedule_start_date.'</br></p>';
			$congStr .= 'End Date: '.$congregation_schedule_end_date.'</br></p>';
			
		}//end of foreach
		return $congStr;
	}
?>