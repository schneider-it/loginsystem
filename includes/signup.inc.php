<?php

if (isset($_POST["submit"])) {
    
    // Grabbing the data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordrepeat = $_POST["passwordrepeat"];
    $fullname = $_POST["fullname"];

    // require_once 'dbh.inc.php';
    // require_once 'functions.inc.php';

    // Instantiate SignupController Class
    include '../classes/dbh.class.php';
    include '../classes/signup.class.php';
    include '../classes/signup-controller.class.php';

    $signup = new SignupController($username, $email, $password, $passwordrepeat, $fullname);

    // create User
    $signup->signupUser();

    // Instantiate Login Class and Login User
    // loginUser($conn, $username, $password);
    header("location: ../index.php");
    exit();
}

else {
    header("location: ../signup.php");
    exit();
}