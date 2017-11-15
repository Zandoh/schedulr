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

?>