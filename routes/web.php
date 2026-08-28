<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\RoleController; 
use App\Http\Controllers\UserController; 
// Tambahkan ini:
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\OpdController;
use App\Http\Controllers\NewsController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

// Manajemen Data Master
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);

// Manajemen E-Commerce
Route::resource('categories', CategoryController::class); // <--- Rute Kategori Baru
Route::resource('products', ProductController::class);

// ... (route lainnya)
Route::resource('opds', OpdController::class);

Route::resource('news', NewsController::class);