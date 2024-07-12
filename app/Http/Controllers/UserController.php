<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // menampilkan halaman anggota
    public function index()
    {
        $users = User::where('status', 'user')->get();
        return view('users.index', compact('users'));
    }



    // menampilkan halaman untuk membuat anggota baru
    public function create()
    {
        return view('users.create');
    }



    // untuk validasi dan membuat user baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = new User([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil di tambahkan');
    }



    // untuk menampilkan halaman edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }



    // untuk memvalidasi dan mengupdate data yang akan di edit berdasarkan id
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|min:4|unique:users,username,' . $user->id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil di Ubah');
    }



    // function untuk menghapus anggota (User) berdasarkan id yang di hapus
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil di hapus');
    }
}
