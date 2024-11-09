<div class="mx-auto w-4/5">
    <?php if ($isLoggedIn): ?>
        <div class="flex items-center justify-between">
            <header class="text-2xl font-sans font-bold pl-2 py-5">My Post</header>
            <a href="php/create_post.php" class="text-2xl font-sans font-bold bg-indigo-500 text-white rounded-full px-1.5 mr-3 scale-105">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
        <?php if (!empty($userPosts)): ?>
            <?php foreach ($userPosts as $post): ?>
            <div class="relative bg-white p-4 rounded-lg shadow-md mt-4">
                <div class="pl-4 space-y-2">
                    <div class="inline-flex items-center px-2 pb-1 pt-0.5 text-white bg-orange-300 text-sm rounded-full">
                        <?php if (isset($post['module_name'])): ?>
                            <p>Module: <?= htmlspecialchars($post['module_name']) ?></p>
                        <?php endif; ?>
                    </div>
                    <h2 class="font-semibold text-xl"><?= htmlspecialchars($post['questiontitle']) ?></h2>
                    <p class="text-gray-700 mt-2"><?= htmlspecialchars($post['questiontext']) ?></p>
                    <div class="mt-4 flex space-x-8 items-center">
                        <div class="flex items-center space-x-1 text-red-500"> 
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path fill="currentColor" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span><?= htmlspecialchars($post['number_like'] ?? 0) ?> Likes</span>
                        </div>
                        <div class="flex items-center space-x-1 text-blue-500">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path fill="currentColor" d="M12 3C6.48 3 2 6.48 2 11c0 2.08.8 3.97 2.13 5.47l-1.07 3.86c-.28 1 .85 1.86 1.75 1.28l3.61-2.25c.95.32 1.95.49 3.04.49 5.52 0 10-3.48 10-7.99S17.52 3 12 3z"/>
                            </svg>
                            <span><?= htmlspecialchars($post['number_comment'] ?? 0) ?> Comments</span>
                        </div>
                    </div>
                    <div class="text-gray-500 text-sm mt-2">
                        <?= htmlspecialchars($post['questiondate']) ?>
                    </div>
                    <div class="absolute top-0 right-0 m-4">
                        <button id="optionsButton-<?= $post['questionid'] ?>" class="text-gray-600 text-2xl font-bold pr-2 focus:outline-none">&#8230;</button>
                        <div id="optionsMenu-<?= $post['questionid'] ?>" class="absolute right-0 mt-2 w-24 bg-white rounded-md shadow-lg hidden">
                            <button onclick="editPost(<?= $post['questionid'] ?>)" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fa-solid fa-pen pr-1"></i>Edit</button>
                            <button onclick="deletePost(<?= $post['questionid'] ?>)" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fa-solid fa-trash pr-1"></i>Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">You haven't posted anything yet.</p>
        <?php endif; ?>
    <?php else: ?>
        <div class="flex items-center">
            <header class="text-2xl font-sans font-bold pl-2 py-5">My Post</header>
        </div>
            <p class="text-gray-500 mt-4">Please <a href="php/login.php" class="text-blue-500">log in</a> to post question.</p>
    <?php endif; ?>
</div>

<script src="js/my_post.js"></script>
