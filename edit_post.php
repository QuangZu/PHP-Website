<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Process POST request for updating the post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questionid = $_POST['questionid'];
    $questiontitle = trim($_POST['questiontitle']);
    $questiontext = trim($_POST['questiontext'] ?? '');
    $questionimage = trim($_POST['questionimage'] ?? '');

    // Handle image upload if a new image is provided
    if (!empty($_FILES['new_image']['name'])) {
        $targetDir = "ques_uploads/";
        $targetFile = $targetDir . basename($_FILES['new_image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate the file type
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedExtensions)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }

        // Move the uploaded file
        if (move_uploaded_file($_FILES['new_image']['tmp_name'], $targetFile)) {
            $questionimage = basename($_FILES['new_image']['name']);
        } else {
            die("There was an error uploading the file.");
        }
    }

    // Update the post in the database
    updateQuestion($pdo, $questionid, $questiontitle, $questiontext, $questionimage, $user_id);
    header('Location: my_post.php');
    exit();
}

// Process GET request to render the edit page
if (isset($_GET['id'])) {
    $questionid = $_GET['id'];
    $post = getQuestionById($pdo, $questionid, $user_id);

    if (!$post) {
        header('Location: my_post.php');
        exit();
    }
} else {
    header('Location: my_post.php');
    exit();
}

// Render the edit page
ob_start();
include 'templates/edit_post.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
