<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CommentController;

// Trang chủ
Route::get('/', [MovieController::class, 'index'])->name('movies.index');

// Movie routes
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.detail');
Route::middleware(['auth'])->group(function () {
    Route::get('/movies/{id}/watch', [MovieController::class, 'watch'])
        ->name('movies.watch');
});
Route::get('/search', [MovieController::class, 'search'])->name('movies.search');

// Subscription routes
Route::get('/subscription/plans', [SubscriptionController::class, 'plans'])->name('subscription.plans');

// Auth routes
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User routes
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/favorites', [UserController::class, 'favorites'])->name('favorites');

    // Subscription routes
    Route::get('/subscription/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('/subscription/process', [SubscriptionController::class, 'processPayment'])->name('subscription.process');

    // Comment routes
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Admin routes
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/movies', [AdminController::class, 'movies'])->name('admin.movies');
    Route::get('/admin/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');
    Route::get('/create-admin', [AuthController::class, 'createAdmin'])->name('create.admin');
});

// Public routes
Route::get('/about', [UserController::class, 'about'])->name('about');

Route::get('/vip/packages', function () {
    return view('vip.packages');
})->name('vip.packages');
