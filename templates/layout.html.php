<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="tailwind_package/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>ToMe</title>
</head>
<body>
    <!-- Heading -->
    <div class="box-content border-none h-10 w-full p-4 border-4 bg-gradient-to-r from-indigo-600 to-pink-500 flex items-center justify-between fixed top-0 z-10">
        <!-- Left-Icon -->
        <div class="flex items-center space-x-4">
            <a href="questions.php" class="text-white text-2xl font-sans font-bold pl-20">ToMe</a>
        </div>
        <!-- Search Bar -->
        <div class="flex items-center space-x-2 w-1/3 pl-10 relative">
            <span class="absolute left-16 text-gray-400 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <form action="search.php" method="get" class="w-full">
                <input 
                    type="text" name="query" id="search-input" placeholder="Search" 
                    class="w-full py-1.5 pl-10 pr-3 rounded-full focus:outline-none" 
                    onkeypress="if(event.key === 'Enter') { this.form.submit(); event.preventDefault(); }"
                />
            </form>
        </div>

        <!-- Right-Icon -->
        <div class="flex items-center space-x-5 pr-10">
            <?php if (!$isLoggedIn): ?>
                <a href="login.php" class="text-white text-2l font-semibold">Login</a>
                <a href="register.php" class="text-white text-2l font-semibold">Register</a>
            <?php else: ?>
                <a href="logout.php" class="text-white text-2l font-semibold">Logout</a>
                <span class="text-white text-2l font-semibold"><?= htmlspecialchars($username) ?></span>
            <?php endif; ?>

            <!-- User Icon -->
            <a href="profile.php" class="inline-flex items-center justify-center p-1 bg-white rounded-full shadow-md">
            <?php if (!empty($_SESSION['image'])): ?>
                <img src="<?= htmlspecialchars($_SESSION['image']) ?>" alt="Profile Image" class="w-8 h-8 rounded-full object-cover">
            <?php else: ?>
                <span class="p-1">
                    <svg class="h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.062 12.062 0 0112 15.5c2.99 0 5.74 1.1 7.879 2.804m-7.879-6.35a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                </span>
            <?php endif; ?>
            </a>
        </div>
    </div>

    <!-- Main Section -->
    <div class="flex">
        <!-- Sidebar Menu -->
        <div class="box-content w-60 p-2 border-r-2 border-gray-200 fixed top-16 h-full pt-10 ">
            <!-- Home -->
            <a href="index.php" class="transform hover:scale-105 transition-transform duration-300 hover:bg-gray-100 rounded-full w-full h-10 p-5 flex items-center justify-left mx-auto mb-4">
                <div class="text-center ">
                    <i class="fa fa-home pr-2" aria-hidden="true"></i>
                    <span class="text-black text-l font-medium">Home</span>
                </div>
            </a>

            <!-- Module -->
            <a href="modules.php" class="transform hover:scale-105 transition-transform duration-300 hover:bg-gray-100 rounded-full w-full h-10 p-5 flex items-center justify-left mx-auto mb-4">
                <div class="text-center ">
                    <i class="fa-solid fa-book pl-0.5"></i>
                    <span class="text-black text-l font-medium ml-2.5">Module</span>
                </div>
            </a> 
            <?php if ($isLoggedIn && $role == 2): ?>
                <!-- Admin Post -->
                <a href="my_post.php" class="transform hover:scale-105 transition-transform duration-300 hover:bg-gray-100 rounded-full w-full h-10 p-5 flex items-center justify-left mx-auto mb-4">
                    <div class="text-center">
                        <i class="fa-solid fa-message pl-0.5"></i>
                        <span class="text-black text-l font-medium ml-2.5">Post</span>
                    </div>
                </a>

                <!-- Users -->
                <a href="users.php" class="transform hover:scale-105 transition-transform duration-300 hover:bg-gray-100 rounded-full w-full h-10 p-5 flex items-center justify-left mx-auto">
                    <div class="text-center">
                        <i class="fa-solid fa-users pr-2"></i>
                        <span class="text-black text-l font-medium">Users</span>
                    </div>
                </a>
            <?php else: ?>
                <!-- Post -->
                <a href="my_post.php" class="transform hover:scale-105 transition-transform duration-300 hover:bg-gray-100 rounded-full w-full h-10 p-5 flex items-center justify-left mx-auto mb-4">
                    <div class="text-center">
                        <i class="fa-solid fa-message pl-0.5 pr-2"></i>
                        <span class="text-black text-l font-medium ml-0.5">My Post</span>
                    </div>
                </a>
                <!-- Contact -->
                <a href="contact.php" class="transform hover:scale-105 transition-transform duration-300 hover:bg-gray-100 rounded-full w-full h-10 p-5 flex items-center justify-left mx-auto">
                    <div class="text-center">
                        <i class="fa-solid fa-circle-question pl-0.5"></i>
                        <span class="text-black text-l font-medium ml-2">Contact</span>
                    </div>
                </a>
            <?php endif; ?>

        </div>

        <!-- Content Section -->
        <div class="flex-1 bg-gray-50 px-6 py-8 ml-64 mt-16 mx-auto w-2/3 min-h-screen flex flex-col">
            <?= $output ?>
        </div>
    </div>
    <footer class="bg-gray-800 text-white py-6 sticky z-20">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between">
                <div class="w-full md:w-1/3 mb-4">
                    <h5 class="text-lg font-semibold">About Me</h5>
                    <p class="text-sm">
                        I am a developer of this website.
                    </p>
                </div>
                <div class="w-full md:w-1/3 mb-4">
                    <h5 class="text-lg font-semibold">Quick Links</h5>
                    <ul class="text-sm">
                    <li><a href="questions.php" class="hover:text-gray-400">Home</a></li>
                    <li><a href="my_post.php" class="hover:text-gray-400">Post</a></li>
                    <li><a href="contact.php" class="hover:text-gray-400">Contact</a></li>
                    </ul>
                </div>
                <div class="w-full md:w-1/3 mb-4">
                    <h5 class="text-lg font-semibold">Contact Me</h5>
                    <p class="text-sm">Email: quangvmgch230200@gmail.com</p>
                    <p class="text-sm">Phone: (+84) 456-789-012</p>
                </div>
            </div>
            <div class="mt-6 border-t border-gray-700 pt-4 text-center">
                <p class="text-sm">&copy; 2024 ToMe. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>