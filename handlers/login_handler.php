<?php
require_once('DBcore.class.php');

	function getUsers(){
		$DBcore = new DBcore();
		$userArr = array();
		$userArr = $DBcore->selectAllUsers();
		$userStr = '';
		foreach($userArr as $row){
			$user_ID = $row['user_ID'];
			$password = $row['password'];
			$email = $row['email'];
			
			$userStr .= '<p>User ID: '.$user_ID.'</br>';
			$userStr .= 'Password: '.$email.'</br></p>';
			
		}//end of foreach
		return $userStr;
	}
?>