<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
]);

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Posts
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/add', [PostController::class, 'index'])->name('add');
    });

    // Posts
    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('index');
        Route::get('/add', [GroupController::class, 'index'])->name('add');
    });

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/add', [UserController::class, 'index'])->name('add');
    });

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('auth.login');
    })->name('logout');
});