<?php

namespace App\Http\Controllers\Admin;

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\CatalogController;
use App\Http\Controllers\User\InvoiceController;

// ROOT  
// Langsung arahkan pengunjung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// AUTHENTICATION ROUTES
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ADMIN ROUTES (Prefix: /admin, Name: admin.*)
Route::prefix('admin')->name('admin.')->middleware(['auth', IsAdmin::class])->group(function () {
    
    // Admin Dashboard -> name('admin.dashboard')
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Products & Categories
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/invoices/{invoice}', [AdminInvoiceController::class, 'show'])->name('invoices.show');
});

// USER ROUTES (Prefix: /user, Name: user.*)
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
    
    // User Dashboard -> name('user.dashboard')
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
    
    // Catalog 
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
    Route::post('/catalog/add-to-invoice/{product}', [CatalogController::class, 'addToInvoice'])->name('catalog.add');
    
    // Invoices (Faktur & Checkout)
    Route::get('/cart', [InvoiceController::class, 'currentCart'])->name('cart');
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::resource('invoices', InvoiceController::class);
});