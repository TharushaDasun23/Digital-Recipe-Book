<?php
session_start();
include 'includes/db.php';
include 'includes/security.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: recipes.php');
    exit();
}
verify_csrf();

$recipe_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$recipe_id || $recipe_id < 1) {
    header('Location: recipes.php?status=notfound');
    exit();
}

$stmt = $conn->prepare('SELECT user_id, image_url FROM recipes WHERE id = ?');
$stmt->bind_param('i', $recipe_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();
$stmt->close();

if (!$recipe) {
    header('Location: recipes.php?status=notfound');
    exit();
}

$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
if ((int)$recipe['user_id'] !== (int)$_SESSION['user_id'] && !$is_admin) {
    header('Location: recipes.php?status=unauthorized');
    exit();
}

$delete_stmt = $conn->prepare('DELETE FROM recipes WHERE id = ?');
$delete_stmt->bind_param('i', $recipe_id);
if ($delete_stmt->execute()) {
    // Delete locally uploaded image only; never delete external URLs.
    $image = $recipe['image_url'] ?? '';
    if ($image && strpos($image, 'images/uploads/') === 0 && is_file($image)) {
        @unlink($image);
    }
    $delete_stmt->close();
    header('Location: recipes.php?status=success');
    exit();
}
$delete_stmt->close();
header('Location: recipes.php?status=error');
exit();
?>
