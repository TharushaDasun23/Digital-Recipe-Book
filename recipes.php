<?php
session_start();
include 'includes/db.php';

// Security Check: Redirect unauthenticated users to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$cuisine_sql = "SELECT DISTINCT cuisine FROM recipes WHERE cuisine IS NOT NULL AND cuisine != '' ORDER BY cuisine ASC";
$cuisine_result = $conn->query($cuisine_sql);

$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$selected_cuisine = isset($_GET['cuisine']) ? trim($_GET['cuisine']) : '';

if (!empty($search_query) && !empty($selected_cuisine)) {
    $like_query = "%" . $search_query . "%";
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE (title LIKE ? OR cuisine LIKE ?) AND cuisine = ? ORDER BY id DESC");
    $stmt->bind_param("sss", $like_query, $like_query, $selected_cuisine);
    $stmt->execute();
    $result = $stmt->get_result();
} elseif (!empty($search_query)) {
    $like_query = "%" . $search_query . "%";
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE title LIKE ? OR cuisine LIKE ? ORDER BY id DESC");
    $stmt->bind_param("ss", $like_query, $like_query);
    $stmt->execute();
    $result = $stmt->get_result();
} elseif (!empty($selected_cuisine)) {
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE cuisine = ? ORDER BY id DESC");
    $stmt->bind_param("s", $selected_cuisine);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM recipes ORDER BY id DESC";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes - VeganFood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS Link -->
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
                    <li class="nav-item"><a class="nav-link active fw-bold text-success" href="recipes.php">Recipes</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    
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

    <div class="container my-5">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-0">Explore Recipes</h2>
                <p class="text-muted small mb-0">Discover healthy and delicious plant-based meals</p>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="add_recipe.php" class="btn btn-success rounded-pill px-3 shadow-sm fw-bold">
                        + Add Recipe
                    </a>
                <?php endif; ?>
                
                <form action="recipes.php" method="GET" class="d-flex" style="max-width: 320px;">
                    <?php if (!empty($selected_cuisine)): ?>
                        <input type="hidden" name="cuisine" value="<?php echo htmlspecialchars($selected_cuisine); ?>">
                    <?php endif; ?>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control rounded-start-pill px-3" placeholder="Search recipes..." value="<?php echo htmlspecialchars($search_query); ?>">
                        <button type="submit" class="btn btn-success rounded-end-pill px-3">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="category-scroll mb-4">
            <a href="recipes.php<?php echo !empty($search_query) ? '?search=' . urlencode($search_query) : ''; ?>" 
               class="btn btn-sm me-2 rounded-pill <?php echo empty($selected_cuisine) ? 'btn-success fw-bold' : 'btn-outline-secondary'; ?>">
               All Categories
            </a>

            <?php 
            if ($cuisine_result && $cuisine_result->num_rows > 0) {
                while ($c_row = $cuisine_result->fetch_assoc()) {
                    $c_name = $c_row['cuisine'];
                    $is_active = ($selected_cuisine === $c_name);
                    $url = "recipes.php?cuisine=" . urlencode($c_name);
                    if (!empty($search_query)) {
                        $url .= "&search=" . urlencode($search_query);
                    }
            ?>
                    <a href="<?php echo $url; ?>" 
                       class="btn btn-sm me-2 rounded-pill <?php echo $is_active ? 'btn-success fw-bold shadow-sm' : 'btn-outline-secondary'; ?>">
                       <?php echo htmlspecialchars($c_name); ?>
                    </a>
            <?php 
                }
            } 
            ?>
        </div>

        <?php if (!empty($selected_cuisine) || !empty($search_query)): ?>
            <div class="d-flex align-items-center mb-4 bg-body p-2 px-3 rounded-3 shadow-sm border">
                <span class="text-muted small me-2">Active Filters:</span>
                <?php if (!empty($selected_cuisine)): ?>
                    <span class="badge bg-success me-2">Category: <?php echo htmlspecialchars($selected_cuisine); ?></span>
                <?php endif; ?>
                <?php if (!empty($search_query)): ?>
                    <span class="badge bg-info text-dark me-2">Search: "<?php echo htmlspecialchars($search_query); ?>"</span>
                <?php endif; ?>
                <a href="recipes.php" class="text-danger ms-auto small text-decoration-none fw-semibold">Clear All ×</a>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php 
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $imgSrc = $row['image_url'];

                    if (strpos($imgSrc, 'assets/') === 0) {
                        $imgSrc = str_replace('assets/', '', $imgSrc);
                    }

                    if (!filter_var($imgSrc, FILTER_VALIDATE_URL)) { 
                        if (strpos($imgSrc, 'uploads/') !== 0 && strpos($imgSrc, 'images/') !== 0) {
                            $imgSrc = 'images/' . $imgSrc; 
                        } elseif (strpos($imgSrc, 'uploads/') === 0) {
                            $imgSrc = 'images/' . $imgSrc;
                        }
                    }

                    $can_edit_delete = false;
                    if (isset($_SESSION['user_id'])) {
                        $current_user_id = $_SESSION['user_id'];
                        $is_admin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') || 
                                    (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1);
                        $is_owner = isset($row['user_id']) && ($row['user_id'] == $current_user_id);

                        if ($is_admin || $is_owner) {
                            $can_edit_delete = true;
                        }
                    }
            ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card recipe-card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-body p-3">
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" class="card-img-top rounded-4" alt="<?php echo htmlspecialchars($row['title']); ?>" style="height: 180px; object-fit: cover;">
                            
                            <div class="card-body p-2 text-center d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <span class="badge bg-body-tertiary text-success border mb-2"><?php echo htmlspecialchars($row['cuisine']); ?></span>
                                    <h6 class="card-title fw-bold mb-1"><?php echo htmlspecialchars($row['title']); ?></h6>
                                    <p class="card-text text-muted small mb-0">⏱️ <?php echo htmlspecialchars($row['cooking_time']); ?> min</p>
                                </div>
                                
                                <div>
                                    <a href="recipe_view.php?id=<?php echo $row['id']; ?>" class="btn btn-success text-white btn-sm w-100 rounded-pill py-2 shadow-sm">View Recipe →</a>

                                    <?php if ($can_edit_delete): ?>
                                        <div class="d-flex gap-2 mt-2 pt-2 border-top">
                                            <a href="edit_recipe.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-warning btn-sm w-50 rounded-pill fw-semibold">Edit</a>
                                            <a href="delete_recipe.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm w-50 rounded-pill fw-semibold" onclick="return confirm('Are you sure you want to delete this recipe?');">Delete</a>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>
            <?php 
                }
            } else {
                echo "<div class='col-12 text-center my-5 py-5'><p class='text-muted fs-5 mb-1'>No recipes found matching your filter.</p><a href='recipes.php' class='btn btn-sm btn-outline-success rounded-pill mt-2'>Reset Filters</a></div>";
            }
            if(isset($stmt)) { $stmt->close(); }
            ?>
        </div>
    </div>

    <footer class="bg-body text-center py-4 border-top mt-auto">
        <p class="text-muted mb-0">Copyright &copy; 2026 VeganFood. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/transition.js"></script>
    <script src="js/hover.js"></script>
    <script src="js/scroll.js"></script>
</body>
</html>