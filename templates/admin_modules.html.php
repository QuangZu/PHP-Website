<div class="flex flex-col space-y-8 w-4/5 mx-auto">
    <div class="flex items-center justify-between">
        <header class="text-2xl font-sans font-bold pl-2 py-5">Modules</header>
        <a href="edit_module.php" class="text-2xl font-sans font-bold hover:bg-gray-300 text-white rounded-lg p-1.5 px-2 mr-3 scale-105">
            <i class="fa-solid fa-pen text-black"></i>
        </a>
    </div>
    <?php foreach ($modules as $moduleName => $questions): ?>
        <a href="../module_ques.php?module=<?= urlencode($moduleName) ?>">
            <div class="transform hover:scale-105 transition-transform duration-300 bg-white dark:bg-slate-800 px-6 py-8 text-xl text-blue-400 ring-1 ring-slate-900/5 shadow-xl border-l-8 border-white hover:border-blue-400">
                <div class="flex items-center">
                    <?= htmlspecialchars($moduleName) ?>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>
