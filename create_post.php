<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

$error = '';

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
        $uploadedImage = uploadImage($pdo, $_FILES['questionimage'], 'ques_uploads/');
        if (!$uploadedImage) {
            $error = 'Failed to upload the image.';
        }
    }

    if (!$questiontitle || (!$questiontext && $postType !== 'image') || !$selectedModuleId) {
        $error = "Please complete all required fields.";
    } else {
        try {
            insertQuestion($pdo, $user_id, $questiontitle, $questiontext, $uploadedImage, $questionlink, $selectedModuleId);

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
