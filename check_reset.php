<?php
require_once "config.php";
require 'phpmailer/PHPMailerAutoload.php';

if (isset($_POST['inemail'])) {
    $inemail = mysqli_real_escape_string($conn, $_POST['inemail']);

    // Check if email exists
    $query = "SELECT * FROM user WHERE email='$inemail' LIMIT 1";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $num_row = mysqli_num_rows($result);

    if ($num_row == 1) {
        $row = mysqli_fetch_assoc($result);

        // Generate reset token & expiry
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save to database
        $update = "UPDATE user SET reset_token='$token', reset_token_expire='$expiry' WHERE email='$inemail'";
        mysqli_query($conn, $update) or die(mysqli_error($conn));

        // Configure PHPMailer
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'daryll.bobis.daryll@gmail.com';  // ✅ replace
        $mail->Password = 'tfog bkec esvx xrln';     // ✅ replace (use Gmail App Password, not real pass)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('daryll.bobis.daryll@gmail.com', 'SOHO CAFE & KITCHEN');
        $mail->addAddress($inemail, $row['name']);
        $mail->isHTML(true);

        $resetLink = "http://localhost/SOHO-CAFE/reset_password.php?token=$token&email=$inemail";

        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Hello " . $row['name'] . ",<br><br>
                          We received a request to reset your password.<br>
                          Click the link below to reset your password:<br><br>
                          <a href='$resetLink'>$resetLink</a><br><br>
                          This link will expire in 1 hour.<br><br>
                          If you did not request a password reset, ignore this email.";

        if ($mail->send()) {
            echo 'true';
        } else {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'false';
    }
}
?>
