<?php
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
          <input type="text" class="form-control" id="bus-name" placeholder="Bus Driver Name">
        </div>
        <div class="form-group col-md-4">
          <label for="bus-date">Dates</label>
          <input typ"text" class="form-control" id="bus-date" placeholder="Select Dates" disabled>
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
        <button type="add-to-list" class="add-to-list">Add To List</button>
        <div class="form-group col-md-12">
          <label for="list">List of Dates</label>
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
</html>