<?php

class Login extends Dbh {

    protected function getUser($usernameoremail, $password) {
        $stmt = $this->connect()->prepare('SELECT enduser_password FROM enduser WHERE enduser_username = ? OR enduser_email = ?;');

        if(!$stmt->execute(array($usernameoremail, $usernameoremail))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }
        
        if($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../login.php?error=usernotfound");
            exit();
        }
        
        $hashedpassword = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkpassword = password_verify($password, $hashedpassword[0]["enduser_password"]);

        if ($checkpassword == false) {
            $stmt = null;
            header("location: ../login.php?error=wrongpassword");
            exit();
        }

        else if ($checkpassword == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM enduser WHERE enduser_username = ? OR enduser_email = ? AND enduser_password = ?;');

            if(!$stmt->execute(array($usernameoremail, $usernameoremail, $password))) {
                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: ../index.php?error=usernotfound");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["enduser_id"] = $user[0]["enduser_id"];
            $_SESSION["enduser_username"] = $user[0]["enduser_username"];

            $stmt = null;
        }
        
    }

}