<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    $errors = [];

    if (empty($name) || !preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "Invalid name.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email.";
    }

    if (empty($subject)) {
        $errors[] = "Subject cannot be empty.";
    }

    if (empty($message) || strlen($message) < 10) {
        $errors[] = "Message should be at least 10 characters long.";
    }

    if (empty($errors)) {
        require 'db/connect.php';
        $stmt = $conn->prepare("INSERT INTO contact_pds (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $adminEmail = "misterkingofficial352@gmail.com";
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kharelkanxo283@gmail.com';
                $mail->Password = 'jvup fybw dtus qgjn';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('kharelkanxo283@gmail.com', 'Contact Form');
                $mail->addAddress($adminEmail);

                $mail->isHTML(true);
                $mail->Subject = 'New Contact Form Submission';
                $mail->Body = "You have received a new message from $name ($email).<br><br>Subject: $subject<br>Message: $message";

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kharelkanxo283@gmail.com';
                $mail->Password = 'jvup fybw dtus qgjn';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('kharelkanxo283@gmail.com', 'Contact Form');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Thank you for contacting us';
                $mail->Body = "Dear $name,<br><br>Thank you for reaching out to us. We have received your message and will get back to you soon.<br><br>Subject: $subject<br>Message: $message";

                $mail->send();
            } catch (Exception $e) {
                echo "Confirmation email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            echo "Your message has been sent successfully!";
        } else {
            echo "There was an error submitting your message.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo implode("<br>", $errors);
    }
} else {
    echo "Invalid request method.";
}
?>
