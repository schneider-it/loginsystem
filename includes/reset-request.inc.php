<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if (isset($_POST["submit"])) {
    
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "localhost/loginsystem/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    require 'dbh.inc.php';

    $enduser_email = $_POST["email"];

    // Remove all old Tokens from this user
    $sql = "DELETE FROM password_reset WHERE password_reset_email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
        exit();
    }

    else {
        mysqli_stmt_bind_param($stmt, "s", $enduser_email);
        mysqli_stmt_execute($stmt);
    }

    // Insert new Token
    $sql = "INSERT INTO password_reset (password_reset_email, password_reset_selector, password_reset_token, password_reset_expires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {        
        header("location: ../reset-password.php?error=stmtFailed");
        exit();
    }

    else {
        $hashedtoken = password_hash($token, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ssss", $enduser_email, $selector, $hashedtoken, $expires);
        mysqli_stmt_execute($stmt);
    }

    // close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // send email
    $to = $enduser_email;
    $subject = "Reset your password - Schneider IT";
    $message = "<div style='display:flex;position:relative;justify-content:center;align-items:center'><div><p>We recieved a password reset request. The link to reset your password is below. <br />If you did not make this request, your account could be in <span style='color:#ed752f;'>danger</span>! To be save please follow the instructions below!</p><p>Here is your password reset link: <br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='" . $url . "' style='padding:10px;background:#2fa7ed;color:white;text-decoration:none;line-height:2;'>&nbsp;&nbsp;&nbsp;Reset your password&nbsp;&nbsp;&nbsp;</a><br /></p><p>If this button doesn't work, here is the link: <br /><a href=" . $url . ">" . $url . "</a><br /><br /></p><p><br /><span style='color:#ed752f;'>Feeling unsage?</span> <br />Go to Schneider IT and change your password as soon as possible.</p></div></div>";
    $headers = "From: Schneider IT <no-reply@schneider-it.at>\r\n";
    $headers = "Reply-To: help@schneider-it.at\r\n";
    $headers .= "Content-type: text/html\r\n";


    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls'; //tls
    $mail->Host = 'bsmtp.a1.net';
    $mail->Port = '587';
    $mail->isHTML();
    $mail->Username = 'administrator@schneider-it.at';
    $mail->Password = '#Iboyiw90';
    $mail->SetFrom('no-reply@schneider-it.at');
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AddAddress($to);

    $mail->Send();


    header("Location: ../login.php?reset=success");

}

else {
    header("location: ../reset-password.php");
    exit();
}