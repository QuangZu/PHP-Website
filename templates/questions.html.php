<header class="text-2xl font-sans font-bold pl-2 py-5 mx-auto w-4/5">Questions</header>
<div class="flex flex-col items-center space-y-5">
    <?php foreach ($questions as $index => $question): 
        if (!$question) {
            echo "Question not found.";
            exit;
        }?>
        <a href="question.php?id=<?= $question['questionid'] ?>" class="w-3/4">
            <div class="bg-white dark:bg-slate-800 rounded-lg px-6 py-8 ring-1 ring-slate-900/5 shadow-xl">
                <div class="flex items-center pb-4">
                    <!-- User Icon -->
                    <span class="inline-flex items-center justify-center p-1 bg-white rounded-full shadow-md">
                        <?php if (!empty($question['image'])): ?>
                            <img src="<?= htmlspecialchars($question['image']) ?>" alt="Profile Image" class="w-8 h-8 rounded-full object-cover">
                        <?php else: ?>
                            <span class="p-1">
                                <svg class="h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.062 12.062 0 0112 15.5c2.99 0 5.74 1.1 7.879 2.804m-7.879-6.35a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                            </span>
                        <?php endif; ?>
                    </span>
                    <span class="ml-2 text-slate-900 dark:text-white font-medium">
                        <?= htmlspecialchars($question['username']) ?>
                    </span>
                </div>

                <div class="inline-flex items-center px-2 pb-1 pt-0.5 text-white bg-orange-300 text-sm rounded-full">
                    <?= htmlspecialchars($question['module_name']) ?>
                </div>

                <h3 class="text-slate-900 dark:text-white mt-3 text-xl font-medium tracking-tight">
                    <?= htmlspecialchars($question['questiontitle']) ?>
                </h3>

                <!-- Display content based on availability -->
                <?php if (!empty($question['questiontext'])): ?>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">
                        <?= htmlspecialchars($question['questiontext']) ?>
                    </p>
                <?php elseif (!empty($question['questionimage'])): ?>
                    <img src="<?= htmlspecialchars($question['questionimage']) ?>" alt="Question Image" class="mt-2 w-full h-auto">
                <?php elseif (!empty($question['questionlink'])): ?>
                    <a href="<?= htmlspecialchars($question['questionlink']) ?>" class="text-blue-500 hover:underline mt-2 block">
                        <?= htmlspecialchars($question['questionlink']) ?>
                    </a>
                <?php endif; ?>

                <p class="text-slate-400 dark:text-slate-500 mt-2 text-xs">
                    Posted on: <?= htmlspecialchars($question['questiondate']) ?>
                </p>

                <!-- Like and Comment Section -->
                <div class="mt-4 flex space-x-4 items-center">
                    <button type="submit" class="flex items-center space-x-1 text-red-500">
                        <i class="fa-solid fa-heart"></i>
                        <span class="like-count"><?= htmlspecialchars($question['number_like']) ?></span>   
                    </button>

                    <button class="flex items-center space-x-1 text-blue-500">
                        <i class="fa-solid fa-comment"></i>
                        <span><?= $question['number_comment'] ?? 0 ?></span>
                    </button>
                </div>
                <script src = "js/questions.js"></script>
            </div>
        </a>
    <?php endforeach; ?>
</div>
