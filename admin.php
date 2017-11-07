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


    ?>

  <body>
    <!-- navigation for logged in user -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="/schedulr">
        <img src="assets/img/raihn-logo.png" width="187" height="60" class="d-inline-block" alt="RAIHN Logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="login_landing.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container-fluid admin-container">
    <div class="row justify-content-md-center">
      <div class="col-md-8">
        <h1>Edit Users</h1>
        <form id="admin">
          <div class="form-group col-md-4">
            <label for="username-select">Username</label>
            <select class="form-control" id="username-select">
              <!-- TODO: options would be generated here for each user -->
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
          <form id="add-user">
            <div class="form-group col-md-4">
              <label for="add-email">Email</label>
              <input type="text" class="form-control" id="add-email" placeholder="Email">
            </div>
            <div class="form-group col-md-4">
              <label for="add-password">Password</label>
              <input type="text" class="form-control" id="add-password" placeholder="Password">
            </div>
            <div class="form-group col-md-4">
              <label for="add-phone-number">Phone Number</label>
              <input type="text" class="form-control" id="add-phone-number" placeholder="Phone Number">
            </div>
            <div class="form-group col-md-4">
              <label for="add-fName">First Name</label>
              <input type="text" class="form-control" id="add-fName" placeholder="First Name">
            </div>
            <div class="form-group col-md-4">
              <label for="add-lName">Last Name</label>
              <input type="text" class="form-control" id="add-lName" placeholder="Last Name">
            </div>
            <div class="form-group col-md-4">
              <label for="add-user-type">User Type</label>
              <select class="form-control" id="add-user-type">
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
  <script src="assets/js/vendor/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery-ui.multidatespicker.js" text="text/javascript"></script>
  <script src="assets/js/vendor/popper.js" type="text/javascript"></script>
  <script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/js/scripts.min.js" type="text/javascript"></script>

</html>