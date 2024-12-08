<div class="pl-8">
    <button onclick="history.back()" class="absolute inline-flex items-center justify-center p-2 bg-indigo-500 rounded-full shadow-lg">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l7-7m0 14l-7-7m0 0h14"></path>
        </svg>
    </button>
</div>

<header class="text-2xl text-blue-500 font-sans pl-2 py-5 mx-auto w-4/5"><?= htmlspecialchars($moduleName) ?></header>

<div class="flex flex-col space-y-8 w-4/5 mx-auto">
    <?php if (isset($message)): ?>
        <div class="text-red-500"><?= htmlspecialchars($message) ?></div>
    <?php else: ?>
        <?php foreach ($questions as $question): ?>
            <!-- Make the whole question card clickable -->
            <a href="question.php?id=<?= $question['questionid'] ?>" class="bg-white dark:bg-slate-800 rounded-lg px-6 py-8 ring-1 ring-slate-900/5 shadow-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                <div class="flex items-center pb-4">
                    <!-- User Icon -->
                    <span class="inline-flex items-center justify-center p-1 bg-white rounded-full shadow-md h-10 w-10">
                        <?php if (!empty($question['image'])): ?>
                            <img src="avatar_uploads/<?= htmlspecialchars($question['image']) ?>" alt="Profile Image" class="w-8 h-8 rounded-full object-cover">
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

                <h3 class="text-slate-900 dark:text-white mt-3 text-xl font-medium tracking-tight">
                    <?= htmlspecialchars($question['questiontitle']) ?>
                </h3>

                <!-- Display content based on availability -->
                <?php if (!empty($question['questiontext'])): ?>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">
                        <?= htmlspecialchars($question['questiontext']) ?>
                    </p>
                <?php elseif (!empty($question['questionimage'])): ?>
                    <img src="ques_uploads/<?= htmlspecialchars($question['questionimage']) ?>" alt="Question Image" class="mt-2 w-1/3 h-auto">
                <?php endif; ?>

                <p class="text-slate-400 dark:text-slate-500 mt-2 text-xs">
                    Posted on: <?= htmlspecialchars($question['questiondate']) ?>
                </p>

                <!-- Like and Comment Section -->
                <div class="mt-4 ml-12 flex space-x-8 items-center scale-110">
                    <button type="submit" class="flex items-center space-x-1 text-red-500">
                        <i class="fa-solid fa-heart"></i>
                        <span class="like-count"><?= htmlspecialchars($question['number_like']) ?></span>   
                    </button>

                    <button class="flex items-center space-x-1 text-blue-500">
                        <i class="fa-solid fa-comment"></i>
                        <span><?= htmlspecialchars($question['number_comment']) ?></span>
                    </button>

                    <button class="flex items-center space-x-1 text-yellow-500">
                        <i class="fa-solid fa-bookmark"></i>
                        <span><?= htmlspecialchars($question['number_save']) ?></span>
                    </button>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
