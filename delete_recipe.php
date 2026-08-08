<?php
session_start();
include 'includes/db.php';

//Security Check: Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}


if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $recipe_id = intval($_GET['id']); // Convert to integer to prevent SQL Injection
    
 
    $stmt = $conn->prepare("SELECT user_id FROM recipes WHERE id = ?");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $recipe_owner_id = $row['user_id'];
        
     
        if ($_SESSION['user_id'] == $recipe_owner_id || (isset($_SESSION['role']) && $_SESSION['role'] == 'admin')) {
            
            // Authorization successful: Proceed with the deletion query
            $delete_stmt = $conn->prepare("DELETE FROM recipes WHERE id = ?");
            $delete_stmt->bind_param("i", $recipe_id);
            
            if ($delete_stmt->execute()) {
                // Redirect back to recipes list with a success status message
                header("Location: recipes.php?status=success");
                exit();
            } else {
                echo "Error deleting the recipe. Please try again.";
            }
            $delete_stmt->close();
            
        } else {
         
            header("Location: recipes.php?status=unauthorized");
            exit();
        }
    } else {
     
        header("Location: recipes.php?status=notfound");
        exit();
    }
    $stmt->close();
} else {
 
    header("Location: recipes.php");
    exit();
}
?>