<?php
session_start();
include 'includes/db.php';

$search_query = "";
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_query = trim($_GET['search']);
    $like_query = "%" . $search_query . "%";
    
    $stmt = $conn->prepare("SELECT * FROM recipes WHERE title LIKE ? OR cuisine LIKE ? ORDER BY id DESC LIMIT 4");
    $stmt->bind_param("ss", $like_query, $like_query);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM recipes ORDER BY id DESC LIMIT 4";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - VeganFood</title>
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
                    <li class="nav-item"><a class="nav-link active fw-bold text-success" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="recipes.php">Recipes</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-success" href="dashboard.php">📊 Dashboard</a>
                        </li>
                        <li class="nav-item my-2 my-lg-0 ms-lg-3 me-lg-2 text-secondary fw-semibold">
                            Hi, <?php echo htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['username'] ?? 'User'); ?>
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

    <div class="hero-wrapper py-5">
        <div class="container">
            <div class="hero-box p-5 text-center bg-body-secondary rounded-4 shadow-sm">
                <img src="images/logo.svg" alt="VeganFood Logo" class="mb-3" style="height: 160px !important; width: auto !important;">
                <p class="fs-5 mb-4 fw-semibold">Discover, save and share your favourite recipes</p>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form action="recipes.php" method="GET" class="d-flex" id="searchForm">
                            <input type="text" id="searchInput" name="search" class="form-control rounded-pill px-4 custom-search-input" placeholder="Search recipes..." value="<?php echo htmlspecialchars($search_query); ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5" id="popular-recipes">
        <div class="mb-4"><h3 class="fw-bold">Popular Recipes</h3></div>
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
            ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card recipe-card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-body p-3">
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" class="card-img-top rounded-4" alt="<?php echo htmlspecialchars($row['title']); ?>" style="height: 180px; object-fit: cover;">
                            <div class="card-body p-2 text-center d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <h6 class="card-title fw-bold mb-1"><?php echo htmlspecialchars($row['title']); ?></h6>
                                    <p class="card-text text-muted small mb-0"><?php echo htmlspecialchars($row['cuisine']); ?> • <?php echo htmlspecialchars($row['cooking_time']); ?> min</p>
                                </div>
                                <a href="recipe_view.php?id=<?php echo $row['id']; ?>" class="btn btn-success text-white btn-sm w-100 rounded-pill py-2 shadow-sm">View Recipe →</a>
                            </div>
                        </div>
                    </div>
            <?php 
                }
            } else {
                echo "<div class='col-12 text-center my-5'><p class='text-muted fs-5'>No recipes found.</p></div>";
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
    <script src="js/validation.js"></script>

</body>
</html>