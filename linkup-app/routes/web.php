<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes — Mini Réseau Social
|--------------------------------------------------------------------------
*/

// ── Routes publiques (non authentifiées) ──────────────────────────────────
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// ── Routes protégées par notre middleware personnalisé ────────────────────
Route::middleware('auth.check')->group(function () {

    // Feed principal
    Route::get('/', [PostController::class, 'index'])->name('posts.index');

    // CRUD Posts
    Route::post('/posts',              [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit',   [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}',        [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}',     [PostController::class, 'destroy'])->name('posts.destroy');

    // Likes (AJAX)
    Route::post('/posts/{post}/like',  [LikeController::class, 'toggle'])->name('posts.like');
});
