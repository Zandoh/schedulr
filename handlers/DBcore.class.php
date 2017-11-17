<?php
class DBcore{
	//connection object
	private $conn;
		
	//Default constructor
	function __construct(){
	//will be the path to our dbInfo
		//require_once('../../../../datainfo/dbinfo.php');
		$db='schedulrDB';
		//$host='localhost';
		$host='127.0.0.1:3306';
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
	function selectAllCongregationScheduleEvents($scheduleID){
		$data = array();
		if($stmt = $this->conn->prepare("select c.congregation_name, csa.congregation_ID, csa.congregation_schedule_ID, csa.scheduled_date_start, csa.scheduled_date_end from CONGREGATION_SCHEDULE_ASSIGNMENT csa JOIN CONGREGATION c using(congregation_ID) WHERE csa.congregation_schedule_ID=:scheduleID;")){
            $stmt->bindParam(':scheduleID', $scheduleID);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}//end of select all Congregation Schedule Events
    
    
	/*
	* Select all Bus Drivers
	*/
	function selectAllBusDrivers(){
		$data = array();
		if($stmt = $this->conn->prepare("select user_ID, first_name, last_name from USER WHERE user_type='B';")){
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}


	/*
	* Select a Bus Drivers availability
	*/
	function selectBusDriverAvailability($user_ID){
		$data = array();
		if($stmt = $this->conn->prepare("select ad.availability_day, ad.availabilty_time_of_day from AVAILABILTY_DATE ad JOIN BUS_DRIVER_AVAILABILTY bda using(availability_date_ID) WHERE bda.user_ID=:user_ID;")){
            $stmt->bindParam(':user_ID', $user_ID);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}

	/*
	* Select all congregations
	*/
	function selectAllCongregations(){
		$data = array();
		if($stmt = $this->conn->prepare("select congregation_ID, congregation_name from CONGREGATION;")){
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}//end of select all Congregations


	/*
	* Select a Congregations blackout dates
	*/
	function selectCongregationBlackoutDates($congregation_ID){
		$data = array();
		if($stmt = $this->conn->prepare("select bd.blackout_date_start, bd.blackout_date_end from BLACKOUT_DATE bd JOIN CONGREGATION_BLACKOUT_DATE cbd using(blackout_date_ID) WHERE cbd.congregation_ID=:congregation_ID;")){
            $stmt->bindParam(':congregation_ID', $congregation_ID);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}



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

	/*
	* Select a user type
	*/
	function selectUserType($email){
		$data = array();
		if($stmt = $this->conn->prepare("select user_type from USER where email=:email;")){
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		$userType = '';
		foreach($data as $row){
			$userType .= $row['user_type'];
		}
		return $userType;	
	}//end of selectAllUsers	
    
    
    
        /*
	* Select previous congregation rotation ID
	*/
	function selectPreviousRotationID(){
		$data = 0;
		if($stmt = $this->conn->prepare("SELECT MAX(csa.congregation_schedule_ID) FROM CONGREGATION_SCHEDULE_ASSIGNMENT csa;")){
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}
    
    /*
	* Select previous congregation rotation order
	*/
	function selectCongregationRotation(){
		$data = array();
		if($stmt = $this->conn->prepare("SELECT cng.congregation_name FROM CONGREGATION_SCHEDULE_ASSIGNMENT csa JOIN CONGREGATION cng WHERE (csa.congregation_ID = cng.congregation_ID) and (csa.congregation_schedule_ID=1) ORDER BY csa.scheduled_date_start;")){
            //$stmt->bindParam(':previousRotation', $rotCount);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}
    

}//end of class
?>
