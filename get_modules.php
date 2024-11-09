<?php
include 'includes/database_connection.php';

$stmt = $pdo->query("SELECT module_id, module_name FROM module");
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($modules);
?>
