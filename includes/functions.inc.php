<?php

function emptyInputSignup($username, $email, $password, $passwordrepeat, $fullname) {
    $result;

    if (empty($username) ||empty($email) || empty($password) || empty($passwordrepeat) || empty($fullname)) {
        $result = true;
    }

    else {
        $result = false;
    }

    return $result;
}

function invalidUsername($username) {
    $result;

    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }

    else {
        $result = false;
    }

    return $result;
}

function invalidEmail($email) {
    $result;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }

    else {
        $result = false;
    }

    return $result;
}

function passwordStrength($password) {
    $result;

    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    $strength = 0;

    if($uppercase) $strength = $strength + 1;
    if($lowercase) $strength = $strength + 1;
    if($number) $strength = $strength + 1;
    if($specialChars) $strength = $strength + 1;

    if($strength < 3 || strlen($password) < 8) {
        $result = true;
    }

    else $result = false;

    return $result;
}

function passwordMatch($password, $passwordrepeat) {
    $result;

    if ($password !== $passwordrepeat) {
        $result = true;
    }

    else {
        $result = false;
    }

    return $result;
}

function usernameExists($conn, $username) {
    $sql = "SELECT * FROM enduser WHERE enduser_username = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }

    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function emailExists($conn, $email) {
    $sql = "SELECT * FROM enduser WHERE enduser_email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }

    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $username, $email, $password, $fullname) {
    $sql = "INSERT INTO enduser (enduser_username, enduser_email, enduser_password, enduser_fullname) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedpassword, $fullname);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    loginUser($conn, $username, $password);
}

function emptyInputLogin($username, $password) {
    $result;

    if (empty($username) || empty($password)) {
        $result = true;
    }

    else {
        $result = false;
    }

    return $result;
}

function loginUser($conn, $usernameoremail, $password) {
    $usernameExists = usernameExists($conn, $usernameoremail, $usernameoremail);

    if ($usernameExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $passwordHashed = $usernameExists["enduser_password"];
    $checkpassword = password_verify($password, $passwordHashed);

    if ($checkpassword === false) {
        header("location: ../login.php?error=wrongpassword");
        exit();
    }

    else if ($checkpassword === true) {
        session_start();
        $_SESSION["enduser_id"] = $usernameExists["enduser_id"];
        $_SESSION["enduser_username"] = $usernameExists["enduser_username"];
        $_SESSION["enduser_email"] = $usernameExists["enduser_email"];
        $_SESSION["enduser_fullname"] = $usernameExists["enduser_fullname"];
        $_SESSION["enduser_profilepicturepath"] = $usernameExists["enduser_profilepicturepath"];
        header("location: ../index.php");
        exit();
    }
}

function emptyInputResetpassword($password, $passwordrepeat) {
    $result;

    if (empty($password) || empty($passwordrepeat)) {
        $result = true;
    }

    else {
        $result = false;
    }

    return $result;
}