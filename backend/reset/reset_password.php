<?php
session_start();
require '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['password'];
    $user_id = $_SESSION['user_id'];

    // Retrieve old password hash from database
    $stmt = $conn->prepare("SELECT password FROM users_pds WHERE id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($old_password_hash);
    $stmt->fetch();
    $stmt->close();

    // Check if new password matches old password
    if (password_verify($new_password, $old_password_hash)) {
        $_SESSION['msg'] = 'New password cannot be the same as the old password.';
    } else {
        // Hash the new password
        $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

        // Update user's password
        $stmt = $conn->prepare("UPDATE users_pds SET password = ? WHERE id = ?");
        $stmt->bind_param("ss", $new_password_hash, $user_id);

        if ($stmt->execute()) {
            $_SESSION['msg'] = 'Password has been reset successfully.';
            // Optionally, delete the OTP record
            $stmt = $conn->prepare("DELETE FROM password_resets_pds WHERE user_id = ?");
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
        } else {
            $_SESSION['msg'] = 'Error: ' . $stmt->error;
        }

        $stmt->close();
        $conn->close();

        header('Location: ../login.php');
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset Password | PDS Server Network</title>
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
                    <form action="reset_password.php" method="POST">
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter New Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-2 mb-4" style="background-color: #45A555;">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
