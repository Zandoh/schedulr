<?php

require_once('DBcore.class.php');

	
	function getCongregationSchedules(){
		$DBcore = new DBcore();
		$congArr = array();
		$congArr = $DBcore->selectAllCongregationSchedule();
		$congStr = '<form action="guest.php" id="congregationform" method="post">
						<select name="congregationScheduleList" form="congregationScheduleForm">';
		foreach($congArr as $row){
			$congregation_schedule_ID = $row['congregation_schedule_ID'];
			$congregation_schedule_name = $row['congregation_schedule_name'];
			$congregation_schedule_start_date = $row['congregation_schedule_start_date'];
			$congregation_schedule_end_date = $row['congregation_schedule_end_date'];
			
			$congStr .= '<option value='.$congregation_schedule_ID.'>'.$congregation_schedule_name.'</option>';


		}//end of foreach
			$congStr .= '</select>
						  <input type="submit" name="submit">
						</form>';
		return $congStr;
	}


	function createSchedule($scheduleID){
		$DBcore = new DBcore();
		$eventArr = array();
		$eventArr = $DBcore->selectAllCongregationScheduleEvents($scheduleID);
		//$sundayArr = getDateForSpecificDayBetweenDates('2017-01-01', '2017-12-31', 0);

		$tableScheduleStr = '<table>
							  <tr>
							    <th>Start of Week</th>
							    <th>End of Week</th>
							    <th>Scheduled Congregation</th>
							  </tr>';
		foreach($eventArr as $row){
			$tableScheduleStr .= '<tr>
								    <td>'.$row['scheduled_date_start'].'</td>
								    <td>'.$row['scheduled_date_end'].'</td>
								    <td>'.$row['congregation_name'].'</td>
								  </tr>';

		}
		$tableScheduleStr .= '</table>';
		return $tableScheduleStr;
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
