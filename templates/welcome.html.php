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
<body class="bg-gradient-to-r from-indigo-300 to-pink-300">
    <div id="particles-js"></div>
    <div class="grid grid-cols-2 h-screen">
        <div class="flex flex-col justify-center text-center pl-10">
            <div class="roboto font-bold text-white text-8xl">Welcome to ToMe</div><br>
            <div class="roboto font-medium text-gray-100 text-xl">Ask & Answer Question Page</div><br>
        </div>
        <div class="flex flex-col justify-center text-center pr-32">
            <?= $output ?>
        </div>
    </div>
    <script src="js/particle.js"></script>
</body>
</html>
