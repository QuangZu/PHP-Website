<?php
session_start();
include 'includes/database_connection.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['questionid'])) {
    $questionid = $_POST['questionid'];
    $questiontitle = $_POST['questiontitle'];
    $questiontext = $_POST['questiontext'];
    
    $stmt = $pdo->prepare("UPDATE question SET questiontitle = :questiontitle, questiontext = :questiontext WHERE questionid = :questionid AND user_id = :user_id");
    $stmt->bindValue(':questiontitle', $questiontitle);
    $stmt->bindValue(':questiontext', $questiontext);
    $stmt->bindValue(':questionid', $questionid, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    header('Location: my_post.php');
    exit();
}

if (isset($_GET['id'])) {
    $questionid = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM question WHERE questionid = :questionid AND user_id = :user_id");
    $stmt->bindValue(':questionid', $questionid, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch();
}
ob_start();
include 'templates/edit_post.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
