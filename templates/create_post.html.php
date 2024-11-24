<div class="pl-8">
    <a href="my_post.php" class="absolute inline-flex items-center justify-center p-2 bg-indigo-500 rounded-full shadow-lg">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l7-7m0 14l-7-7m0 0h14"></path>
        </svg>
    </a>
</div>
<div class="mx-auto w-4/5">
    <header class="text-2xl font-sans font-bold pl-2 py-5">Create Post</header>
    <form action="create_post.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="postType" id="postType" value="text">

        <!-- Menu options with buttons to set post type -->
        <div id="menu" class="flex space-x-4 mb-4">
            <button type="button" id="textOption" class="px-4 py-2 border-b-2 border-gray-50 hover:border-blue-500 font-semibold">Text</button>
            <button type="button" id="imageOption" class="px-4 py-2 border-b-2 border-gray-50 hover:border-blue-500 font-semibold">Image</button>
            <button type="button" id="linkOption" class="px-4 py-2 border-b-2 border-gray-50 hover:border-blue-500 font-semibold">Link</button>
        </div>

        <div class="mt-4">
            <textarea name="questiontitle" rows="2" placeholder="Title" class="w-full p-2 border rounded-2xl resize-none"></textarea>
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
            <textarea name="questiontext" rows="3" placeholder="Question" class="w-full p-2 border rounded-2xl resize-none"></textarea>
        </div>

        <div id="imageTextarea" class="mt-4 hidden">
            <input type="file" name="questionimage" class="w-full p-2 border rounded-2xl">
        </div>

        <div id="linkTextarea" class="mt-4 hidden">
            <input type="text" name="questionlink" placeholder="Add a link" class="w-full p-2 border rounded-2xl">
        </div>

        <?= "<p style='color: red;'>$error</p>";?>

        <div class="flex justify-end space-x-5">
            <a href="my_post.php" class="bg-red-500 text-white rounded-full px-4 py-2 mt-4">Cancel</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white rounded-full px-4 py-2 mt-4">Add</button>
        </div>
    </form>
</div>

<script src="js/create_post.js"></script>
