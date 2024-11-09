<header class="text-2xl font-sans font-bold pl-2 py-5 mx-auto w-4/5">Modules</header>
<div class="flex flex-col space-y-8 w-4/5 mx-auto">
    <?php foreach ($modules as $moduleName => $questions): ?>
        <a href="php/module_ques.php?module=<?= urlencode($moduleName) ?>">
            <div class="transform hover:scale-105 transition-transform duration-300 bg-white dark:bg-slate-800 px-6 py-8 text-xl text-blue-400 ring-1 ring-slate-900/5 shadow-xl border-l-8 border-white hover:border-blue-400">
                <div class="flex items-center">
                    <?= htmlspecialchars($moduleName) ?>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>
