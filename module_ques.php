<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';
$moduleName = $_GET['module'] ?? '';

$questions = getQuestionsByModule($pdo, $moduleName);

if (count($questions) === 0) {
    $message = "No questions found for this module.";
}

ob_start();
include 'templates/module_ques.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
