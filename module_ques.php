<?php
session_start();
include 'includes/database_connection.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';
$moduleName = $_GET['module'] ?? '';

$sql = 'SELECT q.questionid, q.user_id, u.username, u.image, q.questiontitle, q.questiontext, q.questionimage, q.questionlink, q.questiondate, q.number_like, q.number_comment
        FROM question q
        LEFT JOIN user u ON q.user_id = u.user_id
        INNER JOIN module m ON q.module_id = m.module_id
        WHERE m.module_name = :module_name
        ORDER BY q.questiondate DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute(['module_name' => $moduleName]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($questions) === 0) {
    $message = "No questions found for this module.";
}

ob_start();
include 'templates/module_ques.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
