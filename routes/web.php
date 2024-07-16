<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




// Middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/', [JurnalController::class, 'index']);
    Route::get('/ringkasan', [JurnalController::class, 'ringkasan']);
    Route::resource('jurnals', JurnalController::class);
    Route::get('/jurnals/detail/{tahun}/{bulan}', [JurnalController::class, 'detail'])->name('jurnals.detail');


    // Controller dan Route dari Jurnals
    Route::put('/jurnals/{jurnal}', [JurnalController::class, 'update'])->name('jurnals.update');
    Route::delete('/jurnals/{tahun}/{bulan}', [JurnalController::class, 'destroyByMonth'])->name('jurnals.destroyByMonth');


    // Controller dan Route dari User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});






// Controller dan Route dari Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



//Controller dan Route dari Register
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
