<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
require_once '../includes/session.php';

// Handle GET request to fetch the post
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        header('Location: my_post.php');
        exit();
    }

    $questionid = $_GET['id'];
    $post = getQuestionById($pdo, $questionid, $user_id);

    if (!$post) {
        header('Location: my_post.php');
        exit();
    }
}

// Handle POST request to update the question
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questionid = $_POST['questionid'];
    $questiontitle = trim($_POST['questiontitle']);
    $questiontext = trim($_POST['questiontext'] ?? '');
    $questionimage = trim($_POST['questionimage'] ?? '');

    // Handle image upload if a new image is provided
    if (!empty($_FILES['new_image']['name'])) {
        $targetDir = "../ques_uploads/";
        $targetFile = $targetDir . basename($_FILES['new_image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate the file type
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedExtensions)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }

        // Move the uploaded file
        if (move_uploaded_file($_FILES['new_image']['tmp_name'], $targetFile)) {
            $questionimage = htmlspecialchars(basename($_FILES['new_image']['name']), ENT_QUOTES, 'UTF-8');
        } else {
            die("There was an error uploading the file.");
        }
    }

    // Update the question in the database
    updateQuestion($pdo, $questionid, $questiontitle, $questiontext, $questionimage, $user_id);

    // Redirect after successful update
    header('Location: my_post.php');
    exit();
}

ob_start();
include '../templates/edit_post.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
?>
