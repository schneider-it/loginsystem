<?php
    include_once 'header.php';
?>
        <section class="login-form">
            <h2>Reset your password</h2>
            <p style="margin-top: 3vh">An email will be send to you with <br />instructions on how to reset your password.</p>
            <div class="login-form-form">
                <form method="post" action="includes/reset-request.inc.php" autocomplete="off">
                    <div class="form">
                        <input type="text" name="email" required autocomplete="off" />
                        <label for="email" class="label label-email">
                            <span class="content content-email">email address</span>
                        </label>
                    </div>
                    <button class="submit" type="submit" name="submit">Send email</button>
                </form>
            </div>
        </section>
        <div class="other-form">
            Return to: <a href="login.php">Log in</a>
        </div>
<?php
    include_once 'header.php';
?>