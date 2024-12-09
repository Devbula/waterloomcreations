<?php

@include 'config.php';

session_start();

// Check if user_id is set in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Save to audit trail
    $sql = "INSERT INTO audit_trail (user_id, description) VALUES ('$user_id', 'User successfully logout')";
    if (!mysqli_query($conn, $sql)) {
        // Handle the SQL error
        die("SQL Error: " . mysqli_error($conn));
    }
} else {
    // Handle the case where user_id is not set
    echo "User ID is not set.";
}

// Unset and destroy the session
session_unset();
session_destroy();

// Redirect to login page
header('location:login.php');
exit;

?>