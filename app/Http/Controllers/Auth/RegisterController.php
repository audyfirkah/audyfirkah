<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // menampilkan halaman penambahan anggota
    public function showRegistrationForm()
    {
        return view('auth.register');
    }



    // validasi dan proses pembuatan anggota
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:4|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/dashboard')->with('success', 'Registration successful. Please login.');
    }
}
