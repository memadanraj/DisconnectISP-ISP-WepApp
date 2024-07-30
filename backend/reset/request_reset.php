<?php
session_start();
require_once '../db/connect.php';
require '../../vendor/autoload.php'; // Make sure PHPMailer is installed

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = 'Invalid email format.';
    } else {
        $otp = rand(100000, 999999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime('+5 minutes'));

        // Check if email exists in the database
        $stmt = $conn->prepare("SELECT id FROM users_pds WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        if ($user_id) {
            // Insert OTP and expiry time into database
            $stmt = $conn->prepare("INSERT INTO password_resets_pds (user_id, otp, expires_at) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $otp, $otp_expiry);
            $stmt->execute();
            $stmt->close();

            // Send OTP to email
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kharelkanxo283@gmail.com';
                $mail->Password = 'jvup fybw dtus qgjn';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('kharelkanxo283@gmail.com', 'PDS Support');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset OTP';
                $mail->Body = "Your OTP for password reset is: <b>$otp</b>";

                $mail->send();
                $_SESSION['msg'] = 'OTP sent to your email.';
                header('Location: verify_otp.php');
                exit();
            } catch (Exception $e) {
                $_SESSION['msg'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['msg'] = 'Email not found.';
        }
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot Password | PDS Server Network</title>
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/auth.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img class="brand" src="../assets/img/PDS LOGO Green.png" alt="bootstraper logo" style="width: 320px;">
                    </div>
                    <h6 class="mb-4 text-muted">Reset your password</h6>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['msg'] . '</div>';
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form action="" method="POST">
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-2 mb-4" style="background-color: #45A555;">Send OTP</button>
                    </form>
                    <p class="mb-2 text-muted">Remembered your password? <a href="../login.php" style="color: #45A555;">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
