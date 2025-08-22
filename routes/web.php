<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthController;

// Home 
Route::get('/', [ProductController::class, 'index'])->name('home');

// Products 
Route::resource('products', ProductController::class)->except(['show']);

// Categories
Route::resource('categories', CategoryController::class)->except(['show']);

// Invoices
Route::resource('invoices', InvoiceController::class)->middleware('auth');
Route::post('/invoices/add/{product}', [InvoiceController::class, 'add'])
    ->name('invoices.add')
    ->middleware('auth');


// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
