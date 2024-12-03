<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

$questions = getQuestionsByModule($pdo, $moduleName);

if (count($questions) === 0) {
    $message = "No questions found for this module.";
}

ob_start();
include 'templates/module_ques.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';