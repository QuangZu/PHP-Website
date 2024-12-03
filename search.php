<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

$searchQuery = $_GET['query'] ?? '';
$questions = [];
if ($searchQuery) {
    $questions = searchQuestions($pdo, $searchQuery);
}

ob_start();
include 'templates/search.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';