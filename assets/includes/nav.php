<?php
    // if there is no session, resume one
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="/login.php">
    <img src="assets/img/raihn-logo.png" width="187" height="60" class="d-inline-block" alt="RAIHN Logo">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php
        // if the user is on certain pages, display different nav items
        if (strpos($_SERVER['REQUEST_URI'], "admin.php")
        || strpos($_SERVER['REQUEST_URI'], "bus-drivers.php")
        || strpos($_SERVER['REQUEST_URI'], "congregation-schedule.php") 
        || strpos($_SERVER['REQUEST_URI'], "congregations.php")
        || strpos($_SERVER['REQUEST_URI'], "manage-congregation.php")
        || strpos($_SERVER['REQUEST_URI'], "bus-schedule")
        || strpos($_SERVER['REQUEST_URI'], "blackouts.php") !== false) {
          echo "<li class='nav-item'>
                  <a class='nav-link' href='login_landing.php'>Home</a>
                </li>";
        }

        // if the user is logged in and on the index, display the home button on the nav
        if (isset($_SESSION['userLogin']) && (strpos($_SERVER['REQUEST_URI'], "index.php")!== false)) {
          echo "<li class='nav-item'>
                  <a class='nav-link' href='login_landing.php'>Home</a>
                </li>";
        }

        // if the user is an admin, display certain pages
        if (strpos($_SERVER['REQUEST_URI'], "bus-avail.php")) {
          if (isset($_SESSION["user_email"])) {
            $email = $_SESSION["user_email"];
            $DBcore = new DBcore();
            $userType = $DBcore->selectUserType($email);
              if(strcasecmp($userType,"e") == 0) {
                // show the home link for the admin
                echo "<li class='nav-item'>
                      <a class='nav-link' href='login_landing.php'>Home</a>
                      </li>";
              } 
          }
        }

      ?>
      <li class="nav-item">
      <?php  
      // if the user is logged in, add the logout option else just the login
      if (isset($_SESSION['userLogin'])) {
        echo '<a class="nav-link" href="logout.php">Logout</a>';
      } else {
        echo '<a class="nav-link" href="login.php">Login</a>';
      }
      ?>
      </li>
    </ul>
  </div>
</nav>