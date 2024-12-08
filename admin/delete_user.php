<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
require_once '../includes/session.php';

$error = '';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    try {
        deleteUser($pdo, $user_id);
        header("Location: users.php");
        exit;
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
} else {
    $error = "Invalid request.";
}
?>
