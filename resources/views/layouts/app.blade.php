<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal PKL</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-gray-900 to-gray-700 p-4 text-white flex justify-between items-center shadow-lg">
        <div class="flex space-x-4">
            <a href="{{ url('/') }}" class="hover:text-yellow-400 ml-10 transition duration-75 ease-in-out transform hover:scale-105 hover:border-b-2 hover:border-yellow-500">Home</a>
            <a href="{{ route('jurnals.create') }}" class="hover:text-yellow-400 transition duration-75 ease-in-out transform hover:scale-105 hover:border-b-2 hover:border-yellow-500">Tambah Data</a>
            <a href="{{ url('/ringkasan') }}" class="hover:text-yellow-400 transition duration-75 ease-in-out transform hover:scale-105 hover:border-b-2 hover:border-yellow-500">Ringkasan</a>
            @if (auth()->user() && auth()->user()->isAdmin())
                <a href="{{ url('/users') }}" class="hover:text-yellow-400 transition duration-75 ease-in-out transform hover:scale-105 hover:border-b-2 hover:border-yellow-500">Anggota</a>
            @endif
        </div>
        <div class="flex items-center space-x-4">
            @auth
            <div class="relative">
                <button class="flex items-center text-sm font-medium text-white focus:outline-none mr-10">
                    <span class="ml-2">Welcome, {{ auth()->user()->name }}</span>
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
            @else
            <a href="{{ url('/login') }}" class="hover:text-yellow-400 transition duration-75 ease-in-out transform hover:scale-105 hover:border-b-2 hover:border-yellow-500">Login</a>
            @endauth
        </div>
    </nav>
    <div class="container mx-auto mt-4 px-4">
        @yield('content')
    </div>
    
    <script>
        // JavaScript to toggle the visibility of the logout dropdown
        document.addEventListener('click', function(event) {
            var profileDropdown = document.querySelector('.relative');
            if (event.target.closest('.relative') !== profileDropdown) {
                var dropdown = profileDropdown.querySelector('.absolute');
                if (dropdown.classList.contains('hidden') === false) {
                    dropdown.classList.add('hidden');
                }
            } else {
                var dropdown = profileDropdown.querySelector('.absolute');
                dropdown.classList.toggle('hidden');
            }
        });
    </script>
</body>
</html>
