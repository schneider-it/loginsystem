<?php

if (isset($_POST["submit"])) {
    
    // Grabbing the data
    $usernameoremail = $_POST["username"];
    $password = $_POST["password"];

    // require_once 'dbh.inc.php';
    // require_once 'functions.inc.php';

    // Instantiate SignupController Class
    include '../classes/dbh.class.php';
    include '../classes/login.class.php';
    include '../classes/login-controller.class.php';

    $login = new LoginController($usernameoremail, $password);

    // create User
    $login->loginUser();

    // Instantiate Login Class and Login User
    // loginUser($conn, $username, $password);
    header("location: ../index.php");
    exit();
}

else {
    header("location: ../index.php");
    exit();
}