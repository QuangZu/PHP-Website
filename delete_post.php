<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

$error = '';

if (isset($_GET['id'])) {
    $questionid = $_GET['id'];
    
    if (deleteQuestion($pdo, $questionid, $user_id, $role)) {
        header('Location: my_post.php');
        exit();
    } else {
        $error = 'Failed to delete question';
        header('Location: my_post.php?error=' . urlencode($error));
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
