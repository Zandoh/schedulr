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

/*
* Select previous congregation rotation order
*/
function getPreviousRotation(){
		$DBcore = new DBcore();
		$congArr = array();
        $congStr = '';
		$congArr = $DBcore->selectCongregationRotation();
		foreach($congArr as $row){
			$congregation_name = $row['congregation_name'];
			
			$congStr .= '<p>Congname: '.$congregation_name.'</br>';
			
		}//end of foreach
		return $congStr;
	}

/*
* Select previous congregation rotation ID
*/
function getPreviousRotationNumber(){
		$DBcore = new DBcore();
		$congArr = array();
        $congStr = '';
		$congArr = $DBcore->selectPreviousRotationID();
		foreach($congArr as $row){
			$congregation_schedule_ID = $row['MAX(csa.congregation_schedule_ID)'];
			
			$congStr .= '<p>ID_Number: '.$congregation_schedule_ID.'</br>';
			
		}//end of foreach
		return $congStr;
	}



?>