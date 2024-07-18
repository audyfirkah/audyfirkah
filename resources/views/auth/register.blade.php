<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-200 flex items-center justify-center h-screen">
   <div class="flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md w-full sm:w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Pendaftaran</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
    
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" autocomplete="username" autofocus
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-400 focus:border-orange-400 sm:text-sm">
                @error('username')
                    <div class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" autofocus
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-400 focus:border-orange-400 sm:text-sm">
                @error('name')
                    <div class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-400 focus:border-orange-400 sm:text-sm">
                @error('email')
                    <div class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" autocomplete="new-password"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-400 focus:border-orange-400 sm:text-sm">
                @error('password')
                    <div class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="mb-4">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" autocomplete="new-password"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-400 focus:border-orange-400 sm:text-sm">
                @error('password_confirmation')
                    <div class="text-red-500 text-xs mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
    
            <div class="flex justify-center">
                <button type="submit" class="bg-orange-400 text-white py-2 px-4 rounded hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2">
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>