<?php

namespace App\Email;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public function __construct()
    {
        $mail = new PHPMailer(true);
        try {
            $mail->setFrom('from@example.com', 'First Last');
            $mail->addReplyTo('replyto@example.com', 'First Last');
            $mail->addAddress('whoto@example.com', 'John Doe');
            $mail->Subject = 'PHPMailer mail() test';
            $mail->msgHTML(file_get_contents('contents.html'), __DIR__);
            $mail->AltBody = 'This is a plain-text message body';
            $mail->addAttachment('images/phpmailer_mini.png');

            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }
        } catch (Exception $e) {
            echo $e->errorMessage();
        }
    }
}