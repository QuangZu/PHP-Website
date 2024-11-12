<?php
session_start();
include 'includes/database_connection.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';
$error = '';

if ($isLoggedIn && $user_id) {
    $stmt = $pdo->prepare("
        SELECT q.*, u.username 
        FROM question q
        JOIN user u ON q.user_id = u.user_id
        WHERE q.user_id = :user_id
        ORDER BY q.questiondate DESC
    ");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $userPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questiontitle = $_POST['questiontitle'] ?? '';
    $questiontext = $_POST['questiontext'] ?? '';
    $selectedModuleId = $_POST['selectedModuleId'] ?? null;
    $postType = $_POST['postType'] ?? 'text';
    $uploadedImage = null;

    if ($postType === 'link') {
        $questionlink = $questiontext;
    }

    if ($postType === 'image' && isset($_FILES['questionimage']) && $_FILES['questionimage']['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'ques_uploads/';
        $imageName = basename($_FILES['questionimage']['name']);
        $targetFilePath = $targetDir . time() . '_' . $imageName;

        if (move_uploaded_file($_FILES['questionimage']['tmp_name'], $targetFilePath)) {
            $uploadedImage = $targetFilePath;
        } else {
            $error = 'Failed to upload the image.';
        }
    }

    if (!$questiontitle || (!$questiontext && $postType !== 'image') || !$selectedModuleId) {
        $error = "Please complete all required fields.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO question (questiontitle, questiontext, user_id, questiondate, module_id, questionimage, questionlink) 
                                   VALUES (:questiontitle, :questiontext, :user_id, CURDATE(), :module_id, :questionimage, :questionlink)");

            $stmt->bindValue(':questiontitle', $questiontitle);
            $stmt->bindValue(':questiontext', $questiontext);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':module_id', $selectedModuleId, PDO::PARAM_INT);
            $stmt->bindValue(':questionimage', $uploadedImage);
            $stmt->bindValue(':questionlink', $questionlink);
            $stmt->execute();

            header('Location: questions.php');
            exit();
        } catch (PDOException $e) {
            $error = "An error occurred: " . $e->getMessage();
        }
    }
}

ob_start();
include 'templates/create_post.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
