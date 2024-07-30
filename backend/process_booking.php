<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $phone_number = trim($_POST['phone_number']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $errors = [];

    if (empty($full_name) || !preg_match("/^[a-zA-Z ]+$/", $full_name)) {
        $errors[] = "Invalid name.";
    }

    if (empty($phone_number) || !preg_match("/^[0-9]+$/", $phone_number)) {
        $errors[] = "Invalid phone number.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email.";
    }

    if (empty($address)) {
        $errors[] = "Address cannot be empty.";
    }

    if (empty($errors)) {
        require 'db/connect.php';
        $stmt = $conn->prepare("INSERT INTO `newconn_pds`( `nc_name`, `nc_phone`, `nc_email`, `nc_address`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $phone_number, $email, $address);

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

                $mail->setFrom('kharelkanxo283@gmail.com', 'Booking Form');
                $mail->addAddress($adminEmail);

                $mail->isHTML(true);
                $mail->Subject = 'New Booking Form Submission';
                $mail->Body = "You have received a new booking from $full_name ($email).<br><br>Phone Number: $phone_number<br>Address: $address";

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            echo "Your booking has been submitted successfully!";
        } else {
            echo "There was an error submitting your booking.";
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
