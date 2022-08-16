<?php

if (isset($_POST["submit"])) {
    
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["password"];
    $passwordrepeat = $_POST["passwordrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputResetpassword($password, $passwordrepeat) == true) {
        header("location: ../create-new-password.php?error=emptyInput&selector=" . $selector . "&validator=" . $validator);
        exit();
    }

    if(passwordStrength($password) == true) {
        header("location: ../create-new-password.php?error=passwordStrength&selector=" . $selector . "&validator=" . $validator);
        exit();
    }

    if(passwordMatch($password, $passwordrepeat) == true) {
        header("location: ../create-new-password.php?error=passwordMatch&selector=" . $selector . "&validator=" . $validator);
        exit();
    }

    $currentDate = date("U");

    $sql = "SELECT * FROM password_reset WHERE password_reset_selector = ? AND password_reset_expires >= " . $currentDate . ";";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../create-new-password.php?error=stmtFailed&selector=" . $selector . "&validator=" . $validator);
        exit();
    }

    else {
        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (!$row = mysqli_fetch_assoc($result)) {
            echo "You need to re-submit your reset request.\r\n";
            echo "<a href='../reset-password.php'>Reset your password</a>";
            exit();
        }

        else {
            $bintoken = hex2bin($validator);
            $checktoken = password_verify($bintoken, $row["password_reset_token"]);

            if ($checktoken === false) {
                echo "You need to re-submit your reset request.\r\n";
                echo "<a href='../reset-password.php'>Reset your password</a>";
                exit();
            }

            else if ($checktoken === true) {
                 
                $emailtoken = $row["password_reset_email"];

                $sql = "SELECT * FROM enduser WHERE enduser_email = ?;";
                $stmt = mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("location: ../create-new-password.php?error=stmtFailed&selector=" . $selector . "&validator=" . $validator);
                    exit();
                }

                else {
                    mysqli_stmt_bind_param($stmt, "s", $emailtoken);
                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);

                    if (!$row = mysqli_fetch_assoc($result)) {
                        echo "E-Mail Account does not exists!\r\n";
                        echo "You need to re-submit your reset request.\r\n";
                        echo "<a href='../reset-password.php'>Reset your password</a>";
                        exit();
                    }

                    else {
                        $sql = "UPDATE enduser SET enduser_password = ? WHERE enduser_email = ?;";
                        $stmt = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($stmt, $sql)) {                            
                            header("location: ../create-new-password.php?error=stmtFailed&selector=" . $selector . "&validator=" . $validator);
                            exit();
                        }

                        else {
                            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $hashedpassword, $emailtoken);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM password_reset WHERE password_reset_email = ?;";
                            $stmt = mysqli_stmt_init($conn);

                            if (!mysqli_stmt_prepare($stmt, $sql)) {                                
                                header("location: ../create-new-password.php?error=stmtFailed&selector=" . $selector . "&validator=" . $validator);
                                exit();
                            }

                            else {
                                mysqli_stmt_bind_param($stmt, "s", $email);
                                mysqli_stmt_execute($stmt);
                                header("Location: ../index.php?message=passwordupdated");
                            }
                        }
                    }
                }

            }
        }
    }

    // Instantiate Login Class and Login User
    // loginUser($conn, $username, $password);
    header("location: ../index.php?message=passwordchanged");
    exit();
}

else {
    header("location: ../index.php");
    exit();
}