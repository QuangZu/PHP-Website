<header class="text-2xl font-sans font-bold pl-2 py-5 mx-auto w-4/5">Users</header>
<div class="flex flex-col space-y-8 w-4/5 mx-auto">
    <?php foreach ($users as $user): ?>
        <div class="relative transform hover:scale-105 transition-transform duration-300 bg-white dark:bg-slate-800 px-6 py-8 text-xl text-blue-400 ring-1 ring-slate-900/5 shadow-xl border-l-8 border-white hover:border-blue-400 inline-flex">
                <?php if (!empty($user['image'])): ?>
                    <img src="<?= htmlspecialchars($user['image']) ?>" class="w-24 h-24 rounded-full object-cover ml-2">
                <?php else: ?>
                    <span class="p-1 ml-2">
                        <svg class="h-24 w-24 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.062 12.062 0 0112 15.5c2.99 0 5.74 1.1 7.879 2.804m-7.879-6.35a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </span>
                <?php endif; ?>
            <div class="flex flex-col ml-10">
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