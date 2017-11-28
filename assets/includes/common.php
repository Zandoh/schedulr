<?php
	function sanitize($var){
        $var = trim($var);
        $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlspecialchars($var);
        return $var;
    }
?>