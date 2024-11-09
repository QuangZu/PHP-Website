<?php
session_start();
include 'includes/database_connection.php';

if (isset($_GET['id']) && $_SESSION['user_id']) {
    $questionid = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM question WHERE questionid = :questionid AND user_id = :user_id");
    $stmt->bindValue(':questionid', $questionid, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    header('Location: my_post.php');
    exit();
}
?>
