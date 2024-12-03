<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

$error = '';

// Fetch question details
$question = getQuestionDetails($pdo, $questionId);

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitComment']) && $isLoggedIn) {
    $commentText = $_POST['comment'];
    if (addComment($pdo, $questionId, $user_id, $username, $commentText)) {
        incrementCommentCount($pdo, $questionId);
        header("Location: question.php?id=$questionId");
        exit;
    } else {
        $error = "Failed to add comment.";
    }
}

// Handle like button toggle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['like']) && $isLoggedIn) {
    toggleLike($pdo, $questionId, $user_id);
    header("Location: question.php?id=$questionId");
    exit;
}

// Handle save button toggle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save']) && $isLoggedIn) {
    toggleSave($pdo, $questionId, $user_id);
    header("Location: question.php?id=$questionId");
    exit;
}

// Handle comment edition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['saveComment']) && $isLoggedIn) {
    $commentId = $_POST['comment_id'];
    $commentText = $_POST['updatedComment'];
    if (updateComment($pdo, $commentId, $commentText)) {
        header("Location: question.php?id=$questionId");
        exit;
    }
}

// Handle comment deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteComment']) && $isLoggedIn) {
    $commentId = $_POST['comment_id'];
    if (deleteComment($pdo, $commentId, $user_id)) {
        decrementCommentCount($pdo, $questionId);
        header("Location: question.php?id=$questionId");
        exit;
    } else {
        $error = "You are not authorized to delete this comment.";
    }
}

// Fetch comments
$comments = getCommentsByQuestion($pdo, $questionId);

ob_start();
include 'templates/question.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';