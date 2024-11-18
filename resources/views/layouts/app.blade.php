<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-roboto">

    <!-- Header -->
    <header class="bg-indigo-600 text-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">{{ config('app.name', 'Laravel') }}</h1>
                </div>
                <div>
                    <!-- Example of a Navbar with links -->
                    <nav>
                        <ul class="flex space-x-4">
                            <li><a href="{{ route('home') }}" class="hover:text-indigo-200">Home</a></li>
                            <li><a href="{{ route('profile.create') }}" class="hover:text-indigo-200">Create Profile</a></li>
                            
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
