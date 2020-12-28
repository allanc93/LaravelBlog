<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// All posts on one page
// Route::get('/posts', [PostController::class, 'index']);
// As above, but using a named route
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Storing a new post
Route::post('/posts', [PostController::class, 'store'])->middleware('auth');

// Create post
// PRECEDENCE MATTERS! Use create before the wildcard
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth');

// Show an individual post
Route::get('/posts/{post}', [PostController::class, 'show']);

// Edit a post
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('auth');

// Update a post
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth');

// Delete a post
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth');
