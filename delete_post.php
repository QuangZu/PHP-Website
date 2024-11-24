<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';

if (isset($_GET['id']) && isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $questionid = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role']; // Fetch user's role from the session
    
    // Allow delete based on role
    if (deleteQuestion($pdo, $questionid, $user_id, $role)) {
        header('Location: my_post.php');
        exit();
    } else {
        $error = 'Failed to delete question';
        header('Location: my_post.php?error=' . urlencode($error));
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
