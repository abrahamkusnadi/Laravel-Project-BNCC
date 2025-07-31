<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('home');
Route::post('/book/add', [BookController::class, 'create'])->name('create');
Route::get('/book', [BookController::class, 'show'])->name('show');