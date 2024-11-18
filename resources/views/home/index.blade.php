<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Video Chat App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- If you're using Vite for assets -->
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 min-h-screen flex items-center justify-center text-white">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to Our Video Chat App</h1>
        <p class="text-xl mb-6">Connect with new people through video calls and live chat.</p>
        
        <!-- Link to start connecting with random users or customize profile -->
        <div class="flex justify-center space-x-6">
            <a href="{{ route('profile.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Set Up Your Profile
            </a>
            <a href="{{ route('search') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                Find a Random User
            </a>
        </div>
    </div>
</body>
</html>
