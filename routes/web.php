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

    Route::get('/', [DashboardController::class, 'index'])
        ->name('index');


    // Posts
    Route::prefix('posts')
        ->name('posts.')
        ->middleware('can:posts')
        ->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('index');
            Route::get('/add', [PostController::class, 'add'])->name('add');
            Route::post('/add', [PostController::class, 'postAdd']);
            Route::get('/edit/{post}', [PostController::class, 'edit'])->name('edit');
            Route::post('/edit/update', [PostController::class, 'postEdit'])->name('post-edit');
            Route::get('/delete/{post}', [PostController::class, 'delete'])->name('delete');
        });


    // Groups
    Route::prefix('groups')
        ->name('groups.')
        ->middleware('can:groups')
        ->group(function () {
            Route::get('/', [GroupController::class, 'index'])->name('index');
            Route::get('/add', [GroupController::class, 'add'])->name('add');
            Route::post('/add', [GroupController::class, 'postAdd']);
            Route::get('/edit/{group}', [GroupController::class, 'edit'])->name('edit');
            Route::post('/edit/update', [GroupController::class, 'postEdit'])->name('group-edit');
            Route::get('/delete/{group}', [GroupController::class, 'delete'])->name('delete');
            Route::get('/permission/{group}', [GroupController::class, 'permission'])->name('permission');
            Route::post('/permission/{group}', [GroupController::class, 'postPermission']);
        });

    // Users
    Route::prefix('users')
        ->name('users.')
        ->middleware('can:users') // này dùng cho nguyên cái route còn xài ->can('users') thì cho từng route lẻ
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/add', [UserController::class, 'add'])->name('add');
            Route::post('/add', [UserController::class, 'postAdd']);
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('/edit/update', [UserController::class, 'postEdit'])->name('user-edit');
            Route::get('/delete/{user}', [UserController::class, 'delete'])->name('delete');
        });

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('auth.login');
    })->name('logout');
});