<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require 'includes/session.php';

$userPosts = [];

if ($isLoggedIn && $user_id) {
    $userPosts = getUserPosts($pdo, $user_id);
}

ob_start();
include 'templates/my_post.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';