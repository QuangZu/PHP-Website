<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
require_once '../includes/session.php';

$error = '';
$success = '';

// Check if module_id is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $module_id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT module_name FROM module WHERE module_id = :module_id");
        $stmt->bindParam(':module_id', $module_id, PDO::PARAM_INT);
        $stmt->execute();
        $module = $stmt->fetch();

        if ($module) {
            $currentModuleName = $module['module_name'];
        } else {
            $error = "Module not found.";
        }
    } catch (Exception $e) {
        $error = "Error fetching module: " . $e->getMessage();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['update_module'])) {
            $newModuleName = trim($_POST['module_name']);
            if (!empty($newModuleName)) {
                try {
                    updateModuleName($pdo, $module_id, $newModuleName);
                    $success = "Module name updated successfully.";
                    header('Location: edit_module.php');
                    exit;
                } catch (Exception $e) {
                    $error = "Failed to update module: " . $e->getMessage();
                }
            } else {
                $error = "Module name cannot be empty.";
            }
        }
    }
} else {
    $error = "Module ID is missing.";
}

ob_start();
include '../templates/admin_update_module.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
?>
