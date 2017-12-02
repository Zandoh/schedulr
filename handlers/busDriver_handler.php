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


    function processDriverAvailability($json){

        $DBcore = new DBcore();
        //this will be the json arr that is given
        $arr = json_decode($json);
        foreach($arr as $row){
            $array = get_object_vars($row);

            $user_ID = $array["id"];
            $clearResult = $DBcore->clearDriverAvailability($user_ID);
            if ($clearResult){
                 //good clear
            }
            else{
                return false;
            }
        }  

        foreach($arr as $row){
            $array = get_object_vars($row);
            $user_ID = $array["id"];
            $date = $array["date"];
            $time_of_day = $array["time"];
                if($time_of_day == "Both"){
                    $insertResult = $DBcore->insertDriverAvailability($user_ID, $date, "AM"); 
                    $insertResult = $DBcore->insertDriverAvailability($user_ID, $date, "PM"); 
                    if ($insertResult){
                         //good insert
                    }
                    else{
                        return false;
                    }
                }
                else{
                    $insertResult = $DBcore->insertDriverAvailability($user_ID, $date, $time_of_day); 
                    if ($insertResult){
                         //good insert
                    }
                    else{
                        return false;
                    }
                }
             
        }
        return true;
       
    }

    function handleBusDriverSchedule($json) {
        var_dump($json);
    }
?>