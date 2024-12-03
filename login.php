<?php
session_start();
$error = '';

try {
    include 'includes/DatabaseConnection.php';
    require_once 'includes/session.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['image'] = $user['image'];
            $_SESSION['logged_in'] = true;

            // Redirect based on role
            if ($user['role'] === '2') {
                header("Location: admin/admin_layout.html.php");
            } else {
                header("Location: questions.php");
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }

    ob_start();
    include 'templates/login.html.php';
    $output = ob_get_clean();
    include 'templates/welcome.html.php';
} catch (PDOException $e) {
    $output = 'Database error: ' . $e->getMessage();
}
?>
