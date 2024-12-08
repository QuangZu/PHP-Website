<?php
session_start();
include '../includes/DatabaseConnection.php';
include '../includes/DatabaseFunctions.php';
require_once '../includes/session.php';

$error = '';
$success = '';

$modules = getAllModules($pdo);
$module = getModule($pdo, $module_id);

// Add Module
if (isset($_POST['add_module'])) {
    $newModuleName = trim($_POST['module_name']);
    if (!empty($newModuleName)) {
        try {
            addModule($pdo, $newModuleName);
            $success = "Module added successfully.";
            $modules = getAllModules($pdo);
        } catch (Exception $e) {
            $error = "Failed to add module: " . $e->getMessage();
        }
    } else {
        $error = "Module name cannot be empty.";
    }
}

// Handling Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_module'])) {
    if (isset($_POST['module_id'])) {
        $module_id = $_POST['module_id'];
        try {
            if (deleteModule($pdo, $module_id)) {
                header("Location: edit_module.php");
                exit;
            } else {
                $error = "Error deleting module.";
            }
        } catch (Exception $e) {
            $error = "Failed to delete module: " . $e->getMessage();
        }
    } else {
        $error = "Module ID missing.";
    }
}

ob_start();
include '../templates/admin_edit_module.html.php';
$output = ob_get_clean();
include '../templates/admin_layout.html.php';
?>
