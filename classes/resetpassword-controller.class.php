<?php

class ResetpasswordController extends Resetpassword {

    private $selector;
    private $validator;
    private $password;
    private $passwordrepeat;

    public function __construct($selector, $validator, $password, $passwordrepeat) {
        $this->selector = $selector;
        $this->validator = $validator;
        $this->password = $password;
        $this->passwordrepeat = $passwordrepeat;
    }

    // Methods
    
    
    public function changePassword() {
        if($this->emptyInput() == true) {
            // echo "Empty input!";
            header("location: ../create-new-password.php?error=emptyInput&selector=" . $this->selector . "&validator=" . $this->validator);
            exit();
        }

        if($this->passwordStrength() == true) {
            // echo "Passwords don't match!";
            header("location: ../create-new-password.php?error=passwordStrength&selector=" . $this->selector . "&validator=" . $this->validator);
            exit();
        }

        if($this->passwordMatch() == true) {
            // echo "Passwords don't match!";
            header("location: ../create-new-password.php?error=passwordMatch&selector=" . $this->selector . "&validator=" . $this->validator);
            exit();
        }

        $currentDate = date("U");

        require 'dbh.inc.php';

        $sql = "SELECT * FROM password_reset WHERE password_reset_selector = ? AND password_reset_expires >= " . $currentDate . ";";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error.";
            exit();
        }

        else {
            mysqli_stmt_bind_param($stmt, "s", $this->selector);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (!$row = mysqli_fetch_assoc($result)) {
                echo "You need to re-submit your reset request.\r\n";
                echo "<a href='../reset-password.php'>Reset your password</a>";
                exit();
            }

            else {
                $bintoken = hex2bin($this->validator);
                $checktoken = password_verify($bintoken, $row["password_reset_token"]);

                if ($checktoken === false) {
                    echo "You need to re-submit your reset request.\r\n";
                    echo "<a href='../reset-password.php'>Reset your password</a>";
                    exit();
                }

                else if ($checktoken === true) {
                     
                    $emailtoken = $row["password_reset_email"];
                    $this->setPassword($emailtoken, $this->password);

                }
            }
        }


    }

    private function emptyInput() {
        $result;
    
        if (empty($this->password) || empty($this->passwordrepeat)) {
            $result = true;
        }
    
        else {
            $result = false;
        }
    
        return $result;
    }
    
    private function passwordStrength() {
        $result;

        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $this->password);
        $lowercase = preg_match('@[a-z]@', $this->password);
        $number    = preg_match('@[0-9]@', $this->password);
        $specialChars = preg_match('@[^\w]@', $this->password);

        $strength = 0;

        if($uppercase) $strength = $strength + 1;
        if($lowercase) $strength = $strength + 1;
        if($number) $strength = $strength + 1;
        if($specialChars) $strength = $strength + 1;

        if($strength < 3 || strlen($this->password) < 8) {
            $result = true;
        }

        else $result = false;
    
        return $result;
    }
    
    private function passwordMatch() {
        $result;
    
        if ($this->password !== $this->passwordrepeat) {
            $result = true;
        }
    
        else {
            $result = false;
        }
    
        return $result;
    }

}