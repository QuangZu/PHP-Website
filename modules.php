<?php
session_start();
include 'includes/database_connection.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';

$sql = "SELECT * FROM user WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT m.module_name, q.questionid, q.user_id, u.username, q.questiontitle, q.questiontext, 
               q.questionimage, q.questionlink, q.questiondate, q.number_like, q.number_comment
        FROM module m
        LEFT JOIN question q ON m.module_id = q.module_id
        LEFT JOIN user u ON q.user_id = u.user_id
        ORDER BY m.module_name, q.questiondate DESC';
$stmt = $pdo->query($sql);
$modulesWithQuestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$modules = [];
foreach ($modulesWithQuestions as $item) {
    $moduleName = $item['module_name'];
    $modules[$moduleName][] = $item;
}

ob_start();
include 'templates/modules.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
