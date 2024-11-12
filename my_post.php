<?php
session_start();
include 'includes/database_connection.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';

$userPosts = [];
$otherPosts = [];

if ($isLoggedIn && $user_id) {
    // User
    $stmt = $pdo->prepare("SELECT q.questionid, u.username, q.questiontitle, q.questiontext, q.questionimage, q.questionlink, q.questiondate, q.number_like, q.number_comment, q.number_save, COALESCE(m.module_name, 'Unknown Module') AS module_name
    FROM question q
    LEFT JOIN user u ON q.user_id = u.user_id
    LEFT JOIN module m ON q.module_id = m.module_id
    WHERE q.user_id = :user_id
    ORDER BY questiondate DESC");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $userPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Admin
    if ($role == 2) {
        $stmt = $pdo->prepare("SELECT q.questionid, u.username, q.questiontitle, q.questiontext, q.questionimage, q.questionlink, q.questiondate, q.number_like, q.number_comment, q.number_save, COALESCE(m.module_name, 'Unknown Module') AS module_name
        FROM question q
        LEFT JOIN user u ON q.user_id = u.user_id
        LEFT JOIN module m ON q.module_id = m.module_id
        WHERE q.user_id != :user_id
        ORDER BY questiondate DESC");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $otherPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

ob_start();
include 'templates/my_post.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
