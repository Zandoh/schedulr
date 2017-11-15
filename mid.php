<?php
	if(isset($_REQUEST['method'])) {
    
		foreach(glob("./handlers/".$_REQUEST['file'].".php") as $filename) {
      include $filename;
    }
    
    $serviceMethod = $_REQUEST['method'];
    
		if(isset($_REQUEST['data'])) {
      $data = $_REQUEST['data'];
      $result =@call_user_func($serviceMethod, $data);
    } else {
      $result =@call_user_func($serviceMethod);
    }
    
		if($result) {
			header("Content-Type:text/plain");
			echo $result;
		}
	}
?>