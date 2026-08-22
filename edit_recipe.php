<?php
session_start();
include 'includes/db.php';
include 'includes/security.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$recipe = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$recipe) {
    header("Location: recipes.php?status=notfound");
    exit();
}

$is_owner = ($_SESSION['user_id'] == $recipe['user_id']);
$is_admin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

if (!$is_owner && !$is_admin) {
    header("Location: recipes.php?status=unauthorized");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $error = '';
    $title        = trim($_POST['title'] ?? '');
    $cuisine      = trim($_POST['cuisine'] ?? '');
    $cooking_time = intval($_POST['cooking_time'] ?? 0);
    $ingredients  = trim($_POST['ingredients'] ?? '');
    $instructions = trim($_POST['instructions'] ?? '');
    $final_image  = $recipe['image_url'];

    try {
        $uploaded = upload_recipe_image($_FILES['image_file'] ?? []);
        if ($uploaded !== '') {
            $final_image = $uploaded;
        } elseif (!empty(trim($_POST['image_url'] ?? ''))) {
            $candidate = trim($_POST['image_url']);
            $parts = parse_url($candidate);
            if (!filter_var($candidate, FILTER_VALIDATE_URL) || !isset($parts['scheme']) || !in_array(strtolower($parts['scheme']), ['http', 'https'], true)) {
                throw new RuntimeException('Please enter a valid HTTP/HTTPS image URL.');
            }
            $final_image = $candidate;
        }
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }

    if ($error === '' && $title !== '' && strlen($title) <= 255 && strlen($cuisine) <= 100 && $ingredients !== '' && $instructions !== '' && strlen($ingredients) <= 10000 && strlen($instructions) <= 15000 && $cooking_time > 0 && $cooking_time <= 1440) {
        $update_stmt = $conn->prepare("UPDATE recipes SET title = ?, cuisine = ?, cooking_time = ?, image_url = ?, ingredients = ?, instructions = ? WHERE id = ?");
        $update_stmt->bind_param("ssisssi", $title, $cuisine, $cooking_time, $final_image, $ingredients, $instructions, $recipe_id);
        
        if ($update_stmt->execute()) {
            $update_stmt->close();
            header("Location: recipes.php?status=updated");
            exit();
        }
        $error = 'Could not update the recipe.';
        $update_stmt->close();
    }
}

$currentImg = $recipe['image_url'];
if (!filter_var($currentImg, FILTER_VALIDATE_URL) && !empty($currentImg)) {
    if (!str_contains($currentImg, 'images/')) {
        $currentImg = 'images/' . $currentImg;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe - VeganFood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS Link -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/theme.js"></script>
</head>
<body class="bg-body-tertiary">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4 shadow-sm border-0 rounded-4 bg-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0">Edit Recipe</h2>
                    <a href="recipes.php" class="btn btn-outline-secondary btn-sm">&larr; Back to Recipes</a>
                </div>

                <form action="edit_recipe.php?id=<?php echo $recipe_id; ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>">
                    <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Recipe Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Cuisine</label>
                            <input type="text" name="cuisine" class="form-control" value="<?php echo htmlspecialchars($recipe['cuisine']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Cooking Time (minutes)</label>
                            <input type="number" name="cooking_time" class="form-control" min="1" value="<?php echo htmlspecialchars($recipe['cooking_time']); ?>">
                        </div>
                    </div>

                    <div class="mb-3 p-3 bg-body-secondary rounded border">
                        <label class="form-label fw-semibold text-muted d-block">Current Recipe Image:</label>
                        <?php if (!empty($currentImg)): ?>
                            <img src="<?php echo htmlspecialchars($currentImg); ?>" alt="Current Image" class="rounded shadow-sm" style="max-height: 120px; object-fit: cover;">
                        <?php else: ?>
                            <p class="text-muted small mb-0">No image currently set.</p>
                        <?php endif; ?>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Update Image Web URL</label>
                            <input type="text" name="image_url" class="form-control" placeholder="Paste new image web link">
                            <div class="form-text text-muted">Leave blank if uploading a file.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Upload New Photo</label>
                            <input type="file" name="image_file" class="form-control" accept="image/*">
                            <div class="form-text text-muted">Or pick a new file from your device.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ingredients <span class="text-danger">*</span></label>
                        <textarea name="ingredients" class="form-control" rows="4" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Instructions <span class="text-danger">*</span></label>
                        <textarea name="instructions" class="form-control" rows="5" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 py-2 fs-5 fw-bold rounded-3 text-dark">
                        Update Recipe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/validation.js"></script>

</body>
</html>