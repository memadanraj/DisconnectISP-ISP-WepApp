<?php
session_start();
require 'db/connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize input data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT id FROM users_pds WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "This email is already registered.";
    } else {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users_pds (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);
        
        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: login.html");
            exit;
        } else {
            $error = "Error: " . $stmt->error;
        }
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
    <title>Register | PDS Server Network</title>
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
                    <h6 class="mb-4 text-muted">Create a new account</h6>
                    <form action="" method="POST">
                        <div class="mb-3 text-start">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-2 mb-4" style="background-color: #45A555;">Register</button>
                    </form>
                    <p class="mb-2 text-muted">Already have an account? <a href="login.html" style="color: #45A555;">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
