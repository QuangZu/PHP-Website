<?php
session_start();
include 'includes/database_connection.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$questionId = $_GET['id'] ?? null;
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';
$error = '';

$sql = 'SELECT q.questionid, u.username, u.image, q.questiontitle, q.questiontext, q.questionimage, 
               q.questionlink, q.questiondate, q.number_like, q.number_comment
        FROM question q
        LEFT JOIN user u ON q.user_id = u.user_id
        LEFT JOIN module m ON q.module_id = m.module_id
        WHERE q.questionid = ?
        ORDER BY q.questiondate DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute([$questionId]);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitComment']) && $isLoggedIn) {
    $commentText = $_POST['comment'];
    $userId = $_SESSION['user_id'];
    $questionId = $_POST['questionid'];

    try {
        $stmt = $pdo->prepare('INSERT INTO comment (questionid, commenttext, user_id, username, commentdate) VALUES (?, ?, ?, ?, NOW())');
        $stmt->execute([$questionId, $commentText, $userId, $_SESSION['username']]);
        $pdo->prepare("UPDATE question SET number_comment = number_comment + 1 WHERE questionid = ?")->execute([$questionId]);

        header("Location: question.php?id=$questionId");
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle like button
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['like']) && $isLoggedIn) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM question_likes WHERE user_id = ? AND questionid = ?');
    $stmt->execute([$user_id, $questionId]);
    $alreadyLiked = $stmt->fetchColumn();

    if (!$alreadyLiked) {
        $stmt = $pdo->prepare('INSERT INTO question_likes (user_id, questionid) VALUES (?, ?)');
        $stmt->execute([$user_id, $questionId]);
        $pdo->prepare("UPDATE question SET number_like = number_like + 1 WHERE questionid = ?")->execute([$questionId]);
    }

    header("Location: question.php?id=$questionId");
    exit;
}

// Handle comment deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteComment']) && $isLoggedIn) {
    $commentId = $_POST['comment_id'];
    
    // Fetch the comment to check ownership
    $stmt = $pdo->prepare('SELECT user_id FROM comment WHERE commentid = ?');
    $stmt->execute([$commentId]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    // If the logged-in user is the owner of the comment, delete it
    if ($comment && $comment['user_id'] == $user_id) {
        $stmt = $pdo->prepare('DELETE FROM comment WHERE commentid = ?');
        $stmt->execute([$commentId]);
        
        // Decrement the comment count in the question table
        $pdo->prepare("UPDATE question SET number_comment = number_comment - 1 WHERE questionid = ?")->execute([$questionId]);
        
        // Redirect to the same question page to refresh comments
        header("Location: question.php?id=$questionId");
        exit;
    } else {
        $error = "You are not authorized to delete this comment.";
    }
}

// Handle comment edit request (initialize edit mode)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editComment']) && $isLoggedIn) {
    $commentId = $_POST['comment_id'];
    
    // Verify ownership and set edit mode
    $stmt = $pdo->prepare('SELECT user_id FROM comment WHERE commentid = ?');
    $stmt->execute([$commentId]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comment && $comment['user_id'] == $user_id) {
        $_POST['editComment'] = true;
    } else {
        $error = "You are not authorized to edit this comment.";
    }
}

// Handle saving an edited comment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['saveComment']) && $isLoggedIn) {
    $commentId = $_POST['comment_id'];
    $updatedCommentText = $_POST['updatedCommentText'];

    $stmt = $pdo->prepare('SELECT user_id FROM comment WHERE commentid = ?');
    $stmt->execute([$commentId]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comment && $comment['user_id'] == $user_id) {
        $stmt = $pdo->prepare('UPDATE comment SET commenttext = ? WHERE commentid = ?');
        $stmt->execute([$updatedCommentText, $commentId]);
        header("Location: question.php?id=$questionId");
        exit;
    } else {
        $error = "You are not authorized to edit this comment.";
    }
}

// Handle comment deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteComment']) && $isLoggedIn) {
    $commentId = $_POST['comment_id'];

    $stmt = $pdo->prepare('SELECT user_id FROM comment WHERE commentid = ?');
    $stmt->execute([$commentId]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comment && $comment['user_id'] == $user_id) {
        $stmt = $pdo->prepare('DELETE FROM comment WHERE commentid = ?');
        $stmt->execute([$commentId]);
        header("Location: question.php?id=$questionId");
        exit;
    } else {
        $error = "You are not authorized to delete this comment.";
    }
}

// Handle cancel edit action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancelEdit'])) {
    // Redirect back to the question page to cancel edit mode
    header("Location: question.php?id=$questionId");
    exit;
}

// Fetch comments with user image from the `user` table
$stmt = $pdo->prepare('
    SELECT c.*, u.image
    FROM comment c
    LEFT JOIN user u ON c.user_id = u.user_id
    WHERE c.questionid = ?
    ORDER BY c.commentdate ASC
');
$stmt->execute([$questionId]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$title = htmlspecialchars($question['questiontitle']);
ob_start();
include 'templates/question.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
