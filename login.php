<?php
    include_once 'header.php';
?>
        <section class="login-form">
            <h2>Log In</h2>
            <div class="login-form-form">
                <form method="post" action="includes/login.inc.php" autocomplete="off">
                    <div class="form">
                        <input type="text" name="username" required autocomplete="off" />
                        <label for="username" class="label label-username">
                            <span class="content content-username">username / email</span>
                        </label>
                    </div>
                    <div class="form">
                        <input type="password" name="password" required autocomplete="off" />
                        <label for="password" class="label label-password">
                            <span class="content content-password">password</span>
                        </label>
                    </div>
                    <div style="text-align: right; margin-bottom: 1vh;"><a href="reset-password.php">Forgot your password?</a></div>
                    <button class="submit" type="submit" name="submit">Log In</button>
                </form>
            </div>
            

            <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p>Fill in all fields!</p>";
                    }

                    else if ($_GET["error"] == "wronglogin") {
                        echo "<p>Incorrect login information!</p>";
                    }

                    else if ($_GET["error"] == "wrongpassword") {
                        echo "<p>Incorrect password!</p>";
                    }
                }
            ?>
        </section>
        <div class="other-form">
            No account? <a href="signup.php">Create one</a>
        </div>
<?php
    include_once 'header.php';
?>