<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold text-center mb-8">Login</h2>
        <form action="" method="post">
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-left">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-left">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
            </div>
                <div class=" text-red-700 rounded relative mb-4" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
                Login
            </button>
        </form>
        <p class="mt-4 text-sm text-center">
            Don't have an account? <a href="register.php" class="text-blue-500">Register here</a>
        </p>
    </div>
</div>
