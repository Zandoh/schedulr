<?php
class DBcore{
	//connection object
	private $conn;
		
	//Default constructor
	function __construct(){
	//will be the path to our dbInfo
		//require_once('../../../../datainfo/dbinfo.php');
		$db='schedulrDB';
		$host='localhost';
		$user='root';
		$pass='undercontrol22';
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
		$data = array();
		if($stmt = $this->conn->prepare("select user_ID, password, email, phone_number, first_name, last_name, user_type, congregation_ID from USER;")){
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}//end of selectAllUsers	
	/*
	* Select all Congregation Schedules
	*/
	function selectAllCongregationSchedule(){
		$data = array();
		if($stmt = $this->conn->prepare("select congregation_schedule_ID, congregation_schedule_name, congregation_schedule_start_date, congregation_schedule_end_date from CONGREGATION_SCHEDULE;")){
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}//end of select all Congregation Schedules

	/*
	* Select all Congregation Schedule Events from a single congregationschedule
	*/
	function selectAllCongregationScheduleEvents($congregationScheduleID){
		$data = array();
		if($stmt = $this->conn->prepare("select c.congregation_name, csa.congregation_ID, csa.congregation_schedule_ID, csa.scheduled_date_start, csa.scheduled_date_end from CONGREGATION_SCHEDULE_ASSIGNMENT csa JOIN CONGREGATION c using(congregation_ID) WHERE csa.congregation_schedule_ID=:scheduleID;")){
            $stmt->bindParam(':scheduleID', $scheduleID);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}//end of select all Congregation Schedule Events
    
    /*
	* Validate user login
	*/
    function login($email,$pass){
        $secure = hash('sha256', $pass);
        $data = array();
        
		if($stmt = $this->conn->prepare("select email, password from USER where email=:user and password=:secure;")){
            $stmt->bindParam(':user', $email);
            $stmt->bindParam(':secure', $secure);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
             }
            
        if($data){
            return true;
        }
        
        return false;
	}//end of validateLogin	

}//end of class
?>
