<?php

class SignupController extends Signup {

    private $username;
    private $email;
    private $password;
    private $passwordrepeat;
    private $fullname;

    public function __construct($username, $email, $password, $passwordrepeat, $fullname) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->passwordrepeat = $passwordrepeat;
        $this->fullname = $fullname;
    }

    // Methods
    
    
    public function signupUser() {
        if($this->emptyInput() == true) {
            // echo "Empty input!";
            header("location: ../signup.php?error=emptyInput");
            exit();
        }

        if($this->invalidUsername() == true) {
            // echo "Invalid Username!";
            header("location: ../signup.php?error=invalidUsername");
            exit();
        }

        if($this->invalidEmail() == true) {
            // echo "Invalid Email"!";
            header("location: ../signup.php?error=invalidEmail");
            exit();
        }

        if($this->passwordStrength() == true) {
            // echo "Passwords don't match!";
            header("location: ../signup.php?error=passwordStrength");
            exit();
        }

        if($this->passwordMatch() == true) {
            // echo "Passwords don't match!";
            header("location: ../signup.php?error=passwordMatch");
            exit();
        }

        if($this->usernameExists() == true) {
            // echo "Username already exists!";
            header("location: ../signup.php?error=usernameExists");
            exit();
        }

        if($this->emailExists() == true) {
            // echo "Email already exists!";
            header("location: ../signup.php?error=emailExists");
            exit();
        }

        $this->createUser($this->username, $this->email, $this->password, $this->fullname, null);
    }

    private function emptyInput() {
        $result;
    
        if (empty($this->email) || empty($this->username) || empty($this->password) || empty($this->passwordrepeat)) {
            $result = true;
        }
    
        else {
            $result = false;
        }
    
        return $result;
    }

    private function invalidUsername() {
        $result;
    
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->username)) {
            $result = true;
        }
    
        else {
            $result = false;
        }
    
        return $result;
    }
    
    private function invalidEmail() {
        $result;
    
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
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
    
    private function usernameExists() {
        $result;
    
        if (!$this->checkUsername($this->username)) {
            $result = true;
        }
    
        else {
            $result = false;
        }
    
        return $result;
    }
    
    private function emailExists() {
        $result;
    
        if (!$this->checkEmail($this->email)) {
            $result = true;
        }
    
        else {
            $result = false;
        }
    
        return $result;
    }

}