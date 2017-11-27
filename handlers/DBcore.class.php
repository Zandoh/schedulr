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
		if($stmt = $this->conn->prepare("select c.congregation_name, csa.congregation_ID, csa.congregation_schedule_ID, csa.scheduled_date_start, csa.scheduled_date_end from CONGREGATION_SCHEDULE_ASSIGNMENT csa JOIN CONGREGATION c using(congregation_ID) WHERE csa.congregation_schedule_ID=:scheduleID order by csa.scheduled_date_start;")){
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
		if($stmt = $this->conn->prepare("select ad.availability_day, ad.availability_time_of_day from AVAILABILITY_DATE ad JOIN BUS_DRIVER_AVAILABILITY bda using(availability_date_ID) WHERE bda.user_ID=:user_ID;")){
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
		if($stmt = $this->conn->prepare("select congregation_ID, congregation_name, congregation_street_address, congregation_phone, congregation_bus_need, congregation_city, congregation_state, congregation_zip from CONGREGATION;")){
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
	* Update user password from email
	*/
	function updatePassword($email, $password, $key) {

		//use the same salt as in the EmailUser class
		$salt = "i7S1xo9pvXG%u1Krd8Fhi3oE2JEZzQ4csCUqeKc07OsiHj96j7*sp3pXcO9C1H9jiM0jqCKfMbb8phzu";
		
		//create the reset key to compare its value to our url key
		$resetKey = hash('sha256', $salt . $email);

		//if the url matches what it should be, then update the user info
		if ($resetKey == $key) {
			//only let the user reset email if its been under 15 minutes
			if((time() - $_SESSION['userDateTime']) > 15*60) {
				return false;
				} else {
					$secure = hash('sha256', $password);

					if($stmt = $this->conn->prepare("update USER set password=:secure where email=:user;")) {
						$stmt->bindParam(':secure', $secure);
						$stmt->bindParam(':user', $email);
						$stmt->execute();

						if ($stmt->rowCount()) {
							return true;
						} else {
							return false;
						}
				}
			}
		
		} else {
			return false;
		}
	}//end of updatePassword


	/*
	* Password Reset; see if the user email exists
	*/
	function emailExists($email) {
		$data = array();

		if($stmt = $this->conn->prepare("select email from USER where email=:user;")) {
			$stmt->bindParam(':user', $email);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if (!$data) {
				//no user exists for this email
				return false;
			} else {
				//user was found for this email
				return true;
			}

		}
	}//end of emailExists


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
	function selectPreviousRotation(){
		$data = 0;
		if($stmt = $this->conn->prepare("select cng.congregation_name FROM CONGREGATION_SCHEDULE_ASSIGNMENT csa JOIN CONGREGATION cng ON csa.congregation_ID = cng.congregation_ID WHERE csa.congregation_schedule_ID= ANY(select MAX(csa.congregation_schedule_ID) FROM CONGREGATION_SCHEDULE_ASSIGNMENT csa) ORDER BY csa.scheduled_date_start;")){
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}
    

	function selectOneUser($user_ID){
		$data = array();
		if($stmt = $this->conn->prepare("select user_ID, email, phone_number, first_name, last_name, user_type, congregation_ID from USER where user_ID=:user_ID;")){
			$stmt->bindParam(':user_ID', $user_ID);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;
	}
    
	function selectOneCongregation($congregation_ID){
		$data = array();
		if($stmt = $this->conn->prepare("select congregation_ID, congregation_name, congregation_street_address, congregation_phone, congregation_bus_need, congregation_city, congregation_state, congregation_zip from CONGREGATION where congregation_ID=:congregation_ID;")){
			$stmt->bindParam(':congregation_ID', $congregation_ID);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;
	}

	/*
	* Manage users -- edit a user -- cannot reset a users password
	*/
	function editOneUser($user_ID, $email, $phone, $firstName, $lastName, $userType){
		
		if($stmt = $this->conn->prepare("update USER set email=:email, phone_number=:phone, first_name=:firstName, last_name=:lastName, user_type=:userType where user_ID=:user_ID;")) {
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':phone', $phone);
			$stmt->bindParam(':firstName', $firstName);
			$stmt->bindParam(':lastName', $lastName);
			$stmt->bindParam(':userType', $userType);
			$stmt->bindParam(':user_ID', $user_ID);
			$stmt->execute();

			if ($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
		}
	}

	/*
	* Manage users -- add a user
	*/
	function addOneUser($email, $password, $phone, $firstName, $lastName, $userType){

        $secure = hash('sha256', $password);
		if($stmt = $this->conn->prepare("insert into USER (email, password, phone_number, first_name, last_name, user_type, congregation_ID) values (:email, :password, :phone_number, :first_name, :last_name, :user_type, 1);")) {
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':password', $secure);
			$stmt->bindParam(':phone_number', $phone);
			$stmt->bindParam(':first_name', $firstName);
			$stmt->bindParam(':last_name', $lastName);
			$stmt->bindParam(':user_type', $userType);
			$stmt->execute();

			if ($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
		}
	}

	/*
	* Manage users -- delete a user
	*/
	function removeOneUser($user_ID){
		if($stmt = $this->conn->prepare("delete from USER where user_id=:user_ID;")) {
			$stmt->bindParam(':user_ID', $user_ID);
			$stmt->execute();
			if ($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
		}
	}

/*
	* Manage congregations -- edit a congregation 
	*/
	function editOneCongregation($congregation_ID, $congregation_name, $congregation_street_address, $congregation_phone, $congregation_bus_need, $congregation_city, $congregation_state, $congregation_zip){
		
		if($stmt = $this->conn->prepare("update CONGREGATION set congregation_name=:congregation_name, congregation_street_address=:congregation_street_address, congregation_phone=:congregation_phone, congregation_bus_need=:congregation_bus_need, congregation_city=:congregation_city, congregation_state=:congregation_state, congregation_zip=:congregation_zip where congregation_ID=:congregation_ID;")) {
			$stmt->bindParam(':congregation_name', $congregation_name);
			$stmt->bindParam(':congregation_street_address', $congregation_street_address);
			$stmt->bindParam(':congregation_phone', $congregation_phone);
			$stmt->bindParam(':congregation_bus_need', $congregation_bus_need);
			$stmt->bindParam(':congregation_city', $congregation_city);
			$stmt->bindParam(':congregation_state', $congregation_state);
			$stmt->bindParam(':congregation_zip', $congregation_zip);
			$stmt->bindParam(':congregation_ID', $congregation_ID);
			$stmt->execute();

			if ($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
		}
	}

	/*
	* Manage congregations -- add a congregation
	*/
	function addOneCongregation($congregation_name, $congregation_street_address, $congregation_phone, $congregation_bus_need, $congregation_city, $congregation_state, $congregation_zip){

		if($stmt = $this->conn->prepare("insert into CONGREGATION (congregation_name, congregation_street_address, congregation_phone, congregation_bus_need, congregation_city, congregation_state, congregation_zip) values (:congregation_name, :congregation_street_address, :congregation_phone, :congregation_bus_need, :congregation_city, :congregation_state, :congregation_zip);")) {
			$stmt->bindParam(':congregation_name', $congregation_name);
			$stmt->bindParam(':congregation_street_address', $congregation_street_address);
			$stmt->bindParam(':congregation_phone', $congregation_phone);
			$stmt->bindParam(':congregation_bus_need', $congregation_bus_need);
			$stmt->bindParam(':congregation_city', $congregation_city);
			$stmt->bindParam(':congregation_state', $congregation_state);
			$stmt->bindParam(':congregation_zip', $congregation_zip);
			$stmt->execute();

			if ($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
		}
	}

	/*
	* Manage congregations -- delete a congregation
	*/
	function removeOneCongregation($congregation_ID){
		if($stmt = $this->conn->prepare("delete from CONGREGATION where congregation_ID=:congregation_ID;")) {
			$stmt->bindParam(':congregation_ID', $congregation_ID);
			$stmt->execute();
			if ($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
		}
	}


}//end of class
?>
