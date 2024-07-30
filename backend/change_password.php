<?php
session_start();
require 'db/connect.php';

if (!defined('SECRET_KEY')) {
    define('SECRET_KEY', 'mypds');
}

if (isset($_POST['change'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id =$_SESSION['user_id'];

    // Validate the input
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error_message'] = 'All fields are required.';
        header('Location: change_password.php');
        exit();
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = 'New password and confirm password do not match.';
        header('Location: change_password.php');
        exit();
    }

    // Fetch the current password from the database
    $stmt = $conn->prepare("SELECT password FROM users_pds WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (!password_verify($current_password, $hashed_password)) {
        $_SESSION['error_message'] = 'Current password is incorrect.';
        header('Location: change_password.php');
        exit();
    }

    // Hash the new password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the new password in the database
    $stmt = $conn->prepare("UPDATE users_pds SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_hashed_password, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Password changed successfully.';
        header('Location: dashboard.php');
    } else {
        $_SESSION['error_message'] = 'Failed to change password. Please try again.';
        header('Location: change_password_form.php');
    }

    $stmt->close();
    $conn->close();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Change Password | PDS Server Network</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/auth.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img class="brand" src="assets/img/PDS LOGO Green.png" alt="bootstraper logo" style="width: 320px;">
                    </div>
                    <h6 class="mb-4 text-muted">Change your password</h6>
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                        unset($_SESSION['success_message']);
                    }
                    if (isset($_SESSION['error_message'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                        unset($_SESSION['error_message']);
                    }
                    ?>
                    <form action="" method="POST">
                        <div class="mb-3 text-start">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Current Password" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                        </div>
                        <div class="mb-3 text-start">

                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4" name="change" style="background-color: #45A555;">Change Password</button>
                    </form>
                    <p class="mb-2 text-muted"><a href="dashboard.php" style="color: #45A555;">Back to Dashboard</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
