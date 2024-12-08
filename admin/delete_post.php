<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
require_once '../includes/session.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id']) && isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    $questionid = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    
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
    header('Location: ../login.php');
    exit();
}
