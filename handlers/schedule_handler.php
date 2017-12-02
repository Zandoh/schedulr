<?php
/* Used to handle the congregation schedule */
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
* Select previous congregation rotation ID
*/
function getPreviousRotation(){
		$DBcore = new DBcore();
		$congArr = array();
        $congStr = '';
        $congStr .= '<p>Cong Array: </br>';
		$congArr = $DBcore->selectPreviousRotation();
		foreach($congArr as $row){
			$congregation_name = $row['congregation_name'];
			$congStr .=$congregation_name.'</br>';
		}//end of foreach
		return $congStr;
}

/*
* Populates a select for every congregation year for the congregation scheduling page
*/
function getCongregationsToSchedule(){
  $DBcore = new DBcore();
  $congArr = array();
  $congArr = $DBcore->selectAllCongregationSchedule();
  $congStr = '<form class="form-inline" action="" id="congregationScheduleForm" method="post" name="congregationsToScheduleForm">
    <div class="form-group text-center"><select class="form-control" name="congregationsToScheduleList">';
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
* Creates the congregation table when the user selects a specific year for the congregation schedule page
*/
function createScheduling($scheduleID){
  $DBcore = new DBcore();
  $eventArr = array();
  $eventArr = $DBcore->selectAllCongregationScheduleEvents($scheduleID);
  //$sundayArr = getDateForSpecificDayBetweenDates('2017-01-01', '2017-12-31', 0);
  $scheduleName = "";
  foreach($eventArr as $row){
    $scheduleName = $row['congregation_schedule_name'];
  }

  $tableScheduleStr = '<h2>'.$scheduleName.'</h2>';
  $tableScheduleStr .= '<table class="table table-striped table-bordered sortCongregations">
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
                  <td class="sort-cong-name">'.$row['congregation_name'].'</td>
                </tr>';

  }
  $tableScheduleStr .= '</tbody></table>';
  return $tableScheduleStr;
}


?>