<html>

<?php

  // if there is no session, resume one
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  // Check to make sure users have access to this page
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
  include 'handlers/congregation_handler.php';
   
  if(isset($_POST['editCongregationSubmitButton'])){
      //did the user submit the edit form
      //if so then make the changes to the database
      //assumes all congregations need a bus
      $result = editCongregation($_POST['congregation_ID'], $_POST['congregation_name'], $_POST['congregation_street_address'], $_POST['congregation_phone'], 1, $_POST['congregation_city'], $_POST['congregation_state'], $_POST['congregation_zip']);
      if ($result) {
        $_SESSION['editCongregationResult'] = "True";
      } else {
        $_SESSION['editCongregationResult'] = "False";
      }
  }
  if(isset($_POST['submitAddedCongregation'])){
      //did the user submit the add congregation form
      //if so then add the user to the database
      //assumes all congregations need a bus
      $result = addCongregation($_POST['congregation_name'], $_POST['congregation_street_address'], $_POST['congregation_phone'], 1, $_POST['congregation_city'], $_POST['congregation_state'], $_POST['congregation_zip']);
      if ($result) {
        $_SESSION['addCongregationResult'] = "True";
      } else {
        $_SESSION['addCongregationResult'] = "False";
      }
  }
  if(isset($_POST['deleteCongregationButton'])){
    //did the user submit the delete congregation button
    //if so then delete the user from the database
    $congregation_ID = $_POST['congregationList'];
    $result = deleteCongregation($congregation_ID);
    if ($result) {
      $_SESSION['deleteCongregationResult'] = "True";
    } else {
      $_SESSION['deleteCongregationResult'] = "False";
    }
  }


    ?>

  <body>
    <?php include 'assets/includes/nav.php'; ?>

    
<div class="container-fluid admin-container">
    <div class="row justify-content-md-center">
      <div class="col-md-8">
        <h1>Edit Congregations</h1>
        <form id="admin" action="manage-congregation.php" name="editCongregation" method="post">
          <div class="form-group col-md-4">
            <label for="username-select">Congregation Name</label>
            <select class="form-control" name= "congregationList" id="username-select">
              <!-- options generated here for each user -->
              <?php echo getCongregationOption(); ?>
            </select>
            <div class="btn-group" role="group">
            <button type="submit" name="editCongregationButton" class="submit" value="edit" id="admin-edit-submit">Edit Congregation</button>
            <?php
              // if the congregation was edited show success
              if(isset($_SESSION['editCongregationResult'])) {
                if($_SESSION['editCongregationResult'] == "True") {
                  echo "<div class='alert alert-success' role='alert'>
                        The congregation has been edited.
                        </div>";
                  unset($_SESSION['editCongregationResult']);
                } else if ($_SESSION['editCongregationResult'] == "False") {
                  echo "<label class='error' style='margin-top: .5rem;'>There was an error editing the congregation.</label>";
                  unset($_SESSION['editCongregationResult']);
                }
              }
            ?>
            <button type="submit" onclick="return confirm('Are you sure you want to delete this congregation?');" name="deleteCongregationButton" class="submit" value="delete" id="admin-edit-submit">Delete Congregation</button>
            <?php
              // if the congregation was deleted show success
              if(isset($_SESSION['deleteCongregationResult'])) {
                if($_SESSION['deleteCongregationResult'] == "True") {
                  echo "<div class='alert alert-success' role='alert'>
                        The congregation has been deleted.
                        </div>";
                  unset($_SESSION['deleteCongregationResult']);
                } else if ($_SESSION['deleteCongregationResult'] == "False") {
                  echo "<label class='error' style='margin-top: .5rem;'>There was an error deleting the congregation.</label>";
                  unset($_SESSION['deleteCongregationResult']);
                }
              }
            ?>
            <button type="submit" name="addCongregationButton" class="submit" value="add" id="admin-edit-submit">Add A New Congregation</button>
            <?php
              // if the congregation was added correctly, show response
              if(isset($_SESSION['addCongregationResult'])) {
                if($_SESSION['addCongregationResult'] == "True") {
                  echo "<div class='alert alert-success' role='alert'>
                        The congregation has been added.
                        </div>";
                  unset($_SESSION['addCongregationResult']);
                } else if ($_SESSION['addCongregationResult'] == "False") {
                  echo "<label class='error' style='margin-top: .5rem;'>There was an error adding the congregation.</label>";
                  unset($_SESSION['addCongregationResult']);
                }
              }
            ?>
            </div>
          </div>
        </form>
<?php
  
  if(isset($_POST['editCongregationButton'])){
      //did the user select that they want to edit a congregation
      //if so then show the edit form populated
      $congregation_ID = $_POST['congregationList'];
     echo createEditCongregationForm($congregation_ID);
  }//end of if
  
?>
      </div>
    </div>
    <div class="container-fluid admin-container">
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <?php
            if(isset($_POST['addCongregationButton'])){
                //did the user select that they want to add a congregation
                //if so then show the add form populated
               echo createAddCongregationForm();
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
  <script src="assets/js/vendor/jquery-ui.min.js" type="text/javascript"></script>
  <script src="assets/js/vendor/jquery-ui.multidatespicker.js" text="text/javascript"></script>
  <script src="assets/js/vendor/popper.js" type="text/javascript"></script>
  <script src="assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/js/scripts.min.js" type="text/javascript"></script>

</html>