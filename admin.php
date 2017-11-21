<html>
<?php
    //begin session
    session_start(); 
    //Check if the SESSION is already set
   if (!isset($_SESSION['userLogin'])) {
        //if the user is not logged in, redirect them to the login page
        header("Location:login.php");
    }
    // logged in, check which page to redirect to
    elseif(strcasecmp($_SESSION['userType'],"b") == 0){
      header("Location: bus-avail.php");
    }
    //user is a congregation lead
    elseif(strcasecmp($_SESSION['userType'],"c") == 0){
      header("Location: blackouts.php");
    }

    include 'assets/includes/header.php';
    include 'handlers/admin_handler.php';


  if(isset($_POST['editUserSubmitButton'])){
      //did the user submit the edit form
      //if so then make the changes to the database
      $result = editUser($_POST['user_ID'], $_POST['email'], $_POST['phoneNumber'], $_POST['firstName'], $_POST['lastName'], $_POST['userType']);
      if ($result) {
          echo 'Successful edit';
      } else {
          echo 'Failed edit';
      }
  }
  if(isset($_POST['submitAddedUser'])){
      //did the user submit the add user form
      //if so then add the user to the database
      $result = addUser($_POST['email'], $_POST['password'], $_POST['phoneNumber'], $_POST['firstName'], $_POST['lastName'], $_POST['userType']);
      if ($result) {
          echo 'Successful add';
      } else {
          echo 'Failed add';
      }
  }
  if(isset($_POST['deleteUserButton'])){
    //did the user submit the delete user button
    //if so then delete the user from the database
    $user_ID = $_POST['userList'];
    $result = deleteUser($user_ID);
    if ($result) {
        echo 'Successful delete';
    } else {
        echo 'Failed delete';
    }
  }
?>
  <body class="admin">
    
    <?php include 'assets/includes/nav.php'; ?>

    <div class="container-fluid admin-container">
    <div class="row justify-content-md-center">
      <div class="col-md-8">
        <h1>Edit Users</h1>
        <form id="admin" action="admin.php" name="editUser" method="post">
          <div class="form-group col-md-4">
            <label for="username-select">Username</label>
            <select class="form-control" name= "userList" id="username-select">
              <!-- options generated here for each user -->
              <?php echo getUserOption(); ?>
            </select>
            <button type="submit" name="editUserButton" class="submit" value="edit" id="admin-edit-submit">Edit User</button>
            <button type="submit" name="addUserButton" class="submit" value="add" id="admin-edit-submit">Add A New User</button>
            <button type="submit" name="deleteUserButton" class="submit" value="delete" id="admin-edit-submit">Delete User</button>
          </div>
        </form>
<?php
  
  if(isset($_POST['editUserButton'])){
      //did the user select that they want to edit a user
      //if so then show the edit form populated
      $user_ID = $_POST['userList'];
     echo createEditUserForm($user_ID);
  }//end of if
  
?>
      </div>
    </div>
    <div class="container-fluid admin-container">
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <?php
            if(isset($_POST['addUserButton'])){
                //did the user select that they want to add a user
                //if so then show the add form populated
               echo createAddUserForm();
            }//end of if
          ?>
        </div>
      </div>
    </div>
</div>

    <?php 
        include 'assets/includes/footer.php';
    ?>
  </body>
  <script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery.validate.min.js"></script>
  <script src="assets/js/vendor/additional-methods.min.js"></script>
  <script src="assets/js/vendor/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery-ui.multidatespicker.js" text="text/javascript"></script>
  <script src="assets/js/vendor/popper.js" type="text/javascript"></script>
  <script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/js/scripts.min.js" type="text/javascript"></script>

</html>