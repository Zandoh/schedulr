<html>
<?php
    //begin session
    session_start(); 
    //Check if the SESSION is already set
    if (isset($_SESSION['userLogin'])) {
        // logged in
    }
    else{
        //not logged in
        header("Location:login.php");
    }

    include 'assets/includes/header.php';
    include 'handlers/admin_handler.php';


    ?>

  <body class="admin">
    
    <?php include 'assets/includes/nav.php'; ?>

    <div class="container-fluid admin-container">
    <div class="row justify-content-md-center">
      <div class="col-md-8">
        <h1>Edit Users</h1>
        <form id="admin">
          <div class="form-group col-md-4">
            <label for="username-select">Username</label>
            <select class="form-control" id="username-select">
              <!-- TODO: options would be generated here for each user -->
              <?php echo getUserOption(); ?>
            </select>
            <button type="submit" class="submit" id="admin-edit-submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
    <div class="container-fluid admin-container">
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <h1>Add User</h1>
          <form id="add-user" name="addUserSubmit">
            <div class="form-group col-md-4">
              <label for="add-email">Email</label>
              <input type="email" class="form-control" id="add-email" placeholder="Email" name="email">
            </div>
            <div class="form-group col-md-4">
              <label for="add-password">Password</label>
              <input type="text" class="form-control" id="add-password" placeholder="Password" name="password">
            </div>
            <div class="form-group col-md-4">
              <label for="add-phone-number">Phone Number</label>
              <input type="text" class="form-control" id="add-phone-number" placeholder="Phone Number" name="phoneNumber">
            </div>
            <div class="form-group col-md-4">
              <label for="add-fName">First Name</label>
              <input type="text" class="form-control" id="add-fName" placeholder="First Name" name="firstName">
            </div>
            <div class="form-group col-md-4">
              <label for="add-lName">Last Name</label>
              <input type="text" class="form-control" id="add-lName" placeholder="Last Name" name="lastName">
            </div>
            <div class="form-group col-md-4">
              <label for="add-user-type">User Type</label>
              <select class="form-control" id="add-user-type" name="userType">
                <option value="e">Admin</option>
                <option value="b">Bus Driver</option>
                <option value="c">Congregation Lead</option>
              </select>
              <button type="submit" class="submit" id="admin-add-user-submit">Submit</button>
            </div>
          </form>
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