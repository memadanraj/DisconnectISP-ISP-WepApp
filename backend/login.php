
<?php

session_start();
require 'db/connect.php';

if (!defined('SECRET_KEY')) {
    define('SECRET_KEY', 'mypds');
}


// Default credentials
$default_email = 'admin@pdsserver.com';
$default_password = 'PqRestInP4rad!s3';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize input data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Check against default credentials first
    if ($email === $default_email && $password === $default_password) {
        $_SESSION['user_id'] = 1;
        $_SESSION['user_email'] = $email;
        $_SESSION['logged_in'] = true;
        // Redirect to a protected page
        header("Location: dashboard.php");
        exit;
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT id, email, password FROM users_pds WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $email, $hashed_password);
        $stmt->fetch();
        
        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Start session and store user data
            $_SESSION['user_id'] = $id;
            $_SESSION['user_email'] = $email;
            $_SESSION['logged_in'] = true;

            // Redirect to a protected page
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
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
    <title>Login | PDS Server Network</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/auth.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img class="brand" src="assets/img/PDS LOGO Green.png" alt="bootstraper logo"  style="width: 320px;">
                    </div>
                    <h6 class="mb-4 text-muted">Login to your account</h6>
                    <form action="login.php" method="POST">
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3 text-start">
                            <div class="form-check">
                              <input class="form-check-input" name="remember" type="checkbox" value="" id="check1">
                              <label class="form-check-label" for="check1">
                                Remember me on this device
                              </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-2 mb-4" style="background-color: #45A555;">Login</button>
                    </form>
                    <p class="mb-2 text-muted">Forgot password? <a href="reset/request_reset.php" style="color: #45A555;">Reset</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
