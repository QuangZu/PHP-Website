<?php
session_start();
include 'includes/database_connection.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;
$image = $_SESSION['image'] ?? '';

if (!$isLoggedIn || $role != 2) {
    header("Location: index.php");
    exit;
}

$sql = 'SELECT username, email, date, user_id FROM user WHERE role = 1';
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
include 'templates/users.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
