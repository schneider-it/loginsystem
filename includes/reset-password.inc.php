<?php

if (isset($_POST["submit"])) {
    
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $passwordrepeat = $_POST["passwordrepeat"];

    // Instantiate SignupController Class
    include '../classes/dbh.class.php';
    include '../classes/resetpassword.class.php';
    include '../classes/resetpassword-controller.class.php';

    $resetpassword = new ResetpasswordController($selector, $validator, $password, $passwordrepeat);

    // create User
    $resetpassword->changePassword();

    // Instantiate Login Class and Login User
    // loginUser($conn, $username, $password);
    header("location: ../index.php?message=passwordchanged");
    exit();


}

else {
    header("location: ../index.php");
    exit();
}