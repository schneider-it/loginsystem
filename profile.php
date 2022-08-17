<?php
    include_once 'header.php';
?>
        <section class="profile">
            <div style="display:flex;justify-content:space-between;margin-top: 7vh;">
                <div style="display:flex;align-items:center;">
                    <div style="display:flex;align-items:center;">
                        <img src="
                            <?php 
                                if($_SESSION["enduser_profilepicturepath"] == NULL) {
                                    echo "img/profilepicture.jpg";
                                }
                                else {
                                    echo "img/profilepictures/" . $_SESSION["enduser_profilepicturepath"];
                                }
                            ?>
                        " alt="Test" style="border-radius:50%;height:2.5vw;width:2.5vw;object-fit:cover;outline: 3px #ffd700 solid;">
                        <div style="margin-left: 1vw; font-size: 20px; text-shadow: -1px 1px 1px #ffd700, 1px 1px 1px #ffd700, 1px -1px 1px #ffd700, -1px -1px 1px #ffd700;">
                            <div>
                                <?php
                                    echo $_SESSION["enduser_username"];
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;">
                    <a href="settings.php" class="button">Settings</a>
                </div>
            </div>
        </section>
<?php
    include_once 'header.php';
?>