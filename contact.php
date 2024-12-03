<?php
session_start();
include 'includes/DatabaseConnection.php';
include 'includes/DatabaseFunctions.php';
require_once 'includes/session.php';

require 'PHPMailer-6.9.2/src/PHPMailer.php';
require 'PHPMailer-6.9.2/src/SMTP.php';
require 'PHPMailer-6.9.2/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $title = $_POST['questiontitle'] ?? '';
    $body = $_POST['questiontext'] ?? '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "<script>alert('Invalid or missing email address.');</script>";
    } else {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'minhquangvuxd@gmail.com';
            $mail->Password = 'vhro nori gxjz ijgy';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($email, $username);
            $mail->addAddress('minhquangvuxd@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = $title;
            $mail->Body    = $body;

            if ($mail->send()) {
                $success = "<script>alert('Email sent successfully!');</script>";
            } else {
                $error = "<script>alert('Email could not be sent.');</script>";
            }
        } catch (Exception $e) {
            $error = "<script>alert('Email error: {$mail->ErrorInfo}');</script>";
        }
    }
}

ob_start();
include 'templates/contact.html.php';
$output = ob_get_clean();
include 'templates/layout.html.php';