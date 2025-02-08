<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;

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

/* Route::get('/', function () {
    return view('welcome');
}); */

// Auth::routes();

Route::get('/home', function () {
    if (Auth::check()) {
        return Auth::user()->role_id == 1 ? redirect('/admin/users') : redirect('/tasks');
    }
    return redirect('/login');
})->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::get('tasks/{id}/start-session', [TaskController::class, 'startSession'])->name('tasks.start-session');
    Route::get('tasks/{id}/end-session', [TaskController::class, 'endSession'])->name('tasks.end-session');
    Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::get('/tasks/{id}/history', [TaskController::class, 'getStatusHistory'])->name('tasks.show');
});

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login'); // Home page as login
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
});
