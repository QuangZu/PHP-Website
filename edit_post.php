<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';
$image = $_SESSION['image'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questionid = $_POST['questionid'];
    $questiontitle = trim($_POST['questiontitle']);
    $questiontext = trim($_POST['questiontext'] ?? '');
    $questionimage = trim($_POST['questionimage'] ?? '');
    $questionlink = trim($_POST['questionlink'] ?? '');

    // Handle image upload if a new image is provided
    if (!empty($_FILES['new_image']['name'])) {
        $targetDir = "uploads/";
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

    updateQuestion($pdo, $questionid, $questiontitle, $questiontext, $questionimage, $questionlink, $user_id);
    header('Location: my_post.php');
    exit();
}

if (isset($_GET['id'])) {
    $questionid = $_GET['id'];
    $post = getQuestionById($pdo, $questionid, $user_id);

    if (!$post) {
        header('Location: my_post.php');
        exit();
    }
}

ob_start();
include 'templates/edit_post.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
?>
