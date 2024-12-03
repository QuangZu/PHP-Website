<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
require_once '../includes/session.php';

$error = '';

if (!$isLoggedIn || $role != 2) {
    header("Location: ../index.php");
    exit;
}

$users = getAllUsers($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    if (deleteUser($pdo, $userId)) {
        header("Location: users.php");
        exit;
    } else {
        $error = "Error deleting user.";
    }
}

ob_start();
include '../templates/admin_users.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
?>
