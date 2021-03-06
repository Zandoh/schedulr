    <?php
    include 'assets/includes/header.php';
    include 'assets/includes/nav.php';
    include 'handlers/guest_handler.php';
    ?>


	<body class="guest">
    <div class="container guest-container">
      <div class="row justify-content-center">
        <div class="col col-md-8">
          <?php
            // display a select form with all the schedule options
            echo getCongregationSchedules();

            // DEFAULTS to the first schedule in the select
            // check if a schedule has been selected to view
            if (isset($_POST['congregationScheduleList'])){
              // if a schedule has been selected from the select then display the congregations as a table

              echo createSchedule($_POST['congregationScheduleList']);
            }


          include 'assets/includes/footer.php';
          ?>
          </div>
      </div>
    </div>
	</body>

    <script src="assets/js/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="assets/js/vendor/popper.js" type="text/javascript"></script>
    <script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/fullcalendar/lib/moment.min.js" type="text/javascript"></script>
    <script src="assets/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script src="assets/js/vendor/jspdf.min.js" type="text/javascript"></script>
    <script src="assets/js/scripts.min.js" type="text/javascript"></script>
</html>