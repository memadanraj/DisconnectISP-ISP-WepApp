<?php
session_start();
require '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = $_POST['otp'];
    $current_time = date("Y-m-d H:i:s");

    // Verify OTP and check expiry
    $stmt = $conn->prepare("SELECT user_id FROM password_resets_pds WHERE otp = ? AND expires_at > ?");
    $stmt->bind_param("ss", $otp, $current_time);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
        header('Location: reset_password.php');
        exit();
    } else {
        $_SESSION['msg'] = 'Invalid or expired OTP.';
        header('Location: verify_otp.php');
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
    <title>Verify OTP | PDS Server Network</title>
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
                    <h6 class="mb-4 text-muted">Verify OTP</h6>
                    <form action="verify_otp.php" method="POST">
                        <div class="mb-3 text-start">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="text" name="otp" class="form-control" id="otp" placeholder="OTP.." required>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-2 mb-4" style="background-color: #45A555;">Verify OTP</button>
                        <br>
                             <?php
                            
                            if (isset($_SESSION['msg'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['msg'] . '</div>';
                                unset($_SESSION['msg']);
                            }
                            ?>
                    </form>
          
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>