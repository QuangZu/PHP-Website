<div class="pl-8">
    <button onclick="history.back()" class="absolute inline-flex items-center justify-center p-2 bg-indigo-500 rounded-full shadow-lg">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l7-7m0 14l-7-7m0 0h14"></path>
        </svg>
    </button>
</div>
<div class="flex flex-col px-32 space-y-5">
    <!-- Question Details -->
    <div class="inline-flex space-x-3">
        <span class="inline-flex items-center justify-center p-1 bg-white rounded-full shadow-md h-10 w-10 scale-150">
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
        <span class="pl-2 ml-2 pt-1.5 text-lg text-slate-900 dark:text-white font-medium">
            <?= htmlspecialchars($question['username']) ?>
        </span>
    </div>
    <h2 class="text-2xl font-bold"><?= htmlspecialchars($question['questiontitle']) ?></h2>
    <?php if (!empty($question['questiontext'])): ?>
        <p class="mt-2"><?= htmlspecialchars($question['questiontext']) ?></p>
    <?php elseif (!empty($question['questionimage'])): ?>
        <img src="ques_uploads/<?= htmlspecialchars($question['questionimage']) ?>" alt="Question Image" class="mt-2 w-full h-auto">
    <?php endif; ?>
    
    <!-- Reaction Counts -->
    <form method="POST">
        <div class="mt-4 ml-12 flex space-x-8 items-center scale-110">
            <form method="POST">
                <button type="submit" name="like" class="flex items-center space-x-1 text-red-500">
                    <i class="fa-solid fa-heart"></i>
                    <span><?= htmlspecialchars($question['number_like']) ?> Likes</span>
                </button>
            </form>
            <div class="flex items-center space-x-1 text-blue-500">
                <i class="fa-solid fa-comment"></i>
                <span><?= htmlspecialchars($question['number_comment']) ?> Answers</span>
            </div>
            <button type="submit" name="save" class="flex items-center space-x-1 text-yellow-500">
                <i class="fa-solid fa-bookmark"></i>
                <span><?= htmlspecialchars($question['number_save']) ?> Save</span>
            </button>
        </form>
    </div>
    <p class="text-sm text-gray-500">Posted by <?= htmlspecialchars($question['username']) ?> on <?= htmlspecialchars($question['questiondate']) ?></p>
    <h3 class="text-lg font-bold">Answers</h3>
    <!-- Add Comment Form -->
    <?php if ($isLoggedIn): ?>
        <form method="POST" class="mt-4 w-full">
            <div id="commentSection">
                <textarea id="commentTextarea" name="comment" rows="1" placeholder="Add a comment" class="w-full p-2 border rounded-2xl resize-none overflow-hidden" oninput="autoResize(this)"></textarea>
                <input type="hidden" name="questionid" value="<?= $question['questionid'] ?>">
                <div class="flex justify-end">
                    <button id="postButton" type="submit" name="submitComment" class="absolute mt-2 px-4 py-2 bg-blue-500 text-white rounded-full hidden">Answer</button>
                </div>
            </div>
            <script src="js/question.js"></script>
            <script src="js/textarea.js"></script>
        </form>
    <?php else: ?>
        <p class="text-gray-500 mt-4">Please <a href="login.php" class="text-blue-500">log in</a> to post a answers.</p>
    <?php endif; ?>

    <!-- Comments Section -->
    <div class="w-full">
        <ul class="mt-5">
            <?php foreach ($comments as $comment): ?>
                <li class="relative py-5 border-b-2 border-gray-100">
                    <div class="inline-flex space-x-2">
                        <?php if (!empty($comment['image'])): ?>
                            <img src="avatar_uploads/<?= htmlspecialchars($comment['image']) ?>" alt="Profile Image" class="w-6 h-6 rounded-full object-cover">
                        <?php else: ?>
                            <span class="p-1">
                                <svg class="h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.062 12.062 0 0112 15.5c2.99 0 5.74 1.1 7.879 2.804m-7.879-6.35a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                            </span>
                        <?php endif; ?>
                        <p><strong><?= htmlspecialchars($comment['username']) ?></strong></p>
                    </div>

                    <?php if ($isLoggedIn && $comment['user_id'] == $user_id && isset($_POST['editComment']) && $_POST['comment_id'] == $comment['commentid']): ?>
                        <!-- Edit Comment Form -->
                        <form method="POST" action="question.php?id=<?= $questionId ?>" class="mt-2">
                            <textarea name="updatedComment" rows="2" class="w-full p-2 border rounded-lg resize-none"><?= htmlspecialchars($comment['commenttext']) ?></textarea>
                            <input type="hidden" name="comment_id" value="<?= $comment['commentid'] ?>">
                            <div class="flex justify-end">
                                <button type="submit" name="cancelEdit" class="bg-gray-500 text-white rounded-full py-2 px-4 mr-4 mt-2">Cancel</button>
                                <button type="submit" name="saveComment" class="bg-green-500 text-white rounded-full py-2 px-4 mt-2">Save</button>
                            </div>
                        </form>
                        <script src="js/textarea.js"></script>
                    <?php else: ?>
                        <p class="pl-3"><?= htmlspecialchars($comment['commenttext']) ?></p>
                        <p class="text-slate-400 dark:text-slate-500 mt-2 pl-2 text-xs"><?= htmlspecialchars($comment['commentdate']) ?></p>
                    <?php endif; ?>

                    <!-- Options Dropdown (Edit/Delete) -->
                    <?php if ($isLoggedIn && $comment['user_id'] == $user_id && $role == 2): ?>
                        <div class="absolute top-0 right-0 m-4">
                            <button id="optionsButton-<?= $comment['commentid'] ?>" class="text-gray-600 text-2xl font-bold pr-2 focus:outline-none">&#8230;</button>
                            <div id="optionsMenu-<?= $comment['commentid'] ?>" class="absolute right-0 mt-2 w-28 bg-white rounded-md shadow-lg hidden">
                                <form method="POST" action="question.php?id=<?= $questionId ?>" class="w-full">
                                    <input type="hidden" name="comment_id" value="<?= $comment['commentid'] ?>">
                                    <button type="submit" name="editComment" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fa-solid fa-pen pr-2"></i> Edit
                                    </button>
                                </form>
                                <form method="POST" action="question.php?id=<?= $questionId ?>" class="w-full">
                                    <input type="hidden" name="comment_id" value="<?= $comment['commentid'] ?>">
                                    <button type="submit" name="deleteComment" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <i class="fa-solid fa-trash pr-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </li>
                <script src="js/comment.js"></script>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php if ($error): ?>
        <p class="bg-red-100 text-red-700 p-4 rounded-lg"><?= $error ?></p>
    <?php endif; ?>
</div>  
