<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title        = trim($_POST['title']);
    $cuisine      = trim($_POST['cuisine'] ?? '');
    $cooking_time = intval($_POST['cooking_time'] ?? 0);
    $servings     = intval($_POST['servings'] ?? 0);
    $ingredients  = trim($_POST['ingredients']);
    $instructions = trim($_POST['instructions']);
    $final_image  = '';

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'images/uploads/'; 
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_ext     = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
        $new_filename = time() . '_' . uniqid() . '.' . $file_ext;
        $target_path  = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_path)) {
            $final_image = $target_path;
        }
    } elseif (!empty($_POST['image_url'])) {
        $final_image = trim($_POST['image_url']);
    }

    if (!empty($title) && !empty($ingredients) && !empty($instructions)) {
        $user_id = $_SESSION['user_id'] ?? 1;
        $stmt = $conn->prepare("INSERT INTO recipes (user_id, title, cuisine, cooking_time, servings, image_url, ingredients, instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issiisss", $user_id, $title, $cuisine, $cooking_time, $servings, $final_image, $ingredients, $instructions);
        $stmt->execute();
        $stmt->close();
        
        header("Location: recipes.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe - VeganFood</title>
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
                    <h2 class="fw-bold mb-0">+ Add New Recipe</h2>
                    <a href="recipes.php" class="btn btn-outline-secondary btn-sm">&larr; Back to Recipes</a>
                </div>

                <form action="add_recipe.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Recipe Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Enter recipe title" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Cuisine</label>
                            <input type="text" name="cuisine" class="form-control" placeholder="e.g. Sri Lankan, Italian">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Cooking Time (mins)</label>
                            <input type="number" name="cooking_time" class="form-control" min="1" placeholder="e.g. 30">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Servings (persons)</label>
                            <input type="number" name="servings" class="form-control" min="1" placeholder="e.g. 4">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Image Web URL</label>
                            <input type="text" name="image_url" class="form-control" placeholder="Paste image web link here">
                            <div class="form-text text-muted">Link from the internet.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Upload Food Picture</label>
                            <input type="file" name="image_file" class="form-control" accept="image/*">
                            <div class="form-text text-muted">Or choose photo from your device.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ingredients <span class="text-danger">*</span></label>
                        <textarea name="ingredients" class="form-control" rows="4" placeholder="List your ingredients here..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Instructions <span class="text-danger">*</span></label>
                        <textarea name="instructions" class="form-control" rows="5" placeholder="Step by step preparation guide..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fs-5 fw-bold rounded-3">
                        Save Recipe
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