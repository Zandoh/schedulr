<html>
<?php
    // begin session
    session_start(); 
    // Check if the SESSION is already set
   if (!isset($_SESSION['userLogin'])) {
        // if the user is not logged in, redirect them to the login page
        header("Location:login.php");
    }
    // logged in, check which page to redirect to
    elseif(strcasecmp($_SESSION['userType'],"b") == 0){
      header("Location: bus-avail.php");
    }
    // user is a congregation lead
    elseif(strcasecmp($_SESSION['userType'],"c") == 0){
      header("Location: blackouts.php");
    }

    include 'assets/includes/header.php';
    include 'assets/includes/common.php';
    include 'handlers/admin_handler.php';


  if(isset($_POST['editUserSubmitButton'])){
      // did the user submit the edit form
      // if so then make the changes to the database
      $result = editUser(sanitize($_POST['user_ID']), sanitize($_POST['email']), sanitize($_POST['phoneNumber']), sanitize($_POST['firstName']), sanitize($_POST['lastName']), sanitize($_POST['userType']));
      if ($result) {
        $_SESSION['editUserResult'] = "True";
      } else {
        $_SESSION['editUserResult'] = "False";
      }
  }
  if(isset($_POST['submitAddedUser'])){
      // did the user submit the add user form
      // if so then add the user to the database
      $result = addUser(sanitize($_POST['email']), sanitize($_POST['password']), sanitize($_POST['phoneNumber']), sanitize($_POST['firstName']), sanitize($_POST['lastName']), sanitize($_POST['userType']));
      if ($result) {
        $_SESSION['addUserResult'] = "True";
      } else {
        $_SESSION['addUserResult'] = "False";
      }
  }
  if(isset($_POST['deleteUserButton'])){
    // did the user submit the delete user button
    // if so then delete the user from the database
    $user_ID = sanitize($_POST['userList']);
    $result = deleteUser($user_ID);
    if ($result) {
      $_SESSION['deleteUserResult'] = "True";
    } else {
      $_SESSION['deleteUserResult'] = "False";
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
            <div class="btn-group" role="group">
            <button type="submit" name="editUserButton" class="submit" value="edit" id="admin-edit-submit">Edit User</button>
            <?php
              // if the user was edited show success
              if(isset($_SESSION['editUserResult'])) {
                if($_SESSION['editUserResult'] == "True") {
                  echo "<div class='alert alert-success align-alert' role='alert'>
                        The user has been edited.
                        </div>";
                  unset($_SESSION['editUserResult']);
                } else if ($_SESSION['editUserResult'] == "False") {
                  echo "<label class='error align-alert' style='margin-top: .5rem;'>There was an error editing the user.</label>";
                  unset($_SESSION['editUserResult']);
                }
              }
            ?>
            <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');" name="deleteUserButton" class="submit" value="delete" id="admin-edit-submit">Delete User</button>
            <?php
              // if the user was deleted show success
              if(isset($_SESSION['deleteUserResult'])) {
                if($_SESSION['deleteUserResult'] == "True") {
                  echo "<div class='alert alert-success align-alert' role='alert'>
                        The user has been deleted.
                        </div>";
                  unset($_SESSION['deleteUserResult']);
                } else if ($_SESSION['deleteUserResult'] == "False") {
                  echo "<label class='error align-alert' style='margin-top: .5rem;'>There was an error deleting the user.</label>";
                  unset($_SESSION['deleteUserResult']);
                }
              }
            ?>
            <button type="submit" name="addUserButton" class="submit" value="add" id="admin-edit-submit">Add A New User</button>
            <?php
              // if the user was added correctly, show response
              if(isset($_SESSION['addUserResult'])) {
                if($_SESSION['addUserResult'] == "True") {
                  echo "<div class='alert alert-success align-alert' role='alert'>
                        The user has been added.
                        </div>";
                  unset($_SESSION['addUserResult']);
                } else if ($_SESSION['addUserResult'] == "False") {
                  echo "<label class='error align-alert' style='margin-top: .5rem;'>There was an error adding the user.</label>";
                  unset($_SESSION['addUserResult']);
                }
              }
            ?>
            </div>
          </div>
        </form>
<?php
  
  if(isset($_POST['editUserButton'])){
      // did the user select that they want to edit a user
      // if so then show the edit form populated
      $user_ID = sanitize($_POST['userList']);
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
                // did the user select that they want to add a user
                // if so then show the add form populated
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