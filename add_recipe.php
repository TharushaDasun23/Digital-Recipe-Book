<?php
session_start();
include 'includes/db.php';
include 'includes/security.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $title = trim($_POST['title'] ?? '');
    $cuisine = trim($_POST['cuisine'] ?? '');
    $cooking_time = filter_input(INPUT_POST, 'cooking_time', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 0;
    $servings = filter_input(INPUT_POST, 'servings', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 0;
    $ingredients = trim($_POST['ingredients'] ?? '');
    $instructions = trim($_POST['instructions'] ?? '');
    $final_image = trim($_POST['image_url'] ?? '');

    if ($title === '' || $ingredients === '' || $instructions === '' || $cooking_time < 1 || $servings < 1) {
        $error = 'Please fill all required fields with valid values.';
    } elseif ($final_image !== '') {
        $parts = parse_url($final_image);
        if (!filter_var($final_image, FILTER_VALIDATE_URL) || !isset($parts['scheme']) || !in_array(strtolower($parts['scheme']), ['http', 'https'], true)) {
            $error = 'Please enter a valid HTTP/HTTPS image URL.';
        }
    } else {
        try {
            $uploaded = upload_recipe_image($_FILES['image_file'] ?? []);
            if ($uploaded !== '') $final_image = $uploaded;

            $user_id = (int)$_SESSION['user_id'];
            $stmt = $conn->prepare('INSERT INTO recipes (user_id, title, cuisine, cooking_time, servings, image_url, ingredients, instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('issiisss', $user_id, $title, $cuisine, $cooking_time, $servings, $final_image, $ingredients, $instructions);
            if (!$stmt->execute()) {
                throw new RuntimeException('Could not save the recipe.');
            }
            $stmt->close();
            header('Location: recipes.php?status=created');
            exit();
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Recipe - VeganFood</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css"><script src="js/theme.js"></script>
</head>
<body class="bg-body-tertiary">
<div class="container my-5"><div class="row justify-content-center"><div class="col-md-8">
<div class="card p-4 shadow-sm border-0 rounded-4 bg-body">
<div class="d-flex justify-content-between align-items-center mb-4"><h2 class="fw-bold mb-0">+ Add New Recipe</h2><a href="recipes.php" class="btn btn-outline-secondary btn-sm">&larr; Back</a></div>
<?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<form action="add_recipe.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>">
<div class="mb-3"><label class="form-label fw-semibold">Recipe Title *</label><input type="text" name="title" maxlength="255" class="form-control" required value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"></div>
<div class="row"><div class="col-md-4 mb-3"><label class="form-label fw-semibold">Cuisine</label><input type="text" name="cuisine" maxlength="100" class="form-control" value="<?php echo htmlspecialchars($_POST['cuisine'] ?? ''); ?>"></div><div class="col-md-4 mb-3"><label class="form-label fw-semibold">Cooking Time *</label><input type="number" name="cooking_time" min="1" max="1440" class="form-control" required value="<?php echo htmlspecialchars($_POST['cooking_time'] ?? ''); ?>"></div><div class="col-md-4 mb-3"><label class="form-label fw-semibold">Servings *</label><input type="number" name="servings" min="1" max="100" class="form-control" required value="<?php echo htmlspecialchars($_POST['servings'] ?? ''); ?>"></div></div>
<div class="row mb-3"><div class="col-md-6 mb-3"><label class="form-label fw-semibold">Image Web URL</label><input type="url" name="image_url" class="form-control" placeholder="https://..." value="<?php echo htmlspecialchars($_POST['image_url'] ?? ''); ?>"></div><div class="col-md-6 mb-3"><label class="form-label fw-semibold">Upload Picture</label><input type="file" name="image_file" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif"><div class="form-text">JPG/PNG/WEBP/GIF, max 5 MB.</div></div></div>
<div class="mb-3"><label class="form-label fw-semibold">Ingredients *</label><textarea name="ingredients" maxlength="10000" class="form-control" rows="5" required><?php echo htmlspecialchars($_POST['ingredients'] ?? ''); ?></textarea></div>
<div class="mb-3"><label class="form-label fw-semibold">Instructions *</label><textarea name="instructions" maxlength="15000" class="form-control" rows="6" required><?php echo htmlspecialchars($_POST['instructions'] ?? ''); ?></textarea></div>
<button type="submit" class="btn btn-success w-100 py-2 fs-5 fw-bold rounded-3">Save Recipe</button>
</form></div></div></div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
