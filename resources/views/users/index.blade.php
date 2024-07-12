<!-- resources/views/users/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    

    <h1 class="text-2xl mb-10 font-bold">Daftar Anggota</h1>
    
    @if(session('success'))
    <div class="bg-green-100 border mb-5 border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 011.415 0l.007.007a1 1 0 010 1.415L11.415 12l4.355 4.355a1 1 0 01-1.415 1.415L10 13.415 5.652 17.77a1 1 0 01-1.415-1.415L8.585 12 4.23 7.652a1 1 0 011.415-1.415L10 10.585l4.348-4.348z"/></svg>
        </span>
    </div>
    @endif
    
    <a href="{{ route('users.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 p-1 mb-3 rounded">Tambah user</a>
    <table class="min-w-full">
        <thead>
            <tr class="text-center bg-gray-100">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Username</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="border-b">
                <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $user->username }}</td>
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2 text-center">
                    <div class="flex justify-center items-center space-x-2">
                        <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus anggota ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
