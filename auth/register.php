<?php
session_start();
include '../includes/db.php'; // Correct pathway for subfolder

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (strlen($username) >= 2 && strlen($username) <= 50 && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 100 && strlen($password) >= 6 && strlen($password) <= 255) {
    
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $message = "<div class='alert alert-danger py-2 small'>Email is already registered!</div>";
        } else {
        
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success py-2 small'>Registration successful! <a href='login.php' class='alert-link'>Login now</a></div>";
            } else {
                $message = "<div class='alert alert-danger py-2 small'>Registration failed. Please try again.</div>";
            }
            $stmt->close();
        }
        $check_stmt->close();
    } else {
        $message = "<div class='alert alert-warning py-2 small'>Please fill in all fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VeganFood</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        .full-page-wrapper {
            min-height: 100vh;
            display: flex;
        }
        .register-image-side {
            /* register page image*/
            background: url('../images/login-pic.jpg') center/cover no-repeat;
            background-color: #2b2b2b;
        }
        .register-form-side {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-form-box {
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }
        .btn-submit {
            background-color: #198754;
            color: white;
            width: 100%;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn-submit:hover {
            background-color: #157347;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid full-page-wrapper p-0">
        <!-- Left Side: Image Section -->
        <div class="col-lg-7 col-md-6 d-none d-md-block register-image-side"></div>

        <!-- Right Side: Register Form Section -->
        <div class="col-lg-5 col-md-6 col-12 register-form-side">
            <div class="register-form-box">
                <h2 class="text-center mb-4 fw-bold">Register</h2>
                <?php echo $message; ?>
                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control rounded-3" placeholder="Your username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Create a password" required>
                    </div>
                    <button type="submit" class="btn-submit mt-2">REGISTER</button>
                    <p class="text-center mt-3 mb-0 small">Already have an account? <a href="login.php" class="text-decoration-none fw-bold">Login Here</a></p>
                    <p class="text-center mt-2 mb-0 small"><a href="../index.php" class="text-decoration-none text-muted">← Back to Home</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/validation.js"></script>
</body>
</html>