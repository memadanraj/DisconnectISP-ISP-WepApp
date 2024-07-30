<?php
require_once 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com';
        $mail->Password = 'your-email-password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        // Log error or handle it
    }
}

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('emails', false, false, false, false);

$callback = function($msg) {
    $data = json_decode($msg->body, true);
    sendEmail($data['to'], $data['subject'], $data['body']);
};

$channel->basic_consume('emails', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>
