<div class="pl-8">
    <a href="modules.php" class="absolute inline-flex items-center justify-center p-2 bg-indigo-500 rounded-full shadow-lg">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l7-7m0 14l-7-7m0 0h14"></path>
        </svg>
    </a>
</div>

<div class="flex flex-col space-y-8 w-4/5 mx-auto">
    <div class="flex items-center justify-between">
        <header class="text-2xl font-sans font-bold pl-2 py-5">Modules</header>
        <button onclick="toggleModal('addModule')" class="text-2xl font-sans font-bold bg-indigo-500 text-white rounded-full px-1.5 mr-3 scale-105">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>


    <?php foreach ($modules as $module): ?>
        <div class="bg-white dark:bg-slate-800 px-6 py-8 text-xl text-blue-400 ring-1 ring-slate-900/5 shadow-xl border-l-8 border-white hover:border-blue-400">
            <div class="flex justify-between">
                <div class="flex items-center">
                    <?= htmlspecialchars($module['module_name']) ?>
                </div>
                <div class="px-3">
                    <!-- Add the correct URL with module_id -->
                    <a href="update_module.php?id=<?= htmlspecialchars($module['module_id']) ?>" class="text-black">
                        <i class="fa-solid fa-pen-to-square pr-6"></i>
                    </a>
                    <!-- Delete form -->
                    <form action="edit_module.php" method="POST" style="display:inline;">
                        <input type="hidden" name="module_id" value="<?= htmlspecialchars($module['module_id']) ?>">
                        <button type="submit" name="delete_module" class="text-red-500">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Add Module Modal -->
<div id="addModule" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <h2 class="text-xl font-semibold mb-4">Add Module</h2>
        <form action="edit_module.php" method="POST">
            <label class="block text-sm font-medium">Module Name</label>
            <input type="text" name="module_name" class="mt-1 p-2 bg-gray-100 rounded-md w-full">
            <div class="flex justify-between mt-6">
                <button onclick="toggleModal('addModule')" class="mt-4 px-4 py-2 bg-gray-300 text-black rounded-md">Close</button>
                <button type="submit" name="add_module" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">Add</button>
            </div>
        </form>
    </div>
</div>

<script src="../js/modal.js"></script>