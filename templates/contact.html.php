<div class="mx-auto w-4/5">
    <header class="text-2xl font-sans font-bold pl-2 py-5">Contact</header>
    <div class="text-l font-sans font-medium">
        <label for="name">Admin:</label>
        <div class="text-blue-400">Quang</div> <br>
        Email:
        <div class="text-blue-400">minhquangvuxd@gmail.com</div> <br>
        Send via email: <br><br>
    </div>
    <?php if ($isLoggedIn): ?>
        <form action="contact.php" method="post">
            <textarea name="questiontitle" rows="2" cols="40" placeholder="Title"
                    class="w-full p-2 border rounded-2xl resize-none"></textarea>
            <textarea name="questiontext" rows="3" cols="40" placeholder="Body"
                    class="w-full p-2 border rounded-2xl resize-none"></textarea>
            <div class="flex justify-end">
                <input type="submit" name="submit" value="Send" class="bg-red-500 text-white rounded-full mt-4 px-4 py-2">
            </div>
        </form>
    <?php else: ?>
        <a href="login.php" class="text-blue-400 pl-2">Login</a> to send a message.
    <?php endif?>

    <?= htmlspecialchars($success), htmlspecialchars($error) ?>
</div>