<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="tailwind_package/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <link rel="stylesheet" href="css/particle.css">
    <title>ToMe</title>
</head>
<div class="box-content border-none h-10 w-full p-4 border-4 bg-gradient-to-r from-indigo-600 to-pink-500 flex items-center justify-between fixed top-0 z-10">
        <!-- Left-Side -->
        <div class="flex items-center space-x-4">
            <a href="questions.php" class="text-white text-2xl font-sans font-bold pl-20">ToMe</a>
        </div>
        <!-- Right-Side -->
        <div class="flex items-center space-x-5 pr-10">
            <a href="login.php" class="text-white text-2l font-semibold">Login</a>
            <a href="register.php" class="text-white text-2l font-semibold">Register</a>
        </div>
    </div>
<body class="relative flex flex-col justify-center items-center h-screen bg-gradient-to-r from-indigo-300 to-pink-300 overflow-hidden">
    <div id="particles-js"></div>
    <div class="text-center pb-14 px-4">
        <div class="font-bold text-white text-5xl sm:text-6xl md:text-8xl glow">Welcome to ToMe</div>
        <div class="font-medium text-gray-100 text-lg sm:text-xl mt-2">Ask & Answer Question Page</div>
    </div>
    <script src="js/particle.js"></script>
</body>
</html>
