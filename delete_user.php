<?php
session_start();
include 'includes/database_connection.php';

$error = '';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];

    $stmt = $pdo->prepare('DELETE FROM user WHERE user_id = :user_id AND role = 1');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: users.php");
        exit;
    } else {
        $error = "Error: Could not delete user.";
    }
} else {
    $error = "Invalid request.";
}
?>
