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
    include 'handlers/login_handler.php';
    include 'assets/includes/header.php';
    ?>

    <!-- container used for scheduling congregations -->
    <body class="cong-schedule">
      <?php include 'assets/includes/nav.php';
            include 'handlers/schedule_handler.php';
      ?>
      <div class="container-fluid cong-schedule-container">
        <div class="row justify-content-md-center">
          <div class="col-md-8">
            <h1>Congregations Scheduling
              <i class="fa fa-question-circle" data-placement="right" data-toggle="tooltip" data-html="true" 
                  title="Select a rotation from the select list and click <strong>SUBMIT</strong>. 
                          Then you can click and drag around the congregation names in the table.   
                          When you're finished, click <strong>SAVE</strong>." aria-hidden="true">
              </i>
            </h1>
            <?php
            // display a select form with all the schedule options
            echo getCongregationsToSchedule();

            // DEFAULTS to the first schedule in the select
            // check if a schedule has been selected to view
            if (isset($_POST['congregationsToScheduleList'])){
              // if a schedule has been selected from the select then display the congregations as a table

              echo createScheduling($_POST['congregationsToScheduleList']);
              echo  "<!-- used to submit full congregation schedule to the db -->
                    <div class='responseMessage'></div>
                    <button type='submit' class='submit' id='updateCongregations'>SAVE</button>";
            }
            ?>
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
  <script srx="assets/js/vendor/jspdf.min.js" type="text/javascript"></script>
  <script src="assets/js/scripts.min.js" type="text/javascript"></script>

</html>