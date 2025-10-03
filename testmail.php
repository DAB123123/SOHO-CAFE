<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/phpmailer/src/Exception.php';
require 'assets/phpmailer/src/PHPMailer.php';
require 'assets/phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'yourgmail@gmail.com'; // your Gmail
    $mail->Password   = 'your-app-password';   // your 16-char app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('yourgmail@gmail.com', 'Soho Café');
    $mail->addAddress('receiver@gmail.com', 'Receiver Name'); // test recipient

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from Localhost';
    $mail->Body    = '<h1>PHPMailer Works!</h1><p>This is a test email from localhost.</p>';

    $mail->send();
    echo 'Message has been sent ✅';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
