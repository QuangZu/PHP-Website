<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$questionId = $_GET['id'] ?? null;
$username = $_SESSION['username'] ?? '';
$email = $_SESSION['email'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? 1;
$image = $_SESSION['image'] ?? '';
$module_id = $_SESSION['module_id'] ?? null;
$module_name = $_SESSION['module_name'] ?? null;
$moduleName = $_GET['module'] ?? '';