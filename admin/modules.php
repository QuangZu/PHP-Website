<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
require_once '../includes/session.php';

$modules = getModulesWithQuestions($pdo);

ob_start();
include '../templates/admin_modules.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';