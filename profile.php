<?php
session_start();
include 'includes/database_connection.php';

$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$username = $_SESSION['username'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit;
}

// Initialize message variables
$success = '';
$error = '';

// Fetch user information
$sql = "SELECT * FROM user WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch all questions for display in profile
$sql = 'SELECT q.questionid, q.questiontitle, q.questiontext, q.questionimage, q.questionlink, q.questiondate, q.number_like, q.number_comment, m.module_name
        FROM question q
        LEFT JOIN module m ON q.module_id = m.module_id
        WHERE q.user_id = :user_id
        ORDER BY q.questiondate DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch saved questions for the user
$sql = 'SELECT q.questionid, q.questiontitle, q.questiontext, q.questionimage, q.questionlink, q.questiondate, q.number_like, q.number_comment, m.module_name
        FROM question q
        LEFT JOIN module m ON q.module_id = m.module_id
        INNER JOIN question_saves qs ON q.questionid = qs.questionid
        WHERE qs.user_id = :user_id
        ORDER BY q.questiondate DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$savedQuestions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle profile image upload
if (isset($_POST['upload_image'])) {
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "avatar_uploads/";
        $imageName = uniqid() . '-' . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $imageName;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $sql = "UPDATE user SET image = :image WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['image' => $target_file, 'user_id' => $user_id]);
            $_SESSION['image'] = $target_file;
            $user['image'] = $target_file;
            $success = "The image has been uploaded successfully.";
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    } else {
        $error = "No file uploaded or upload error occurred.";
    }
}

// Handle profile name change
if (isset($_POST['change_name'])) {
    $newUsername = trim($_POST['username']);
    if (!empty($newUsername)) {
        $sql = "UPDATE user SET username = :username WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $newUsername, 'user_id' => $user_id]);
        $_SESSION['username'] = $newUsername;
        $user['username'] = $newUsername;
        $success = "Username updated successfully!";
    } else {
        $error = "Username cannot be empty.";
    }
}

// Handle profile email change
if (isset($_POST['change_email'])) {
    $newEmail = trim($_POST['email']);
    if (!empty($newEmail)) {
        $sql = "UPDATE user SET email = :email WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $newEmail, 'user_id' => $user_id]);
        $_SESSION['email'] = $newEmail;
        $user['email'] = $newEmail;
        $success = "Email updated successfully.";
    } else {
        $error = "Email cannot be empty.";
    }
}

// Handle profile password change
if (isset($_POST['change_password'])) {
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);
    if ($newPassword === $confirmPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = :password WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['password' => $hashedPassword, 'user_id' => $user_id]);
        $success = "Password changed successfully.";
    } else {
        $error = "Passwords do not match.";
    }
}

// Handle account deletion
if (isset($_POST['delete_account']) && $isLoggedIn) {
    try {
        // Delete user from the database
        $pdo->beginTransaction();

        // Delete user questions, comments, or other related records if needed
        $stmt = $pdo->prepare('DELETE FROM question WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $user_id]);

        $stmt = $pdo->prepare('DELETE FROM comment WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $user_id]);

        // Delete the user record
        $stmt = $pdo->prepare('DELETE FROM user WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $user_id]);

        $pdo->commit();

        // Destroy session and redirect
        session_destroy();
        header("Location: login.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "There was an error deleting your account: " . $e->getMessage();
    }
}

ob_start();
include 'templates/profile.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';
