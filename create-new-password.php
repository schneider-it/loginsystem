<?php
    include_once 'header.php';
?>

        <section class="login-form">
        <?php
            if (!(isset($_GET["selector"]) && isset($_GET["validator"]))) {
                header("Location: index.php");
                exit();
            }

            $selector = $_GET["selector"];
            $validator = $_GET["validator"];

            if(empty($selector) || empty($validator)) {
                echo "Could not validate your request!";
            }

            else {
                if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                    ?>

            <h2>Create new password</h2>
            <div class="login-form-form">
                <form method="post" action="includes/reset-password.inc.php" autocomplete="off">
                    <input type="hidden" name="selector" value="<?php echo $selector; ?>"/>
                    <input type="hidden" name="validator" value="<?php echo $validator; ?>"/>
                    <div class="form">
                        <input type="password" name="password" required autocomplete="off" />
                        <label for="password" class="label label-password">
                            <span class="content content-password">new password</span>
                        </label>
                    </div>
                    <div class="form">
                        <input type="password" name="passwordrepeat" required autocomplete="off" />
                        <label for="passwordrepeat" class="label label-passwordrepeat">
                            <span class="content content-passwordrepeat">repeat new password</span>
                        </label>
                    </div>
                    <button class="submit" type="submit" name="submit">Reset password</button>
                </form>
            </div>

                    <?php
                }

                else {
                    header("Location: index.php");
                    exit();
                }
            }
        ?>            
        </section>
<?php
    include_once 'header.php';
?>