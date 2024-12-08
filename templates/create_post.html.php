<div class="mx-auto w-4/5">
    <header class="text-2xl font-sans font-bold pl-2 py-5">Create Post</header>
    <form action="create_post.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="postType" id="postType" value="text">

        <!-- Menu options with buttons to set post type -->
        <div id="menu" class="flex space-x-4 mb-4">
            <button type="button" id="textOption" class="px-4 py-2 border-b-2 border-gray-50 hover:border-blue-500 font-semibold">Text</button>
            <button type="button" id="imageOption" class="px-4 py-2 border-b-2 border-gray-50 hover:border-blue-500 font-semibold">Image</button>
        </div>

        <div class="mt-4">
            <textarea name="questiontitle" rows="2" placeholder="Title" class="w-full p-2 border rounded-2xl resize-none" oninput="autoResize(this)"></textarea>
        </div>

        <div class="mt-4 pl-2">
            <button id="moduleButton" type="button" class="bg-gray-400 text-sm text-white px-4 py-2 rounded-full">
                <i class="fa-solid fa-tag pr-1"></i> <span id="selectedModule">Module</span>
            </button>
            <input type="hidden" name="selectedModuleId" id="selectedModuleId">
        </div>

        <!-- Module Selection -->
        <div id="moduleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md relative">
                <h2 class="text-2xl font-bold mb-4">Select a Module</h2>
                <div id="moduleList" class="space-y-2">
                    <!-- Module options -->
                </div>
                <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
        </div>

        <div id="textTextarea" class="mt-4">
            <textarea name="questiontext" rows="3" placeholder="Question" class="w-full p-2 border rounded-2xl resize-none" oninput="autoResize(this)"></textarea>
        </div>

        <div id="imageTextarea" class="mt-4 hidden">
            <input type="file" name="questionimage" class="w-full p-2 border rounded-2xl">
        </div>

        <?= "<p style='color: red;'>$error</p>";?>

        <div class="flex justify-end space-x-5">
            <?php if ($isLoggedIn && $role == 2): ?>
                <a href="admin/my_post.php" class="bg-red-500 text-white rounded-full px-4 py-2 mt-4">Cancel</a>
            <?php else:?>
                <a href="my_post.php" class="bg-red-500 text-white rounded-full px-4 py-2 mt-4">Cancel</a>
            <?php endif;?>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded-full px-4 py-2 mt-4">Add</button>
        </div>
    </form>
</div>

<script src="js/create_post.js"></script>
<script src="js/textarea.js"></script>