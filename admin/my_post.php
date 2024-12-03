<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
require_once '../includes/session.php';

$userPosts = [];
$otherPosts = [];

if ($isLoggedIn && $user_id) {
    $userPosts = getUserPosts($pdo, $user_id);

    if ($role == 2) {
        $otherPosts = getOtherPosts($pdo, $user_id);
    }
}

ob_start();
include '../templates/admin_my_post.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';