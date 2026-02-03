<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FollowController;



Route::get('/', function () {
    return view('home');


});
Route::get('/dashboard', function () {
    return redirect()->route('posts.index');
})->middleware(['auth'])->name('dashboard');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

Route::middleware('auth')->get('/home', function () {
    return view('posts.index');
})->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/home', [PostController::class, 'index'])->name('home');
});

Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');

Route::middleware('auth')->get('/usuarios/{user}', [UserController::class, 'show'])
    ->name('users.show');

Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');



Route::get('/notificaciones', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notificaciones/marcar-todo', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');


Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show')->middleware('auth');
    Route::post('/usuarios/{user}/follow', [FollowController::class, 'follow'])->name('users.follow');
    Route::delete('/usuarios/{user}/follow', [FollowController::class, 'unfollow'])->name('users.unfollow');

    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
});
require __DIR__.'/auth.php';
