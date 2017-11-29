<?php
// begin session
session_start();
// Check if the SESSION is already set
if (!isset($_SESSION['userLogin'])) {
    // if the user is not logged in, redirect them to the login page
    header("Location:login.php");
}
// user is a congregation lead
elseif(strcasecmp($_SESSION['userType'],"c") == 0){
    header("Location: blackouts.php");
}
include 'handlers/login_handler.php';
?>
  <html>

  <head>
    <?php
        include 'assets/includes/header.php';
        include 'assets/includes/nav.php';
        ?>

      <!-- container used for adding RAIHN bus driver available dates and times -->

      <body class="bus">
        <div class="container-fluid bus-avail-container">
          <div class="row justify-content-md-center">
            <div class="col-md-8">
              <h1>Set Availability</h1>
              <form id="bus-avail">
                <div class="form-group col-md-4">
                  <label for="bus-name">Bus Driver Name</label>
                  <select class="form-control" name="bus-name" id="bus-name" disabled="disabled">
                    <option value="" selected>Select Bus Driver</option>
                  </select>
                  <!--<input type="text" class="form-control" id="bus-name" placeholder="Bus Driver Name">-->
                </div>
                <div class="form-group col-md-4">
                  <label for="bus-date">Dates</label>
                  <input type="text" class="form-control" id="bus-date" placeholder="Select Dates" disabled>
                  <div id="date-picker"></div>
                </div>
                <div class="form-group col-md-4">
                  <label for="bus-time">Time Period</label>
                  <select class="form-control" id="bus-time">
                    <option>AM</option>
                    <option>PM</option>
                    <option>Both</option>
                  </select>
                </div>
                <!-- used to add driver information to list -->
                <div id="error-container" class="col-md-4"></div>
                <button type="add-to-list" class="add-to-list">Add To List</button>
                <div class="form-group col-md-12">
                  <label for="list">Availability Dates</label>
                  <table class="table table-hover table-bordered" id="list">
                    <thead>
                      <tr>
                        <th>Driver Name</th>
                        <th>Dates</th>
                        <th>Times</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <!-- used to submit full driver information list to the database -->
                  <button type="submit" class="submit" id="driver-avail-submit">Submit</button>
                </div>
              </form>
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
      <script>
        $(document).ready(function () {
          user.type = "<?php  echo $_SESSION['userType'] ?>";
          user.id = "<?php  echo $_SESSION['userID'] ?>";
          console.log(user.type);
          console.log(user.id);
        });
      </script>

  </html>