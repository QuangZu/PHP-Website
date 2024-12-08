<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
require_once '../includes/session.php';

$error = '';

$users = getAllUsers($pdo);

ob_start();
include '../templates/admin_users.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
?>
