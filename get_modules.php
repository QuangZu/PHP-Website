<?php
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

$modules = getAllModules($pdo);

header('Content-Type: application/json');
echo json_encode($modules);
?>
