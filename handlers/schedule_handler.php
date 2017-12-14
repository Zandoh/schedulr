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

function createBusScheduling(){
  $DBcore = new DBcore();
  $eventArr = array();
  $eventArr = $DBcore->selectAllBusScheduleEvents();
  //first_name, last_name, scheduled_day, scheduled_time_of_day, backup
  $scheduleName = "";

  $tableScheduleStr = '<div class="scheduleToPDF"><h2>Bus Schedule</h2>';
  $tableScheduleStr .= '<table class="table table-striped table-bordered sortCongregations">
                          <thead>
                            <tr>
                              <th>Scheduled Day</th>
                              <th>Scheduled Time</th>
                              <th>Role</th>
                              <th>Driver Name</th>
                            </tr>
                          </thead>
                          <tbody>';
  foreach($eventArr as $row){
    $backup = 'Backup';
    if($row['backup'] == 0){
      $backup = 'Primary';
    }
    $tableScheduleStr .= '<tr>
                  <td>'.$row['scheduled_day'].'</td>
                  <td>'.$row['scheduled_time_of_day'].'</td>
                  <td>'.$backup.'</td>
                  <td class="sort-cong-name">'.$row['first_name'].' '.$row['last_name'].'</td>
                </tr>';
  }
  $tableScheduleStr .= '</tbody></table></div></div></div><div class="row justify-content-md-center"><input type="submit" value="Download Schedule" class="submit-button" onClick="window.print()"></div>';
  return $tableScheduleStr;
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
    <div class="form-group text-center"><select class="form-control" name="congregationsToScheduleList" id="rotation-name">';
  foreach($congArr as $row){
    $congregation_schedule_ID = $row['congregation_schedule_ID'];
    $congregation_schedule_name = $row['congregation_schedule_name'];
    $congregation_schedule_start_date = $row['congregation_schedule_start_date'];
    $congregation_schedule_end_date = $row['congregation_schedule_end_date'];
    
    $congStr .= '<option value='.$congregation_schedule_ID.'>'.$congregation_schedule_name.'</option>';


  }//end of foreach
    $congStr .= '</select>
                <input class="submit-button" type="submit" name="submit"></div>
                <input class="submit-button" type="button" id="addRotation" value="Add Rotation" onclick="if(confirm(\'Are you sure you want to do this? Have the congregations submitted their blackout dates?\')) cong_schedule.addRotation();">
                </form>
                <div class="rotationResponseMessage"></div>
                ';
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

  $tableScheduleStr = '<h2>'.$scheduleName.'</h2><span class="congregation-schedule-id" id="'. $row['congregation_schedule_ID'] . '"></span>';
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
                  <td class="tableCongDate">'.$row['scheduled_date_start'].'</td>
                  <td class="tableCongDate">'.$row['scheduled_date_end'].'</td>
                  <td class="sort-cong-name" id="' . $row['congregation_ID'] . '">'.$row['congregation_name'].'</td>
                </tr>';

  }
  $tableScheduleStr .= '</tbody></table>';
  return $tableScheduleStr;
}

/*
* Used to edit the new data for the congregation rotation
*/ 
function editSchedule($json){
  
  $DBcore = new DBcore();
  //this will be the json arr that is given
  $arr = json_decode($json);
  $startDate = '';
  $endDate = '';
  $congregation_schedule_ID = "";
  foreach($arr as $row){
      $array = get_object_vars($row);

      $congregation_schedule_ID = $array['rotation'];

      var_dump($congregation_schedule_ID);
      $clearResult = $DBcore->clearOneCongregationSchedule($congregation_schedule_ID);
      
  }  

  foreach($arr as $row){
      $array = get_object_vars($row);
      $congregation_ID = $array['id'];
      $scheduled_date_start = $array['start_date'];
      $scheduled_date_end = $array['end_date'];
      var_dump($congregation_ID);
      var_dump($scheduled_date_start);
      var_dump($scheduled_date_end);
      var_dump($congregation_schedule_ID);
      $insertResult .= $DBcore->createNewCongregationScheduleAssignments($congregation_ID, $congregation_schedule_ID, $scheduled_date_start, $scheduled_date_end);
        
  }
  return true;
}


?>
