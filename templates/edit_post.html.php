<div class="pl-8">
    <a href="my_post.php" class="absolute inline-flex items-center justify-center p-2 bg-indigo-500 rounded-full shadow-lg">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l7-7m0 14l-7-7m0 0h14"></path>
        </svg>
    </a>
</div>
<div class="mx-auto w-4/5">
    <header class="text-2xl font-sans font-bold pl-2 py-5">Edit Post</header>
    <form action="edit_post.php" method="post">
        <input type="hidden" name="questionid" value="<?= $post['questionid'] ?>">
        <textarea name="questiontitle" rows="2" class="w-full p-2 border rounded-2xl resize-none" oninput="autoResize(this)"><?= htmlspecialchars($post['questiontitle']) ?></textarea>
        <textarea name="questiontext" rows="3" class="w-full p-2 border rounded-2xl mt-4 resize-none" oninput="autoResize(this)"><?= htmlspecialchars($post['questiontext']) ?></textarea>
        <div class="flex justify-end space-x-5">
            <a href="my_post.php" class="bg-red-500 text-white rounded-full px-4 py-2 mt-4">Cancel</a>
        </div>
    </form>
    <script src="js/textarea.js"></script>
</div>
