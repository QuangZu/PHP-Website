<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;
$image = $_SESSION['image'] ?? '';
$error = '';

if (!$isLoggedIn || $role != 2) {
    header("Location: ../index.php");
    exit;
}

$users = getAllUsers($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    if (deleteUser($pdo, $userId)) {
        header("Location: ../users.php");
        exit;
    } else {
        $error = "Error deleting user.";
    }
}

ob_start();
include '../templates/users.html.php';
$output = ob_get_clean();
include '../templates/layout.html.php';
?>
