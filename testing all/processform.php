<?php
session_start();
require_once '../backend/db/connect.php';
require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

function validateBookingForm($data) {
    $errors = [];
    if (empty($data['fullName']) || !preg_match("/^[a-zA-Z\s]+$/", $data['fullName'])) {
        $errors[] = 'Invalid name. Only letters and spaces are allowed.';
    }
    if (empty($data['phoneNumber']) || !preg_match("/^\d{10}$/", $data['phoneNumber'])) {
        $errors[] = 'Invalid phone number. It should be 10 digits.';
    }
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }
    if (empty($data['address'])) {
        $errors[] = 'Address is required.';
    }
    return $errors;
}

function validateContactForm($data) {
    $errors = [];
    if (empty($data['contactName']) || !preg_match("/^[a-zA-Z\s]+$/", $data['contactName'])) {
        $errors[] = 'Invalid name. Only letters and spaces are allowed.';
    }
    if (empty($data['contactSubject']) || !preg_match("/^[a-zA-Z\s]+$/", $data['contactSubject'])) {
        $errors[] = 'Invalid subject. Only letters and spaces are allowed.';
    }
    if (empty($data['contactEmail']) || !filter_var($data['contactEmail'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }
    if (empty($data['contactMessage'])) {
        $errors[] = 'Message is required.';
    }
    return $errors;
}

function storeBookingData($fullName, $phoneNumber, $email, $address) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO bookings (full_name, phone_number, email, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $phoneNumber, $email, $address);
    return $stmt->execute();
}

function storeContactData($contactName, $contactSubject, $contactEmail, $contactMessage) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO contacts (contact_name, contact_subject, contact_email, contact_message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $contactName, $contactSubject, $contactEmail, $contactMessage);
    return $stmt->execute();
}

function queueEmail($to, $subject, $body) {
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();
    $channel->queue_declare('emails', false, false, false, false);
    
    $data = json_encode(['to' => $to, 'subject' => $subject, 'body' => $body]);
    $msg = new AMQPMessage($data);
    
    $channel->basic_publish($msg, '', 'emails');
    
    $channel->close();
    $connection->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['bookform'])) {
        $formData = [
            'fullName' => trim($_POST['fullName']),
            'phoneNumber' => trim($_POST['phoneNumber']),
            'email' => trim($_POST['email']),
            'address' => trim($_POST['address'])
        ];

        $errors = validateBookingForm($formData);

        if (empty($errors)) {
            if (storeBookingData($formData['fullName'], $formData['phoneNumber'], $formData['email'], $formData['address'])) {
                $adminEmail = 'admin@example.com';

                $adminSubject = "New Booking Form Submission";
                $adminBody = "A new booking form has been submitted. Details: Full Name: {$formData['fullName']}, Phone Number: {$formData['phoneNumber']}, Email: {$formData['email']}, Address: {$formData['address']}";
                
                queueEmail($adminEmail, $adminSubject, $adminBody);

                $_SESSION['form_submission'] = [
                    'status' => 'success',
                    'title' => 'Success!',
                    'message' => 'Your booking form has been submitted successfully.'
                ];
            } else {
                $_SESSION['form_submission'] = [
                    'status' => 'error',
                    'title' => 'Error!',
                    'message' => 'Failed to submit your booking form. Please try again.'
                ];
            }
        } else {
            $_SESSION['form_submission'] = [
                'status' => 'error',
                'title' => 'Validation Errors!',
                'message' => implode(', ', $errors)
            ];
        }
    } elseif (isset($_POST['contactform'])) {
        $formData = [
            'contactName' => trim($_POST['contactName']),
            'contactSubject' => trim($_POST['contactSubject']),
            'contactEmail' => trim($_POST['contactEmail']),
            'contactMessage' => trim($_POST['contactMessage'])
        ];

        $errors = validateContactForm($formData);

        if (empty($errors)) {
            if (storeContactData($formData['contactName'], $formData['contactSubject'], $formData['contactEmail'], $formData['contactMessage'])) {
                $adminEmail = 'admin@example.com';
                $userEmail = $formData['contactEmail'];

                $adminSubject = "New Contact Form Submission";
                $adminBody = "A new contact form has been submitted. Details: Full Name: {$formData['contactName']}, Subject: {$formData['contactSubject']}, Email: {$formData['contactEmail']}, Message: {$formData['contactMessage']}";
                
                $userSubject = "Thank you for contacting us";
                $userBody = "Dear {$formData['contactName']},\n\nThank you for reaching out. We have received your message and will get back to you shortly.\n\nBest regards,\nYour Company";

                queueEmail($adminEmail, $adminSubject, $adminBody);
                queueEmail($userEmail, $userSubject, $userBody);

                $_SESSION['form_submission'] = [
                    'status' => 'success',
                    'title' => 'Success!',
                    'message' => 'Your contact form has been submitted successfully.'
                ];
            } else {
                $_SESSION['form_submission'] = [
                    'status' => 'error',
                    'title' => 'Error!',
                    'message' => 'Failed to submit your contact form. Please try again.'
                ];
            }
        } else {
            $_SESSION['form_submission'] = [
                'status' => 'error',
                'title' => 'Validation Errors!',
                'message' => implode(', ', $errors)
            ];
        }
    }
}

header('Location: index.php');
exit;
?>
