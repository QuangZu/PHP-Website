<?php
session_start();
include 'includes/database_connection.php';

$searchQuery = $_GET['query'] ?? '';
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';

$questions = [];
if ($searchQuery) {
    $stmt = $pdo->prepare("
        SELECT q.questionid, u.username, u.image, q.questiontitle, q.questiontext, q.questionimage, 
               q.questionlink, q.questiondate, q.number_like, q.number_comment, m.module_name
        FROM question q
        LEFT JOIN user u ON q.user_id = u.user_id
        LEFT JOIN module m ON q.module_id = m.module_id
        WHERE q.questiontitle LIKE :searchQuery
        ORDER BY q.questiondate DESC
    ");
    $stmt->execute(['searchQuery' => '%' . $searchQuery . '%']);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

ob_start();
include 'templates/search.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
