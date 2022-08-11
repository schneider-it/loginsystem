<?php

class Signup extends Dbh {

    protected function createUser($username, $email, $password, $fullname, $profilepicturepath) {
        $stmt = $this->connect()->prepare('INSERT INTO enduser (enduser_username, enduser_email, enduser_password, enduser_fullname, enduser_profilepicturepath) VALUES (?, ?, ?, ?, ?);');

        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($username, $email, $hashedpassword, $fullname, $profilepicturepath))) {
            $stmt = null;
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        
        $stmt = null;
    }

    protected function checkUsername($username) {
        $stmt = $this->connect()->prepare('SELECT enduser_username FROM enduser WHERE enduser_username = ?;');

        if(!$stmt->execute(array($username))) {
            $stmt = null;
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }

        $result;

        if ($stmt->rowCount() > 0) {
            $result = false;
        }
        else {
            $result = true;
        }

        return $result;
    }

    protected function checkEmail($email) {
        $stmt = $this->connect()->prepare('SELECT enduser_username FROM enduser WHERE enduser_email = ?;');

        if(!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }

        $result;

        if ($stmt->rowCount() > 0) {
            $result = false;
        }
        else {
            $result = true;
        }

        return $result;
    }

}