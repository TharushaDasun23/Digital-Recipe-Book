<?php
// Initialize session to manage user login state
session_start();

// Include database connection configuration
include 'includes/db.php';

// Authentication check: Redirect unauthenticated users to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Initialize status variable for feedback messages
$status = "";

// Check if the form has been submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form inputs
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message_text = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Format the message by combining subject and body text
    $full_message = "Subject: " . $subject . "\n\n" . $message_text;
    
    // Retrieve the current logged-in user's ID from the session
    $user_id = $_SESSION['user_id'];

    // Validate that required fields are not empty
    if (!empty($name) && !empty($email) && !empty($message_text)) {
        // Prepare SQL statement to insert the contact message into the database with the user ID
        $stmt = $conn->prepare("INSERT INTO messages (user_id, name, email, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $name, $email, $full_message);

        // Execute the statement and set success or error feedback
        if ($stmt->execute()) {
            $status = "<div class='alert alert-success'>Message sent successfully!</div>";
        } else {
            $status = "<div class='alert alert-danger'>Error sending message.</div>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - VeganFood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/theme.js"></script>
    <style>
        .contact-form-container { border-radius: 24px; padding: 40px; max-width: 600px; margin: 50px auto; }
        .form-control { margin-bottom: 15px; }
        .btn-submit { background-color: #198754; color: white; width: 100%; border: none; padding: 12px; border-radius: 50px; font-weight: bold; }
        .btn-submit:hover { background-color: #157347; color: white; }
    </style>
</head>
<body class="bg-body-tertiary d-flex flex-column min-vh-100">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg bg-body shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.svg" alt="VeganFood Logo" style="height: 60px !important; width: auto !important;">
            </a>

            <div class="d-flex align-items-center gap-2 order-lg-last">
                <button id="themeToggleBtn" class="btn btn-outline-dark btn-sm rounded-pill">🌙 Dark Mode</button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse justify-content-end me-lg-3" id="navbarNav">
                <ul class="navbar-nav align-items-center text-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="recipes.php">Recipes</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold text-success" href="contact.php">Contact</a></li>
                    
                    <!-- Check if user is logged in to show user details or login button -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-success" href="dashboard.php">📊 Dashboard</a>
                        </li>
                        <li class="nav-item my-2 my-lg-0 ms-lg-3 me-lg-2 text-secondary fw-semibold">
                            Hi, <?php echo htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['username'] ?? $_SESSION['name'] ?? 'User'); ?>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-danger text-white px-4 rounded-pill shadow-sm btn-sm" href="auth/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item my-2 my-lg-0 ms-lg-2">
                            <a class="btn btn-outline-success px-4 rounded-pill btn-sm" href="auth/login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container for Contact Form -->
    <div class="container my-auto">
        <div class="contact-form-container bg-body-secondary shadow-sm">
            <h2 class="text-center mb-4 fw-bold">Contact Us</h2>
            <p><?php echo $status; ?></p>
            <form method="POST" action="contact.php">
                <label class="form-label fw-semibold">Name</label>
                <input type="text" class="form-control rounded-3" name="name" placeholder="Your Full Name" required>
                
                <label class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control rounded-3" name="email" placeholder="name@example.com" required>
                
                <label class="form-label fw-semibold">Subject</label>
                <input type="text" class="form-control rounded-3" name="subject" placeholder="Enter message subject" required>
                
                <label class="form-label fw-semibold">Message</label>
                <textarea class="form-control rounded-3" name="message" rows="5" placeholder="Type your message here..." required></textarea>
                
                <button type="submit" class="btn-submit shadow-sm mt-2">Send Message</button>
            </form>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-body text-center py-4 border-top mt-auto">
        <p class="text-muted mb-0">Copyright &copy; 2026 VeganFood. All rights reserved.</p>
    </footer>

    <!-- JavaScript Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/hover.js"></script>
    <script src="js/scroll.js"></script>
</body>
</html>