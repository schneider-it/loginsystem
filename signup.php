<?php
    include_once 'header.php';
?>
        <section class="signup-form">
            <h2>Sign Up</h2>
            <div class="signup-form-form">
                <form method="post" action="includes/signup.inc.php" autocomplete="off">
                    <div class="form">
                        <input type="text" name="username" required autocomplete="off" />
                        <label for="username" class="label label-username">
                            <span class="content content-username">username</span>
                        </label>
                    </div>
                    <div class="form">
                        <input type="text" name="email" required autocomplete="on" onkeyup="checkEmailJS(this.value)"/>
                        <label for="email" class="label label-email">
                            <span class="content content-email">email</span>
                        </label>
                    </div>
                    <?php 
                        // if(isset($_GET['email'])){
                        //     checkEmail($_GET['email']);
                        // }
                        function checkEmail($email) {
                            echo "OMG";
                            if(!isempty($email)) {

                            }
                            echo "<div style='color: red;'>email already taken</div>";
                            echo "<div style='color: red;'>email already taken</div>";

                        }
                    ?>
                    <div class="form">
                        <input type="password" name="password" required autocomplete="off" />
                        <label for="password" class="label label-password">
                            <span class="content content-password">password</span>
                        </label>
                    </div>
                    <div class="form">
                        <input type="password" name="passwordrepeat" required autocomplete="off" />
                        <label for="passwordrepeat" class="label label-passwordrepeat">
                            <span class="content content-passwordrepeat">password repeat</span>
                        </label>
                    </div>
                    <div class="form">
                        <input type="text" name="fullname" autocomplete="off" required />                   <!-- probelm mit required / valid!!! -->
                        
                        <label for="fullname" class="label label-fullname">
                            <span class="content content-fullname">full name (optional)</span>
                        </label>
                    </div>
                    <button class="submit" type="submit" name="submit">Sign Up</button>
                </form>
            </div>
            <div class="other-form">
                Already have an account? <a href="login.php">Log in</a>
            </div>
            
            <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p>Fill in all fields!</p>";
                    }

                    else if ($_GET["error"] == "invalidUsername") {
                        echo "<p>Choose a proper username!</p>";
                    }

                    else if ($_GET["error"] == "invalidemail") {
                        echo "<p>Choose a proper email!</p>";
                    }

                    else if ($_GET["error"] == "passworddontmatch") {
                        echo "<p>Passwords don't match!</p>";
                    }

                    else if ($_GET["error"] == "stmtfailed") {
                        echo "<p>Something went wrong!</p>";
                    }

                    else if ($_GET["error"] == "usernametaken") {
                        echo "<p>Username already taken!</p>";
                    }

                    else if ($_GET["error"] == "emailtaken") {
                        echo "<p>Email already taken!</p>";
                    }

                    else if ($_GET["error"] == "none") {
                        echo "<p>You have signed up!</p>";
                    }
                }
            ?>
            
        </section>


        <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous">
        </script>
        <script>
            function checkEmailJS(email) {
                console.log(email);
                jQuery.ajax({
                    type: "POST",
                    url: 'signup.php',
                    datatype: 'text'
                });
            }
        </script>

<?php
    include_once 'header.php';
?>