<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\News;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// --- INI YANG KITA UBAH ---
Route::get('/', function () {
    return redirect('/home');
});
// --------------------------

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Manajemen Data Master
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    // Manajemen E-Commerce
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    Route::resource('opds', OpdController::class);
    Route::resource('news', NewsController::class);
});

// Frontend
Route::get('/home', function () {
    $latestNews = News::with(['category', 'user'])
        ->where('status', 'publish')
        ->latest('published_at')
        ->take(3)
        ->get();

    $latestProducts = Product::with('category')
        ->where('status', 'published')
        ->latest()
        ->take(4)
        ->get();

    return view('frontend.home.index', compact('latestNews', 'latestProducts'));
})->name('frontend.home');

Route::get('/about', function () {
    $totalProducts = \App\Models\Product::where('status', 'published')->count();

    $totalNews = \App\Models\News::where('status', 'publish')->count();

    $totalCategories = \App\Models\Category::where('type', 'product')->count();

    $totalPublishedInfo = $totalProducts + $totalNews;

    return view('frontend.about.index', compact(
        'totalProducts',
        'totalNews',
        'totalCategories',
        'totalPublishedInfo'
    ));
})->name('frontend.about');

Route::get('/about/visi-misi', function () {
    return view('frontend.about.visi-misi');
})->name('frontend.about.visimisi');

Route::get('/about/fitur', function () {
    return view('frontend.about.fitur');
})->name('frontend.about.fitur');

Route::get('/about/faq', function () {
    return view('frontend.about.faq');
})->name('frontend.about.faq');

Route::get('/about/galeri', function () {
    $galeri = collect();

    return view('frontend.about.galeri', compact('galeri'));
})->name('frontend.about.galeri');

Route::get('/berita', [NewsController::class, 'frontendIndex'])
    ->name('frontend.berita');

Route::get('/berita/kategori', [NewsController::class, 'frontendCategory'])
    ->name('frontend.berita.kategori');

Route::get('/berita/{slug}', [NewsController::class, 'frontendShow'])
    ->name('frontend.berita.detail');

Route::get('/obat', [ProductController::class, 'frontendIndex'])
    ->name('frontend.obat');

Route::get('/obat/informasi', function () {
    return view('frontend.obat.informasi');
})->name('frontend.obat.informasi');

Route::get('/obat/{slug}', [ProductController::class, 'frontendShow'])
    ->name('frontend.obat.detail');

Route::get('/kontak', function () {
    return view('frontend.contact.index');
})->name('frontend.contact');
