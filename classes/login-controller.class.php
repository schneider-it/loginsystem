<?php

class LoginController extends Login {

    private $usernameoremail;
    private $password;

    public function __construct($usernameoremail, $password) {
        $this->usernameoremail = $usernameoremail;
        $this->password = $password;
    }

    // Methods
    
    
    public function loginUser() {
        if($this->emptyInput() == true) {
            // echo "Empty input!";
            header("location: ../login.php?error=emptyInput");
            exit();
        }

        $this->getUser($this->usernameoremail, $this->password);
    }

    private function emptyInput() {
        $result;
    
        if (empty($this->usernameoremail) || empty($this->password)) {
            $result = true;
        }
    
        else {
            $result = false;
        }
    
        return $result;
    }

}