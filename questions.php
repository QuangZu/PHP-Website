<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';

// Fetch all questions
$questions = getAllQuestions($pdo);

ob_start();
include 'templates/questions.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
