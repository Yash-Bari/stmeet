<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RandomMeet - Video Chat</title>
    @vite('resources/css/app.css')
    <!-- Include Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 min-h-screen font-[Inter]">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="w-full py-6 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="h-10 w-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-indigo-500 to-purple-500 text-transparent bg-clip-text">RandomMeet</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Active Users: 1,234</span>
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-green-400 animate-pulse"></div>
                        <div class="w-8 h-8 rounded-full bg-blue-400 animate-pulse delay-100"></div>
                        <div class="w-8 h-8 rounded-full bg-purple-400 animate-pulse delay-200"></div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center px-4 py-12">
            <div class="max-w-4xl w-full grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column - Info -->
                <div class="space-y-8 lg:pr-8">
                    <div class="space-y-4">
                        <h1 class="text-4xl font-bold text-gray-900">Meet New People <br/>Around the World</h1>
                        <p class="text-lg text-gray-600">Connect instantly with people who share your interests. No registration required!</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-indigo-500">1M+</div>
                            <div class="text-gray-600">Daily Chats</div>
                        </div>
                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-purple-500">190+</div>
                            <div class="text-gray-600">Countries</div>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">How it works</h3>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 text-indigo-500 flex items-center justify-center font-semibold">1</div>
                                <p class="text-gray-600">Set your preferences and interests</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-purple-100 text-purple-500 flex items-center justify-center font-semibold">2</div>
                                <p class="text-gray-600">Get matched with compatible people</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-semibold">3</div>
                                <p class="text-gray-600">Start video chatting instantly</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Form -->
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8">
                    <form action="{{ route('start') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">Start Meeting People</h2>
                            <p class="text-gray-600 mt-1">Fill in your preferences to begin</p>
                        </div>
                        
                        <!-- Basic Info Section -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Your Age</label>
                                <input type="number" name="age" min="13" max="100" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Your Gender</label>
                                <select name="gender" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50">
                                    <option value="" disabled selected>Select your gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Your Interests</label>
                                <div class="mt-2 grid grid-cols-2 gap-2">
                                    <label class="relative flex items-center justify-center p-4 border rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors">
                                        <input type="checkbox" name="interests[]" value="music" class="absolute opacity-0">
                                        <span class="text-sm">🎵 Music</span>
                                    </label>
                                    <label class="relative flex items-center justify-center p-4 border rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors">
                                        <input type="checkbox" name="interests[]" value="movies" class="absolute opacity-0">
                                        <span class="text-sm">🎬 Movies</span>
                                    </label>
                                    <label class="relative flex items-center justify-center p-4 border rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors">
                                        <input type="checkbox" name="interests[]" value="gaming" class="absolute opacity-0">
                                        <span class="text-sm">🎮 Gaming</span>
                                    </label>
                                    <label class="relative flex items-center justify-center p-4 border rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors">
                                        <input type="checkbox" name="interests[]" value="sports" class="absolute opacity-0">
                                        <span class="text-sm">⚽ Sports</span>
                                    </label>
                                    <label class="relative flex items-center justify-center p-4 border rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors">
                                        <input type="checkbox" name="interests[]" value="technology" class="absolute opacity-0">
                                        <span class="text-sm">💻 Tech</span>
                                    </label>
                                    <label class="relative flex items-center justify-center p-4 border rounded-lg cursor-pointer hover:bg-indigo-50 transition-colors">
                                        <input type="checkbox" name="interests[]" value="art" class="absolute opacity-0">
                                        <span class="text-sm">🎨 Art</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Match Preferences Section -->
                        <div class="space-y-4 pt-6 border-t">
                            <h3 class="text-lg font-medium text-gray-900">Match Preferences</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Preferred Gender</label>
                                <select name="preferred_gender" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50">
                                    <option value="any">Any</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Min Age</label>
                                    <input type="number" name="preferred_age_min" min="13" max="100" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Max Age</label>
                                    <input type="number" name="preferred_age_max" min="13" max="100" required
                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50">
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                            Start Video Chat
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full py-6 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between">
                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                    <p class="text-sm text-gray-600">© 2024 RandomMeet. All rights reserved.</p>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Terms</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Privacy</a>
                    <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Guidelines</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Custom styles for checkbox interactions -->
    <style>
        input[type="checkbox"]:checked + span {
            @apply bg-indigo-500 text-white border-indigo-500;
        }
        .interest-label:has(input:checked) {
            @apply border-indigo-500 bg-indigo-50;
        }
    </style>

    @vite('resources/js/app.js')
</body>
</html>