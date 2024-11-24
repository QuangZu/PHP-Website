<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';

$userPosts = [];
$otherPosts = [];

if ($isLoggedIn && $user_id) {
    $userPosts = getUserPosts($pdo, $user_id);

    if ($role == 2) {
        $otherPosts = getOtherPosts($pdo, $user_id);
    }
}

ob_start();
include 'templates/my_post.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
