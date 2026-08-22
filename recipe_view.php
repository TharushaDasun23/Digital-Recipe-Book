<?php 
session_start(); 
include 'includes/db.php'; 
include 'includes/functions.php'; 

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $recipe_id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $recipe = $result->fetch_assoc();
    } else {
        header("Location: recipes.php");
        exit();
    }
} else {
    header("Location: recipes.php");
    exit();
}

$imgSrc = resolve_recipe_image($recipe['image_url']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['title']); ?> - VeganFood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/theme.js"></script>
</head>
<body class="bg-body-tertiary d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg bg-body shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="images/logo.svg" alt="VeganFood Logo" style="height: 45px; width: auto;" class="d-inline-block align-top">
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
                        <li class="nav-item my-2 my-lg-0 ms-lg-3 me-lg-2 text-secondary fw-semibold">
                            Hi, <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>
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
        
        <div class="mb-4">
            <h1 class="fw-bold mb-1"><?php echo htmlspecialchars($recipe['title']); ?></h1>
            <p class="text-secondary fs-5 fw-semibold">
                <?php echo htmlspecialchars($recipe['cuisine']); ?> • 
                <?php echo htmlspecialchars($recipe['cooking_time']); ?> mins • 
                Serves <?php echo htmlspecialchars($recipe['servings'] ?? 'N/A'); ?>
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-body h-100 d-flex flex-column justify-content-between">
                    <div class="rounded-4 overflow-hidden mb-3 flex-grow-1 d-flex align-items-center justify-content-center bg-body-tertiary" style="min-height: 400px;">
                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>" class="img-fluid w-100" style="object-fit: cover; max-height: 450px; border-radius: 12px;">
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-body-secondary h-100">
                    
                    <div class="d-flex align-items-center border-bottom border-2 border-success-subtle pb-2 mb-4">
                        <span class="bg-success text-white rounded-circle p-2 me-3 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">🥗</span>
                        <h4 class="fw-bold mb-0 text-success">Ingredients List</h4>
                    </div>

                    <div class="mb-5">
                        <?php 
                        $ingredients = explode("\n", $recipe['ingredients']);
                        foreach ($ingredients as $ingredient) {
                            if (trim($ingredient) != "") {
                                echo "<div class='d-flex align-items-center mb-3 fs-5'>";
                                echo "<span class='badge bg-success p-2 rounded-circle me-3' style='width: 10px; height: 10px;'></span>";
                                echo "<div class='fw-semibold'>" . htmlspecialchars($ingredient) . "</div>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>

                    <div class="d-flex align-items-center border-bottom border-2 border-success-subtle pb-2 mb-4">
                        <span class="bg-success text-white rounded-circle p-2 me-3 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">👨‍🍳</span>
                        <h4 class="fw-bold mb-0 text-success">Cooking Instructions</h4>
                    </div>

                    <ol class="list-group list-group-numbered list-group-flush bg-transparent">
                        <?php 
                        $instructions = explode("\n", $recipe['instructions']);
                        foreach ($instructions as $step) {
                            if (trim($step) != "") {
                                echo "<li class='list-group-item bg-transparent border-0 ps-0 fs-5 fw-medium mb-2'>" . htmlspecialchars(preg_replace('/^[0-9].\s*/', '', $step)) . "</li>";
                            }
                        }
                        ?>
                    </ol>

                </div>
            </div>
        </div>
    </div>

    <footer class="bg-body text-center py-4 border-top mt-auto">
        <p class="text-muted mb-0">Copyright &copy; 2026 VeganFood. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>