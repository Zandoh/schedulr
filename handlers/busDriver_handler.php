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

            var_dump($array["id"]);
            var_dump($array["name"]);
            var_dump($array["date"]);
            var_dump($array["time"]);

            // $user_ID = $row['id'];
            // $date = $row['date'];
            // $time_of_day = $row['time'];
            // $clearResult = $DBcore->clearDriverAvailability($user_ID);
            
            // if ($clearResult) {
            //     $insertResult = $DBcore->insertDriverAvailability($user_ID, $date, $time_of_day);
            //     if ($insertResult) {
            //         $status = true;
            //     }
            // }
        }
       
    }
?>