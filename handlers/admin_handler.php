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

function returnAdminUsers() {
    $DBcore = new DBcore();
    $userArr = array();
    $userArr = $DBcore->selectAllUsers();
    $json = array();

    foreach($userArr as $row) {
        $user = array(
            'userID' => $row['user_ID'],
            'email' => $row['email']
        );
        array_push($json, $user);
    }

    $jsonstring = json_encode($json);

    return $jsonstring;
}

function returnDrivers() {
    $DBcore = new DBcore();
    $driverArr = array();
    $driverArr = $DBcore->selectAllBusDrivers();
    $json = array();

    foreach($driverArr as $row) {
        $user = array(
            'userID' => $row['user_ID'],
            'firstName' => $row['first_name'],
            'lastName' => $row['last_name']
        );
        array_push($json, $user);
    }

    $jsonstring = json_encode($json);

    return $jsonstring;
}

function returnDriverAvailability($id) {
    $DBcore = new DBcore();
    $driverArr = array();
    $driverArr = $DBcore->selectBusDriverAvailability($id);
    $json = array();

    foreach($driverArr as $row) {
        $user = array(
            'date' => $row['availability_day'],
            'time' => $row['availabilty_time_of_day']
        );
        array_push($json, $user);
    }

    $jsonstring = json_encode($json);

    return $jsonstring;
}

function createEditUserForm($user_ID){
    $DBcore = new DBcore();
    $user = array();
    $user = $DBcore->selectOneUser($user_ID);
     foreach($user as $row) {  
        $userType = $row['user_type'];
        $formStr = '<h1>Edit User</h1>
                <form id="add-user" name="editUserSubmit" method="post">
                  <div class="form-group col-md-4">
                    <label for="add-email">Email</label>
                    <input type="email" class="form-control" id="add-email" placeholder="Email" name="email" value='.$row['email'].'>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-phone-number">Phone Number</label>
                    <input type="text" class="form-control" id="add-phone-number" placeholder="Phone Number" name="phoneNumber" value='.$row['phone_number'].'>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-fName">First Name</label>
                    <input type="text" class="form-control" id="add-fName" placeholder="First Name" name="firstName" value='.$row['first_name'].'>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-lName">Last Name</label>
                    <input type="text" class="form-control" id="add-lName" placeholder="Last Name" name="lastName" value='.$row['last_name'].'>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="add-user-type">User Type</label>
                    <select class="form-control" id="add-user-type" name="userType">';
                 if($userType == "e"){
                       $formStr .= '<option value="e" selected>Admin</option>
                                    <option value="b">Bus Driver</option>
                                    <option value="c">Congregation Lead</option>';
                }
                else if($userType == "b"){
                    $formStr .= '<option value="e">Admin</option>
                                    <option value="b" selected>Bus Driver</option>
                                    <option value="c">Congregation Lead</option>';
                }
                else if($userType = "c"){
                    $formStr .= '<option value="e">Admin</option>
                                    <option value="b">Bus Driver</option>
                                    <option value="c" selected>Congregation Lead</option>';
                }
           $formStr .= '</select>
                    <button type="submit" class="submit" id="admin-add-user-submit">Submit</button>
                  </div>
                </form>';
        }
            return $formStr;

}

function editUser($user_ID, $email, $phone, $firstName, $lastName, $userType, $congregation_ID){
    $DBcore = new DBcore();
    $result = array();
    $result = $DBcore->editOneUser($user_ID, $email, $phone, $firstName, $lastName, $userType, $congregation_ID);
    if ($result) {
        return true;
    } else {
        return false;
    }
}


function addUser($email, $password, $phone, $firstName, $lastName, $userType, $congregation_ID){


}

?>