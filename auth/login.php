<?php
session_start();
include '../includes/db.php'; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username']; 
            
            header("Location: ../index.php"); 
            exit();
        } else {
            $message = "<div class='alert alert-danger py-2 small'>Invalid password.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger py-2 small'>No account found.</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VeganFood</title>
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
        .login-image-side {
        
            background: url('../images/login-pic.jpg') center/cover no-repeat;
            background-color: #2b2b2b;
        }
        .login-form-side {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-form-box {
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }
        .btn-submit {
            background-color: #0d6efd;
            color: white;
            width: 100%;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn-submit:hover {
            background-color: #0b5ed7;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid full-page-wrapper p-0">
        <!-- Left Side: Image Section -->
        <div class="col-lg-7 col-md-6 d-none d-md-block login-image-side"></div>

        <!-- Right Side: Login Form Section -->
        <div class="col-lg-5 col-md-6 col-12 login-form-side">
            <div class="login-form-box">
                <h2 class="text-center mb-4 fw-bold">Welcome Back!</h2>
                <?php echo $message; ?>
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn-submit mt-2">LOGIN</button>
                    <p class="text-center mt-3 mb-0 small">New to VeganFood? <a href="register.php" class="text-decoration-none fw-bold">Create an Account</a></p>
                    <p class="text-center mt-2 mb-0 small"><a href="../index.php" class="text-decoration-none text-muted">← Back to Home</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>