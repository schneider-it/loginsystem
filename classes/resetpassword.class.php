<?php

class Resetpassword extends Dbh {

    protected function setPassword($email, $password) {

        require 'dbh.inc.php';

        $sql = "SELECT * FROM enduser WHERE enduser_email = ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error.";
            // $stmt = null;
            // header("location: ../create-new-password.php?error=stmtFailed&selector=" . $selector . "&validator=" . $validator);
            exit();
        }

        else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (!$row = mysqli_fetch_assoc($result)) {
                echo "There was an error.";
                exit();
            }

            else {
                $sql = "UPDATE enduser SET enduser_password = ? WHERE enduser_email = ?;";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "There was an error.";
                    exit();
                }

                else {
                    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ss", $hashedpassword, $email);
                    mysqli_stmt_execute($stmt);

                    $sql = "DELETE FROM password_reset WHERE password_reset_email = ?;";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "There was an error.";
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