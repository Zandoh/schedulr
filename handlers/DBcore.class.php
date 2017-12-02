<?php
class DBcore {
	// connection object
	private $conn;
		
	// Default constructor
	function __construct(){
	// will be the path to our dbInfo
		//require_once(__DIR__ . '../../../../datainfo/dbinfo.php');
		$db='schedulrDB';
		// $host='localhost';
		$host='127.0.0.1:3306';
		$user='root';
		$pass='undercontrol22';
		try{
        		$this->conn = new PDO('mysql:dbname='.$db.';host='.$host.'', $user, $pass, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      		}
      		catch(PDOException $e){
        	// used for developing
        	echo'Connection Failed: '.$e->getMessage();
      		}
	}// end of default constructor 
  
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
		if($stmt = $this->conn->prepare("select c.congregation_name, csa.congregation_ID, csa.congregation_schedule_ID, cs.congregation_schedule_name, csa.scheduled_date_start, csa.scheduled_date_end from CONGREGATION_SCHEDULE_ASSIGNMENT csa JOIN CONGREGATION c using(congregation_ID) join CONGREGATION_SCHEDULE cs using(congregation_schedule_ID) WHERE csa.congregation_schedule_ID=:scheduleID order by csa.scheduled_date_start;")){
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

	//select u.user_ID, u.first_name, u.last_name, ad.availability_day, ad.availability_time_of_day from AVAILABILITY_DATE ad JOIN BUS_DRIVER_AVAILABILITY bda using(availability_date_ID) JOIN USER u using(user_ID) WHERE u.user_type="b" AND ad.availability_day="2017-11-01";

	/*
	* Select all bus drivers who are available on the given date
	*/
	function selectAllAvailableBusDriversOnDate($date){
		$data = array();
		if($stmt = $this->conn->prepare("select u.user_ID, u.first_name, u.last_name, ad.availability_day, ad.availability_time_of_day from AVAILABILITY_DATE ad JOIN BUS_DRIVER_AVAILABILITY bda using(availability_date_ID) JOIN USER u using(user_ID) WHERE u.user_type='b' AND ad.availability_day=:date;")){
            $stmt->bindParam(':date', $date);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $data;	
	}


	/*
	* rewrite new values belonging to a driver
	*/
	function insertDriverAvailability($user_ID, $availability_day, $availability_time_of_day){
		$availability_date_ID = '';
		$data = array();
		//insert 1 record for the bus driver
		//check to see if the availability date exists in the db
		if($stmt = $this->conn->prepare("select availability_date_ID from AVAILABILITY_DATE where availability_day=:availability_day AND availability_time_of_day=:availability_time_of_day;")) {
			$stmt->bindParam(':availability_day', $availability_day);
			$stmt->bindParam(':availability_time_of_day', $availability_time_of_day);
			$stmt->execute();
			if ($stmt->rowCount()) {
				//the date already exists in the db
				//do nothing
			} else {
				//if the availability date doesn't exist then add it
				if($stmt = $this->conn->prepare("insert into AVAILABILITY_DATE (availability_day, availability_time_of_day) values (:availability_day, :availability_time_of_day);")) {
					$stmt->bindParam(':availability_day', $availability_day);
					$stmt->bindParam(':availability_time_of_day', $availability_time_of_day);
					$stmt->execute();
					if ($stmt->rowCount()) {
						//the record was added
						//do nothing
					} else {
						return false;
					}
				}//end of if

			}//end of else
		}//end of it
		//if the availability date exists or has already been added then get the id of the availability date
		if($stmt = $this->conn->prepare("select availability_date_ID from AVAILABILITY_DATE where availability_day=:availability_day AND availability_time_of_day=:availability_time_of_day;")) {
			$stmt->bindParam(':availability_day', $availability_day);
			$stmt->bindParam(':availability_time_of_day', $availability_time_of_day);
			$stmt->execute();
			if ($stmt->rowCount()) {
				//assign a value to the availability_date_ID
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach($data as $row){
					$availability_date_ID = $row['availability_date_ID'];
				}
				
			} else {
				return false;
			}
		}


		//after you have the id of the availability date and the user id then insert that in BUS_DRIVER_AVAILABILITY
		if($stmt = $this->conn->prepare("insert into BUS_DRIVER_AVAILABILITY (user_ID, availability_date_ID) values (:user_ID, :availability_date_ID);")) {
			$stmt->bindParam(':user_ID', $user_ID);
			$stmt->bindParam(':availability_date_ID', $availability_date_ID);
			$stmt->execute();
			if ($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
		}
	}

	/*
	* remove all values belonging to a driver 
	*/
	function clearDriverAvailability($user_ID){
		//delete all records where user_ID is the same
		if($stmt = $this->conn->prepare("delete from BUS_DRIVER_AVAILABILITY where user_ID=:user_ID;")) {
			$stmt->bindParam(':user_ID', $user_ID);
			$stmt->execute();
			if ($stmt->rowCount()) {
				return true;
			} else {
				//check if there a failure if no rows were changed
				//return false;
				return true;
			}
		}

	}


	/*
	* rewrite new values belonging to a congregation
	*/
	function insertBlackouts($congregation_ID, $start_date, $end_date){
		$blackout_date_ID = '';
		$data = array();
		//insert 1 record for the congregation
		//check to see if the blackout date exists in the db
		if($stmt = $this->conn->prepare("select blackout_date_ID from BLACKOUT_DATE where blackout_date_start=:blackout_date_start AND blackout_date_end=:blackout_date_end;")) {
			$stmt->bindParam(':blackout_date_start', $start_date);
			$stmt->bindParam(':blackout_date_end', $end_date);
			$stmt->execute();
			if ($stmt->rowCount()) {
				//the date already exists in the db
				//do nothing
			} else {
				//if the blackout date doesn't exist then add it
				if($stmt = $this->conn->prepare("insert into BLACKOUT_DATE (blackout_date_start, blackout_date_end) values (:blackout_date_start, :blackout_date_end);")) {
					$stmt->bindParam(':blackout_date_start', $start_date);
					$stmt->bindParam(':blackout_date_end', $end_date);
					$stmt->execute();
					if ($stmt->rowCount()) {
						//the record was added
						//do nothing
					} else {
						return false;
					}
				}//end of if

			}//end of else
		}//end of it
		//if the blackout date exists or has already been added then get the id of the blackout date
		if($stmt = $this->conn->prepare("select blackout_date_ID from BLACKOUT_DATE where blackout_date_start=:blackout_date_start AND blackout_date_end=:blackout_date_end;")) {
			$stmt->bindParam(':blackout_date_start', $start_date);
			$stmt->bindParam(':blackout_date_end', $end_date);
			$stmt->execute();
			if ($stmt->rowCount()) {
				//assign a value to the blackout_date_ID
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach($data as $row){
					$blackout_date_ID = $row['blackout_date_ID'];
				}
				
			} else {
				return false;
			}
		}
		//after you have the id of the blackout date and the congregation id then insert that in CONGREGATION_BLACKOUT_DATE
		if($stmt = $this->conn->prepare("insert into CONGREGATION_BLACKOUT_DATE (congregation_ID, blackout_date_ID) values (:congregation_ID, :blackout_date_ID);")) {
			$stmt->bindParam(':congregation_ID', $congregation_ID);
			$stmt->bindParam(':blackout_date_ID', $blackout_date_ID);
			$stmt->execute();
			if ($stmt->rowCount()) {
				return true;
			} else {
				return false;
			}
		}
	}

	/*
	* remove all blackout date values belonging to a congregation 
	*/
	function clearBlackouts($congregation_ID){
		//delete all records where congregation_ID is the same
		if($stmt = $this->conn->prepare("delete from CONGREGATION_BLACKOUT_DATE where congregation_ID=:congregation_ID;")) {
			$stmt->bindParam(':congregation_ID', $congregation_ID);
			$stmt->execute();
			if ($stmt->rowCount()) {
				return true;
			} else {
				//check if there a failure if no rows were changed
				//return false;
				return true;
			}
		}

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
	* Validate user login and returns true if user exists
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
	* Update user password using email, password, and a key
	*/
	function updatePassword($email, $password, $key) {

		// use the same salt as in the EmailUser class
		$salt = "i7S1xo9pvXG%u1Krd8Fhi3oE2JEZzQ4csCUqeKc07OsiHj96j7*sp3pXcO9C1H9jiM0jqCKfMbb8phzu";
		
		// create the reset key to compare its value to our url key
		$resetKey = hash('sha256', $salt . $email);

		// if the url matches what it should be, then update the user info
		if ($resetKey == $key) {
			// only let the user reset email if its been under 15 minutes
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
	* Select a user ID
	*/
	function selectUserID($email){
		$data = array();
		if($stmt = $this->conn->prepare("select user_ID from USER where email=:email;")){
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		$userType = '';
		foreach($data as $row){
			$userType .= $row['user_ID'];
		}
		return $userType;	
	}//end of selectAllUsers


    /*
	* Select previous congregation rotation ID for algorithm
	*/
	function selectPreviousRotation(){
		$data = "";
		$result = array();
		if($stmt = $this->conn->prepare("select congregation_schedule_ID from CONGREGATION_SCHEDULE where congregation_schedule_end_date = (select MAX(congregation_schedule_end_date) FROM CONGREGATION_SCHEDULE);")){
			$stmt->execute();
			$data = $stmt->fetch();
			
			$id = "";
			foreach($data as $row){
				$id = $row['congregation_schedule_ID'];
			}//end of foreach
			
			if($stmt = $this->conn->prepare("select * FROM CONGREGATION_SCHEDULE_ASSIGNMENT csa JOIN CONGREGATION cng ON csa.congregation_ID = cng.congregation_ID WHERE csa.congregation_schedule_ID=:id ORDER BY csa.scheduled_date_start;")){
			$stmt->bindParam(':id', $id);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			}			
		}
		return $result;		
	}
    
  /*
	* Select a specific user from their id
	*/
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
	* Manage users -- edit a user (cannot edit their password)
	*/
	function editOneUser($user_ID, $email, $phone, $firstName, $lastName, $userType, $congregation_ID){
		
		if($stmt = $this->conn->prepare("update USER set email=:email, phone_number=:phone, first_name=:firstName, last_name=:lastName, user_type=:userType, congregation_ID =:congregation_ID where user_ID=:user_ID;")) {
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':phone', $phone);
			$stmt->bindParam(':firstName', $firstName);
			$stmt->bindParam(':lastName', $lastName);
			$stmt->bindParam(':userType', $userType);
			$stmt->bindParam(':congregation_ID', $congregation_ID);
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
	function addOneUser($email, $password, $phone, $firstName, $lastName, $userType, $congregation_ID){

      $secure = hash('sha256', $password);
		  if($stmt = $this->conn->prepare("insert into USER (email, password, phone_number, first_name, last_name, user_type, congregation_ID) values (:email, :password, :phone_number, :first_name, :last_name, :user_type, :congregation_ID);")) {
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':password', $secure);
				$stmt->bindParam(':phone_number', $phone);
				$stmt->bindParam(':first_name', $firstName);
				$stmt->bindParam(':last_name', $lastName);
				$stmt->bindParam(':user_type', $userType);
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
