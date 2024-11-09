<header class="text-2xl font-sans font-bold pl-2 py-5 mx-auto w-4/5">Users</header>
<div class="flex flex-col space-y-8 w-4/5 mx-auto">
    <?php foreach ($users as $user): ?>
        <div class="relative transform hover:scale-105 transition-transform duration-300 bg-white dark:bg-slate-800 px-6 py-8 text-xl text-blue-400 ring-1 ring-slate-900/5 shadow-xl border-l-8 border-white hover:border-blue-400">
            <div class="flex flex-col">
                <span><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></span>
                <span><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></span>
                <span><strong>Date Joined:</strong> <?= htmlspecialchars($user['date']) ?></span>
            </div>
            <div class="absolute top-2 right-2 pt-1 pr-1">
                <button onclick="deleteUser(<?= $user['user_id'] ?>)" class="hover:bg-red-600 bg-red-400 text-white rounded-full w-8 h-8">
                    <i class="fa-solid fa-minus"></i>
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= htmlspecialchars($error) ?>

<script src="js/delete_user.js"> </script>