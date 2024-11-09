<div class="pl-8">
    <a href="questions.php" class="absolute inline-flex items-center justify-center p-2 bg-indigo-500 rounded-full shadow-lg">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l7-7m0 14l-7-7m0 0h14"></path>
        </svg>
    </a>
</div>
<div class="flex flex-col px-32 space-y-5">
    <!-- Question Details -->
    <div class="inline-flex space-x-3">
        <span class="inline-flex items-center justify-center p-1 bg-white rounded-full shadow-md h-10 w-10 scale-150">
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
        <span class="pl-2 ml-2 pt-1.5 text-lg text-slate-900 dark:text-white font-medium">
            <?= htmlspecialchars($question['username']) ?>
        </span>
    </div>
    <h2 class="text-2xl font-bold"><?= htmlspecialchars($question['questiontitle']) ?></h2>
    <?php if (!empty($question['questiontext'])): ?>
        <p class="mt-2"><?= htmlspecialchars($question['questiontext']) ?></p>
    <?php elseif (!empty($question['questionimage'])): ?>
        <img src="<?= htmlspecialchars($question['questionimage']) ?>" alt="Question Image" class="mt-2 w-full h-auto">
    <?php elseif (!empty($question['questionlink'])): ?>
        <a href="<?= htmlspecialchars($question['questionlink']) ?>" class="text-blue-500 hover:underline mt-2">
            <?= htmlspecialchars($question['questionlink']) ?>
        </a>
    <?php endif; ?>
    
    <!-- Like and Comment Counts -->
    <div class="mt-4 flex space-x-8 items-center">
        <form method="POST">
            <button type="submit" name="like" class="flex items-center space-x-1 text-red-500">
                <i class="fa-solid fa-heart"></i>
                <span><?= htmlspecialchars($question['number_like']) ?> Likes</span>
            </button>
        </form>
        <div class="flex items-center space-x-1 text-blue-500">
            <i class="fa-solid fa-comment"></i>
            <span><?= htmlspecialchars($question['number_comment']) ?> Comments</span>
        </div>
    </div>
    <p class="text-sm text-gray-500">Posted by <?= htmlspecialchars($question['username']) ?> on <?= htmlspecialchars($question['questiondate']) ?></p>
    <h3 class="text-lg font-bold">Answers</h3>
    <!-- Add Comment Form -->
    <?php if ($isLoggedIn): ?>
        <form method="POST" class="mt-4 w-full">
            <div id="commentSection">
                <textarea id="commentTextarea" name="comment" rows="1" placeholder="Add a comment..." class="w-full p-2 border rounded-2xl resize-none overflow-hidden"></textarea>
                <input type="hidden" name="questionid" value="<?= $question['questionid'] ?>">
                <div class="flex justify-end">
                    <button id="postButton" type="submit" name="submitComment" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-full hidden">Comment</button>
                </div>
            </div>
            <script src="js/question.js"></script>
        </form>
    <?php else: ?>
        <p class="text-gray-500 mt-4">Please <a href="login.php" class="text-blue-500">log in</a> to post a comment.</p>
    <?php endif; ?>

    <!-- Comments Section -->
    <div class="w-full">
        <ul class="mt-2">
            <?php foreach ($comments as $comment): ?>
                <li class="mt-4">
                    <p><strong><?= htmlspecialchars($comment['username']) ?></strong></p>
                    <p><?= htmlspecialchars($comment['commenttext']) ?></p>
                    <p class="text-slate-400 dark:text-slate-500 mt-2 text-xs"><?= htmlspecialchars($comment['commentdate']) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?= htmlspecialchars($error)?>
</div>
