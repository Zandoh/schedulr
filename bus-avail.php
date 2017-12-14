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
              <h1>Set Availability
                <i class="fa fa-question-circle" data-placement="right" data-toggle="tooltip" data-html="true" 
                    title="Select your name then click on the dates that you are available and the corresponding time period.  
                           Hit <strong><em>ADD TO LIST</em></strong> to add days with different time periods. 
                           Hit the red icon in the table to delete dates. When finished, click <strong><em>SUBMIT</em></strong>." aria-hidden="true">
                </i>
              </h1>
              <!-- tip buttton for usability -->
              
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
                  <div class="responseMessage">
                  </div>
                  <button type="submit" class="submit" id="driver-avail-submit">Submit</button>
                  <button type="button" class="submit" id="reset">Clear All Dates</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <?php include 'assets/includes/footer.php'; ?>
      </body>
      <script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
      <script src="assets/js/vendor/jquery-ui.min.js" type="text/javascript"></script>
      <script src="assets/js/vendor/jquery-ui.multidatespicker.js" text="text/javascript"></script>
      <script src="assets/js/vendor/popper.js" type="text/javascript"></script>
      <script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
      <script src="assets/js/scripts.min.js" type="text/javascript"></script>
      <script>

          var user = {
            <?php if(isset($_SESSION['userType'])) { echo "type: " . json_encode($_SESSION['userType']); } ?>
            <?php if(isset($_SESSION['userID'])) { echo ", id: " . json_encode($_SESSION['userID']); } ?>
          };

          console.log(user.type);
          console.log(user.id);

      </script>

  </html>