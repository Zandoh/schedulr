<?php

require_once('DBcore.class.php');

	
	function getCongregationSchedules(){
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



	//used to get all sundays of a specified date range
	function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber)
	{
	    $startDate = strtotime($startDate);
	    $endDate = strtotime($endDate);

	    $dateArr = array();

	    do
	    {
	        if(date("w", $startDate) != $weekdayNumber)
	        {
	            $startDate += (24 * 3600); // add 1 day
	        }
	    } while(date("w", $startDate) != $weekdayNumber);


	    while($startDate <= $endDate)
	    {
	        $dateArr[] = date('Y-m-d', $startDate);
	        $startDate += (7 * 24 * 3600); // add 7 days
	    }

	    return($dateArr);
	}
?>
