<?php
	// get rid of the session and return the user to the login page
	session_start();
	session_unset();
	header("Location: login.php");
?>