<?php
session_start();
include 'includes/db.php';

// Security Check: Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['user_name'] ?? $_SESSION['username'] ?? 'User';

// Fetch latest user role from DB to ensure security
$role_stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$role_stmt->bind_param("i", $user_id);
$role_stmt->execute();
$role_res = $role_stmt->get_result();
if ($role_res && $role_res->num_rows > 0) {
    $role_data = $role_res->fetch_assoc();
    $role = $role_data['role'] ?? 'user';
    $_SESSION['role'] = $role;
} else {
    $role = $_SESSION['role'] ?? 'user';
}
$role_stmt->close();

$is_admin = ($role === 'admin');

// Handle contact message deletion if requested by admin
if ($is_admin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message_id'])) {
    $msg_id = intval($_POST['delete_message_id']);
    $del_stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $del_stmt->bind_param("i", $msg_id);
    $del_stmt->execute();
    $del_stmt->close();
    
    // Redirect back to the messages section after deletion
    header("Location: dashboard.php#messagesTableSection");
    exit();
}

// If Admin, fetch data for management tables
if ($is_admin) {
    // Fetch all users
    $users_result = $conn->query("SELECT id, username, email, role, created_at FROM users ORDER BY id DESC");
    
    // Fetch all contact messages
    $messages_result = $conn->query("SELECT * FROM messages ORDER BY id DESC");
    
    // Fetch total recipes count
    $recipes_count_res = $conn->query("SELECT COUNT(*) as total FROM recipes");
    $total_recipes = $recipes_count_res->fetch_assoc()['total'] ?? 0;

    // Fetch total users count
    $users_count_res = $conn->query("SELECT COUNT(*) as total FROM users");
    $total_users = $users_count_res->fetch_assoc()['total'] ?? 0;

    // Fetch total messages count
    $messages_count_res = $conn->query("SELECT COUNT(*) as total FROM messages");
    $total_messages = $messages_count_res->fetch_assoc()['total'] ?? 0;
} else {
    // Fetch user-specific recipe count for regular users
    $stmt = $conn->prepare("SELECT COUNT(*) as recipe_count FROM recipes WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_recipe_count = $stmt->get_result()->fetch_assoc()['recipe_count'] ?? 0;
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - VeganFood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/theme.js"></script>
</head>
<body class="bg-body-tertiary d-flex flex-column min-vh-100">

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
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item my-2 my-lg-0 ms-lg-3 me-lg-2 text-secondary fw-semibold">
                        Hi, <?php echo htmlspecialchars($username); ?> 
                        <?php if ($is_admin): ?><span class="badge bg-danger ms-1">Admin</span><?php endif; ?>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger text-white px-4 rounded-pill shadow-sm btn-sm" href="auth/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-body">
                    <h2 class="fw-bold mb-1">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
                    <p class="text-muted mb-0">
                        <?php echo $is_admin ? "You are logged in as Administrator. Manage system data below." : "Manage your profile, recipes, and account settings from here."; ?>
                    </p>
                </div>
            </div>
        </div>

        <?php if ($is_admin): ?>
            <!-- ADMIN DASHBOARD SECTION -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-body text-center">
                        <div class="display-5 text-success fw-bold mb-2"><?php echo $total_recipes; ?></div>
                        <h5 class="fw-semibold text-secondary">Total Recipes</h5>
                        <a href="recipes.php" class="btn btn-outline-success rounded-pill mt-3">Manage All Recipes</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-body text-center">
                        <div class="display-5 text-primary fw-bold mb-2"><?php echo $total_users; ?></div>
                        <h5 class="fw-semibold text-secondary">Registered Users</h5>
                        <a href="#usersTableSection" class="btn btn-outline-primary rounded-pill mt-3">View All Users</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-body text-center">
                        <div class="display-5 text-warning fw-bold mb-2"><?php echo $total_messages; ?></div>
                        <h5 class="fw-semibold text-secondary">Contact Messages</h5>
                        <a href="#messagesTableSection" class="btn btn-outline-warning rounded-pill mt-3 text-dark">View Messages</a>
                    </div>
                </div>
            </div>

            <!-- Users Management Table -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-body mb-5" id="usersTableSection">
                <h4 class="fw-bold mb-3">👥 Registered Users</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Registered Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($users_result && $users_result->num_rows > 0): ?>
                                <?php while($u = $users_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $u['id']; ?></td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($u['username']); ?></td>
                                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                                        <td>
                                            <span class="badge <?php echo ($u['role'] === 'admin') ? 'bg-danger' : 'bg-secondary'; ?>">
                                                <?php echo htmlspecialchars($u['role']); ?>
                                            </span>
                                        </td>
                                        <td class="text-muted small"><?php echo $u['created_at']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contact Messages Table -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-body mb-4" id="messagesTableSection">
                <h4 class="fw-bold mb-3">✉️ Contact Form Messages</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($messages_result && $messages_result->num_rows > 0): ?>
                                <?php while($m = $messages_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $m['id']; ?></td>
                                        <td class="fw-semibold"><?php echo htmlspecialchars($m['name']); ?></td>
                                        <td><a href="mailto:<?php echo htmlspecialchars($m['email']); ?>"><?php echo htmlspecialchars($m['email']); ?></a></td>
                                        <td><div style="max-width: 300px; white-space: pre-wrap;"><?php echo htmlspecialchars($m['message']); ?></div></td>
                                        <td class="text-muted small"><?php echo $m['created_at']; ?></td>
                                        <td>
                                            <form method="POST" action="dashboard.php" onsubmit="return confirm('Are you sure you want to delete this message?');" style="display:inline;">
                                                <input type="hidden" name="delete_message_id" value="<?php echo $m['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center text-muted">No messages received yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <!-- REGULAR USER DASHBOARD SECTION -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-body h-100 text-center d-flex flex-column">
                        <div class="display-5 text-success fw-bold mb-2"><?php echo $user_recipe_count; ?></div>
                        <h5 class="fw-semibold text-secondary">Your Added Recipes</h5>
                        <p class="text-muted small mt-2">Manage, edit, or delete the recipes you have shared with the community.</p>
                        <a href="recipes.php" class="btn btn-outline-success rounded-pill mt-auto">View Recipes</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-body h-100 text-center d-flex flex-column">
                        <div class="display-5 text-primary fw-bold mb-2">🥗</div>
                        <h5 class="fw-semibold text-secondary">Add New Recipe</h5>
                        <p class="text-muted small mt-2">Share a new plant-based recipe with other food lovers on VeganFood.</p>
                        <a href="add_recipe.php" class="btn btn-success rounded-pill mt-auto text-white">Add Recipe</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-body h-100 text-center d-flex flex-column">
                        <div class="display-5 text-warning fw-bold mb-2">⚙️</div>
                        <h5 class="fw-semibold text-secondary">Account Role</h5>
                        <p class="text-muted small mt-2">Current privilege level: <span class="badge bg-secondary text-uppercase"><?php echo htmlspecialchars($role); ?></span></p>
                        <a href="contact.php" class="btn btn-outline-secondary rounded-pill mt-auto">Support / Contact</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer class="bg-body text-center py-4 border-top mt-auto">
        <p class="text-muted mb-0">Copyright &copy; 2026 VeganFood. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>