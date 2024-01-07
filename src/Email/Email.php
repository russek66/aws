<?php

namespace App\Email;

use App\DataTransfer\RegisterDTO;
use App\Enum\RegisterAttemptStatus;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public function __construct(
        private readonly RegisterDTO $RDTO,
        private bool $result = true,
        private mixed $resultMessage = RegisterAttemptStatus::SUCCESS,
        private PHPMailer $mail
    )
    {
        $this->mail = new PHPMailer();

    }
    
    public function sendActivationEmail(string $email, string $activationHash)
    {
        try {
            $this->mail->setFrom('from@example.com', 'First Last');
            $this->mail->addReplyTo('replyto@example.com', 'First Last');
            $this->mail->addAddress('whoto@example.com', 'John Doe');
            $this->mail->Subject = 'PHPMailer mail() test';
            $this->mail->msgHTML(file_get_contents('contents.html'), __DIR__);
            $this->mail->AltBody = 'This is a plain-text message body';
            $this->mail->addAttachment('images/phpmailer_mini.png');

            if (!$this->mail->send()) {
                echo 'Mailer Error: ' . $this->mail->ErrorInfo;
            } else {
                echo 'Message sent!';
            }
        } catch (Exception $e) {
            echo $e->errorMessage();
        }

    }

}