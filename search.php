<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';

$searchQuery = $_GET['query'] ?? '';
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';

$questions = [];
if ($searchQuery) {
    $questions = searchQuestions($pdo, $searchQuery);
}

ob_start();
include 'templates/search.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
