<?php
require_once('DBcore.class.php');


function getUserOption(){
	$DBcore = new DBcore();
    $userArr = array();
    $userArr = $DBcore->selectAllUsers();
    $optionStr = '';

    foreach($userArr as $row){
        $user_ID = $row['user_ID'];
        $password = $row['password'];
        $email = $row['email'];

        $optionStr .= '<option value="'.$user_ID.'">'.$email.'</option>';

    }//end of foreach

    return $optionStr;
}

function returnAdminUsers() {
    $DBcore = new DBcore();
    $userArr = array();
    $userArr = $DBcore->selectAllUsers();
    $json = array();

    foreach($userArr as $row) {
        $user = array(
            'userID' => $row['user_ID'],
            'email' => $row['email']
        );
        array_push($json, $user);
    }

    $jsonstring = json_encode($json);

    return $jsonstring;
}

function returnDrivers() {
    $DBcore = new DBcore();
    $driverArr = array();
    $driverArr = $DBcore->selectAllBusDrivers();
    $json = array();

    foreach($driverArr as $row) {
        $user = array(
            'userID' => $row['user_ID'],
            'firstName' => $row['first_name'],
            'lastName' => $row['last_name']
        );
        array_push($json, $user);
    }

    $jsonstring = json_encode($json);

    return $jsonstring;
}

function returnDriverAvailability($id) {
    $DBcore = new DBcore();
    $driverArr = array();
    $driverArr = $DBcore->selectBusDriverAvailability($id);
    $json = array();

    foreach($driverArr as $row) {
        $user = array(
            'date' => $row['availability_day'],
            'time' => $row['availabilty_time_of_day']
        );
        array_push($json, $user);
    }

    $jsonstring = json_encode($json);

    return $jsonstring;
}

?>