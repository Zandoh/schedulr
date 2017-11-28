<html>

<?php
    include 'handlers/login_handler.php';
    include 'assets/includes/header.php';
    ?>

  <body>
    <?php include 'assets/includes/nav.php'; ?>

    <!-- container used for scheduling bus drivers -->
    <body class="bus-schedule">
      <div class="container-fluid bus-schedule-container">
        <div class="row justify-content-md-center">
          <div class="col-md-5">
            <h1>Bus Scheduling</h1>
            <div id="bus-schedule"></div>
            <input id="alt-Input" type="hidden" value="test">
          </div>
          <div class="col-md-5">
            <h1>Day: <span id="schedule-header-date"></span></h1>
            <table class="table table-hover table-bordered" id="schedule-list">
              <thead>
                <tr>
                  <th>Driver Name</th>
                  <th>Time</th>
                </tr>
              </thead>
              <tbody> 
              </tbody>
            </table>
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