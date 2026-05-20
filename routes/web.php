<?php

use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Products & Categories CRUD (Must login and has admin role)
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::resource('categories', CategoryController::class)->except(['index','show']);
});

// Public Route 
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index','show']);

// Invoices (Must login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('invoices', InvoiceController::class)->middleware('auth');
    Route::post('/invoices/add/{product}', [InvoiceController::class, 'add'])->name('invoices.add');
});


