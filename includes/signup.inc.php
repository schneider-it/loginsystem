<?php

if (isset($_POST["submit"])) {
    
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordrepeat = $_POST["passwordrepeat"];
    $fullname = $_POST["fullname"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($username, $email, $password, $passwordrepeat, $fullname) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    
    if (invalidUsername($username) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    
    if (invalidEmail($email) !== false) {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    
    if (passwordStrength($password) !== false) {
        header("location: ../signup.php?error=passwordstrength");
        exit();
    }
    
    if (passwordMatch($password, $passwordrepeat) !== false) {
        header("location: ../signup.php?error=passwordmatch");
        exit();
    }
    
    if (usernameExists($conn, $username) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }
    
    if (emailExists($conn, $email) !== false) {
        header("location: ../signup.php?error=emailtaken");
        exit();
    }

    createUser($conn, $username, $email, $password, $fullname);
    loginUser($conn, $email, $password);

}

else {
    header("location: ../signup.php");
    exit();
}