<?php
/* Handles the functions for the guest page */
require_once('DBcore.class.php');

	/*
	* Populates a select for every congregation year
	*/
	function getCongregationSchedules(){
		$DBcore = new DBcore();
		$congArr = array();
		$congArr = $DBcore->selectAllCongregationSchedule();
		$congStr = '<form class="justify-content-center form-inline" action="index.php" id="congregationform" method="post" name="congregationScheduleForm">
			<div class="form-group text-center"><select class="form-control" name="congregationScheduleList">';
		foreach($congArr as $row){
			$congregation_schedule_ID = $row['congregation_schedule_ID'];
			$congregation_schedule_name = $row['congregation_schedule_name'];
			$congregation_schedule_start_date = $row['congregation_schedule_start_date'];
			$congregation_schedule_end_date = $row['congregation_schedule_end_date'];
			
			$congStr .= '<option value='.$congregation_schedule_ID.'>'.$congregation_schedule_name.'</option>';


		}//end of foreach
			$congStr .= '</select>
						  <input class="submit-button" type="submit" name="submit">
						</form></div>';
		return $congStr;
	}

	/*
	* Creates the congregation table when the user selects a specific year
	*/
	function createSchedule($scheduleID){
		$DBcore = new DBcore();
		$eventArr = array();
		$eventArr = $DBcore->selectAllCongregationScheduleEvents($scheduleID);
		//$sundayArr = getDateForSpecificDayBetweenDates('2017-01-01', '2017-12-31', 0);
		$scheduleName = "";
		foreach($eventArr as $row){
			$scheduleName = $row['congregation_schedule_name'];
		}

		$tableScheduleStr = '<div class="scheduleToPDF"><h2>'.$scheduleName.'</h2>';
		$tableScheduleStr .= '<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Start of Week</th>
										<th>End of Week</th>
										<th>Scheduled Congregation</th>
									</tr>
								</thead>
								<tbody>';
		foreach($eventArr as $row){
			$tableScheduleStr .= '<tr>
								    <td>'.$row['scheduled_date_start'].'</td>
								    <td>'.$row['scheduled_date_end'].'</td>
								    <td>'.$row['congregation_name'].'</td>
								  </tr>';

		}
		$tableScheduleStr .= '</tbody></table></div></div></div><div class="row justify-content-md-center"><input style="margin: 0;" type="submit" value="Download Schedule" class="submit-button" onClick="window.print()"></div>';
		return $tableScheduleStr;
	}

	/*
	* Used to get all Sundays of a specified date range
	*/
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
