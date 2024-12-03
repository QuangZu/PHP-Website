<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

// Fetch all questions
$questions = getAllQuestions($pdo);

ob_start();
include 'templates/questions.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';