<div class="flex flex-col space-y-8 w-4/5 mx-auto">
    <div class="flex items-center justify-between">
        <header class="text-2xl font-sans font-bold pl-2 py-5">Update Modules</header>
    </div>

    <!-- Display success or error messages -->
    <?= $success ? "<p class='text-green-500'>$success</p>" : ''; ?>
    <?= $error ? "<p class='text-red-500'>$error</p>" : ''; ?>

    <!-- Form to update module name -->
    <form action="update_module.php?id=<?= htmlspecialchars($module_id) ?>" method="POST">
        <input type="hidden" name="module_id" value="<?= htmlspecialchars($module_id) ?>">  <!-- Hidden input for module_id -->
        
        <!-- Input field for module name -->
        <label class="block text-sm font-medium">Module Name</label>
        <input type="text" name="module_name" value="<?= htmlspecialchars($currentModuleName) ?>" class="mt-1 p-2 bg-gray-100 rounded-md w-full" />
        
        <!-- Submit button -->
        <button type="submit" name="update_module" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">Change</button>
    </form>
</div>
<?php
if ($success) {
    echo "<p class='text-green-500'>$success</p>";
} else {
    echo "<p class='text-red-500'>$error</p>";
}
?>