<?php
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';

$modules = getAllModules($pdo);

header('Content-Type: application/json');
echo json_encode($modules);
?>
