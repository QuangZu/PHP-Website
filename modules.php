<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

$modules = getModulesWithQuestions($pdo);

ob_start();
include 'templates/modules.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';