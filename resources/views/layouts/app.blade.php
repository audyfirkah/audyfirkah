<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal PKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-900 p-4 text-white flex justify-between items-center">
        <div>
            <a href="{{ url('/') }}" class="ml-20 hover:text-yellow-600 hover:shadow-lg transition duration-300 ease-in-out hover:scale-105">Home</a>
            <a href="{{ route('jurnals.create') }}" class="ml-10 hover:text-yellow-600 hover:shadow-lg transition duration-300 ease-in-out hover:scale-105">Tambah data</a>
            <a href="{{ url('/ringkasan') }}" class="ml-10 hover:text-yellow-600 hover:shadow-lg transition duration-300 ease-in-out hover:scale-105">Ringkasan</a>
            @if (auth()->user() && auth()->user()->isAdmin())
                <a href="{{ url('/users') }}" class="ml-10 hover:text-yellow-600 hover:shadow-lg transition duration-300 ease-in-out hover:scale-105">Anggota</a>
            @endif
        </div>
        <div class="flex items-center">
            @auth
            <div class="relative">
                <button class="flex items-center text-sm font-medium text-white focus:outline-none">
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('path_to_your_profile_photo') }}" alt="Profile Photo">
                    <span class="ml-2">{{ auth()->user()->name }}</span>
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
            <a href="{{ url('/login') }}" class="ml-10 hover:text-yellow-600 hover:shadow-lg transition duration-300 ease-in-out hover:scale-105">Login</a>
            @endauth
        </div>
    </nav>
    <div class="container mx-auto mt-4">
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
