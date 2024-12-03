<div class="mx-auto w-4/5">
    <?php if ($isLoggedIn): ?>
        <div class="flex items-center justify-between">
            <header class="text-2xl font-sans font-bold pl-2 py-5">My Posts</header>
            <a href="../create_post.php" class="text-2xl font-sans font-bold bg-indigo-500 text-white rounded-full px-1.5 mr-3 scale-105">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
        
        <!-- My Posts -->
        <?php if (!empty($userPosts)): ?>
            <?php foreach ($userPosts as $post): ?>
                <div class="relative bg-white p-4 rounded-lg shadow-md mt-4">
                    <div class="pl-4 space-y-2">
                        <div class="inline-flex items-center px-2 pb-1 pt-0.5 text-white bg-orange-300 text-sm rounded-full">
                            <p>Module: <?= htmlspecialchars($post['module_name']) ?></p>
                        </div>
                        <h2 class="font-semibold text-xl"><?= htmlspecialchars($post['questiontitle']) ?></h2>
                        <p class="text-gray-700 mt-2"><?= htmlspecialchars($post['questiontext']) ?></p>
                        <div class="mt-4 ml-12 flex space-x-8 items-center scale-110">
                            <button type="submit" class="flex items-center space-x-1 text-red-500">
                                <i class="fa-solid fa-heart"></i>
                                <span class="like-count"><?= htmlspecialchars($post['number_like']) ?></span>   
                            </button>

                            <button class="flex items-center space-x-1 text-blue-500">
                                <i class="fa-solid fa-comment"></i>
                                <span><?= htmlspecialchars($post['number_comment']) ?></span>
                            </button>

                            <button class="flex items-center space-x-1 text-yellow-500">
                                <i class="fa-solid fa-bookmark"></i>
                                <span><?= htmlspecialchars($post['number_save']) ?></span>
                            </button>
                        </div>
                        <div class="text-gray-500 text-sm mt-2">
                            <?= htmlspecialchars($post['questiondate']) ?>
                        </div>
                        <div class="absolute top-0 right-0 m-4">
                            <button id="optionsButton-<?= $post['questionid'] ?>" class="text-gray-600 text-2xl font-bold pr-2 focus:outline-none">&#8230;</button>
                            <div id="optionsMenu-<?= $post['questionid'] ?>" class="absolute right-0 mt-2 w-28 bg-white rounded-md shadow-lg hidden">
                                <button onclick="editPost(<?= $post['questionid'] ?>)" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fa-solid fa-pen pr-2"></i>Edit</button>
                                <button onclick="deletePost(<?= $post['questionid'] ?>)" class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100">
                                <i class="fa-solid fa-trash pr-2"></i>Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">You haven't posted anything yet.</p>
        <?php endif; ?>

        <!-- Other Posts -->
        <header class="text-2xl font-sans font-bold pl-2 py-5">Other Posts</header>
        <?php if (!empty($otherPosts)): ?>
            <?php foreach ($otherPosts as $post): ?>
                <div class="relative bg-white p-4 rounded-lg shadow-md mt-6">
                    <div class="pl-4 space-y-2">
                        <div class="inline-flex items-center px-2 pb-1 pt-0.5 text-white bg-orange-300 text-sm rounded-full">
                            <p>Module: <?= htmlspecialchars($post['module_name']) ?></p>
                        </div>
                        <h2 class="font-semibold text-xl"><?= htmlspecialchars($post['questiontitle']) ?></h2>
                        <p class="text-gray-700 mt-2"><?= htmlspecialchars($post['questiontext']) ?></p>
                        <div class="mt-4 ml-12 flex space-x-8 items-center scale-110">
                            <button type="submit" class="flex items-center space-x-1 text-red-500">
                                <i class="fa-solid fa-heart"></i>
                                <span class="like-count"><?= htmlspecialchars($post['number_like']) ?></span>   
                            </button>

                            <button class="flex items-center space-x-1 text-blue-500">
                                <i class="fa-solid fa-comment"></i>
                                <span><?= htmlspecialchars($post['number_comment']) ?></span>
                            </button>

                            <button class="flex items-center space-x-1 text-yellow-500">
                                <i class="fa-solid fa-bookmark"></i>
                                <span><?= htmlspecialchars($post['number_save']) ?></span>
                            </button>
                        </div>
                        <div class="text-gray-500 text-sm mt-2">
                            <?= htmlspecialchars($post['questiondate']) ?>
                        </div>
                        <div class="absolute top-0 right-0 m-4">
                            <button id="optionsButton-<?= $post['questionid'] ?>" class="text-gray-600 text-2xl font-bold pr-2 focus:outline-none">&#8230;</button>
                            <div id="optionsMenu-<?= $post['questionid'] ?>" class="absolute right-0 mt-2 w-28 bg-white rounded-md shadow-lg hidden">
                                <button onclick="deletePost(<?= $post['questionid'] ?>)" class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100">
                                <i class="fa-solid fa-trash pr-2"></i>Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-500">No other posts available.</p>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-gray-500 mt-4">Please <a href="../login.php" class="text-blue-500">log in</a> to view your posts.</p>
    <?php endif; ?>
</div>
<?php if ($error) {
    echo '<script>alert("'. $error. '")</script>';
}?>

<script src="../js/my_post.js"></script>
