<?php

    use PHPMailer\PHPMailer\PHPMailer;
    require 'vendor/autoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'chronocoach@chronocoach.fr';
    $mail->Password = 'MJMETRIX.chronocoach2021';
    $mail->setFrom('chronocoach@chronocoach.fr', 'CHRONOCOACH');
    $mail->addAddress('lhukasboss@gmail.com');
    $mail->Subject = 'Testing PHPMailer';
    $mail->msgHTML(file_get_contents('index.html'), __DIR__);
    $mail->Body = 'This is a plain text message body';
    $mail2->AddAttachment('../CV/CV.pdf', 'CV');
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'The email message was sent.';
    }
    ?>
