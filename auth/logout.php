<?php
session_start();

// Unset all session variables
session_unset();

// Destroy session
session_destroy();

// Redirect back to root index home page
header("Location: ../index.php"); 
exit();
?>