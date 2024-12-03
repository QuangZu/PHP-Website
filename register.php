<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password'])
    ) {
        try {
            include "includes/DatabaseConnection.php";
            
            $username = $_POST['username'];
            $email = $_POST['email'];
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username OR email = :email");
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                if ($existingUser['username'] === $username) {
                    $error = "Username already exists.";
                } elseif ($existingUser['email'] === $email) {
                    $error = "Email already exists.";
                }
            } else {
                $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (:username, :email, :password)");
                $stmt->bindValue(':username', $username);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':password', $passwordHash);
                $stmt->execute();
                
                header('Location: login.php');
                exit();
            }
        } catch (PDOException $e) {
            $error = "An error occurred: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all the required fields.";
    }
}

ob_start();
include 'templates/register.html.php';
$output = ob_get_clean();
include 'templates/welcome.html.php';