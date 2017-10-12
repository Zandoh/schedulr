<?php
class DBcore{
	//connection object
	private $conn;
		
	//Default constructor
	function __construct(){
	//will be the path to our dbInfo
		require_once('/datainfo/../../../../dbinfo.php');
		try{
        		$this->conn = new PDO('mysql:dbname='.$db.';host='.$host.'', $user, $pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      		}
      		catch(PDOException $e){
        	//used for developing
        	echo'Connection Failed: '.$e->getMessage();
      		}
	}//end of default constructor 
  
	/*
	* Select all users
	*/
	function selectAllUsers(){
		$data = Array();
		if($stmt = $this->conn->prepare("select user_ID, password, email, phone_number, first_name, last_name, user_type, congregation_ID from USER;")){
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}//end of selectAllUsers	

}//end of class
?>
