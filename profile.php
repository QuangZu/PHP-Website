<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

if (!$user_id) {
    header("Location: login.php");
    exit;
}

$success = '';
$error = '';

$user = getUser($pdo, $user_id);
$savedQuestions = getUserSavedQuestions($pdo, $user_id);

// Handle profile image
if (isset($_POST['upload_image']) && isset($_FILES['profile_image'])) {
    $stmt = $pdo->prepare("SELECT image FROM user WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $currentImage = $stmt->fetchColumn();

    // Upload new image and update the database
    $newImageName = uploadImage(
        $pdo,
        $_FILES['profile_image'],
        'avatar_uploads/',
        "UPDATE user SET image = :image WHERE user_id = :user_id",
        ['user_id' => $user_id],
        $currentImage
    );

    if ($newImageName) {
        $_SESSION['image'] = $newImageName;
        $user['image'] = $newImageName;
        $success = "The image has been uploaded and updated successfully.";
    } else {
        $error = "Sorry, there was an error uploading your file.";
    }
}

// Handle profile name
if (isset($_POST['change_name'])) {
    $newUsername = trim($_POST['username']);
    if (!empty($newUsername)) {
        updateUserName($pdo, $user_id, $newUsername);
        $_SESSION['username'] = $newUsername;
        $user['username'] = $newUsername;
        $success = "Username updated successfully!";
    } else {
        $error = "Username cannot be empty.";
    }
}

if (isset($_POST['change_email'])) {
    $newEmail = trim($_POST['email']);
    if (!empty($newEmail)) {
        updateUserEmail($pdo, $user_id, $newEmail);
        $_SESSION['email'] = $newEmail;
        $user['email'] = $newEmail;
        $success = "Email updated successfully.";
    } else {
        $error = "Email cannot be empty.";
    }
}

if (isset($_POST['change_password'])) {
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);
    if ($newPassword === $confirmPassword) {
        updateUserPassword($pdo, $user_id, $newPassword);
        $success = "Password changed successfully.";
    } else {
        $error = "Passwords do not match.";
    }
}

if (isset($_POST['delete_account']) && $isLoggedIn) {
    if (deleteUser($pdo, $user_id)) {
        $profileImagePath = !empty($user['image']) ? 'avatar_uploads/' . $user['image'] : null;
        if ($profileImagePath && file_exists($profileImagePath)) {
            unlink($profileImagePath);
        }

        session_destroy();
        header("Location: login.php");
        exit;
    } else {
        $error = "There was an error deleting your account.";
    }
}

ob_start();
include 'templates/profile.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';