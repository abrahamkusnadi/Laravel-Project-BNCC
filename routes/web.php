<?php

namespace App\Http\Controllers\Admin;

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;

// 📁 Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

// 📁 User Controllers
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\CatalogController;
use App\Http\Controllers\User\InvoiceController;

// ─── 1. ROOT REDIRECT ────────────────────────────────────────
// Langsung arahkan pengunjung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// ─── 2. AUTHENTICATION ROUTES ────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── 3. ADMIN ROUTES (Prefix: /admin, Name: admin.*) ─────────
Route::prefix('admin')->name('admin.')->middleware(['auth', IsAdmin::class])->group(function () {
    
    // Admin Dashboard -> name('admin.dashboard')
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Products & Categories (Full CRUD tanpa except karena sudah dipisah)
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});

// ─── 4. USER ROUTES (Prefix: /user, Name: user.*) ────────────
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
    
    // User Dashboard -> name('user.dashboard')
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
    
    // Catalog (Sebagai pengganti Products Index milik publik)
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
    Route::post('/catalog/add-to-invoice/{product}', [CatalogController::class, 'addToInvoice'])->name('catalog.add');
    
    // Invoices (Faktur & Checkout)
    Route::get('/cart', [InvoiceController::class, 'currentCart'])->name('cart');
    Route::resource('invoices', InvoiceController::class);
});