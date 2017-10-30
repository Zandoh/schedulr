<html>

    <?php
    //begin session
    session_start(); 
    session_name("LoginSession"); 
    //Check if the form has been submitted and the SESSION is already set
    if (isset($_SESSION['userLogin'])) {
        // logged in
    }
    else{
        //not logged in
        header("Location:index.php");
    }

    include 'handlers/login_handler.php';
    include 'assets/includes/header.php';
    include 'assets/includes/nav.php';


    ?>


    <body>




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