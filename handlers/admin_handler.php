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

?>