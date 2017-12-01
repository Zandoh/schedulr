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
    include 'handlers/login_handler.php';
    include 'assets/includes/header.php';
    ?>

  <body class="cong-blackouts">
    <?php include 'assets/includes/nav.php'; ?>
      <div class="container-fluid cong-blackout-container">
        <div class="row justify-content-md-center">
          <div class="col-md-8">
            <h1>Blackout Dates
                <i class="fa fa-question-circle" data-placement="right" data-toggle="tooltip" data-html="true" 
                    title="Select your congregation then click on a blackout date.  
                           Hit <strong><em>ADD TO LIST</em></strong> to add multiple blackout dates. 
                           Each date added excludes you from that whole week.
                           Hit the red icon in the table to delete dates. When finished, click <strong><em>SUBMIT</em></strong>." aria-hidden="true">
                </i>
            </h1>
            <form id="cong-blackouts">
                <div class="form-group col-md-4">
                  <label for="cong-name">Congregation</label>
                  <select class="form-control" name="cong-name" id="cong-name" disabled="disabled">
                    <option value="" selected>Select Congregation</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="cong-date">Dates</label>
                  <input type="text" class="form-control" id="cong-date" placeholder="Select Dates" disabled>
                  <div id="blackout-calendar"></div>
                </div>
                <!-- the list of blackouts added -->
                <div id="error-container" class="col-md-4"></div>
                <button type="add-to-list" class="add-to-list">Add To List</button>
                <div class="form-group col-md-12">
                  <label for="blackout-list">List of Blackouts</label>
                  <table class="table table-hover table-bordered" id="blackout-list">
                    <thead>
                      <tr>
                        <th>Congregation</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <!-- used to submit full driver information list to the database -->
                  <button type="submit" class="submit" id="cong-blackout-submit">Submit</button>
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
        var retCong = {  
            <?php if(isset($_SESSION['userType'])) { echo "type: " . json_encode($_SESSION['userType']); } ?>
            <?php if(isset($_SESSION['userID'])) { echo ", id: " . json_encode($_SESSION['userID']); } ?>
            <?php echo ", cid: " . json_encode(getCongFromUserId($_SESSION['userID'])); ?>        
        };     
</script>
</html>