<?php
/* Used to handle the login functions */
require_once('DBcore.class.php');

/*
* Gets and sends back all users
*/
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

/*
* Checks to see if user can log in successfully
*/
function getLogin(){

    if(isset($_POST['LoginSubmit'])){
        $email = $_POST['account'];
        $pass = $_POST['secure'];
        $DBcore = new DBcore();
        $userArr = array();
        $userResult = $DBcore->login($email,$pass);

        if($userResult){
            // successful login
            $_SESSION['userLogin'] = $email;
        }else{
            // not a successful login
            $_SESSION['failedLogin'] = "Email or Password was incorrect";
        }
        // form not completed filled out
        $_SESSION['failedLogin'] = "Fill out all form fields";
        
    }else {
            $_SESSION['failedLogin'] = "Invalid Email and/or Password. Please try again.";
    }
}
?>