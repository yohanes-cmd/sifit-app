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


// Frontend
Route::get('/home', function () {
    $latestNews = \App\Models\News::with(['category', 'user'])
        ->where('status', 'publish')
        ->latest('published_at')
        ->take(3)
        ->get();

    $latestProducts = \App\Models\Product::with('category')
        ->where('status', 'published')
        ->latest()
        ->take(4)
        ->get();

    return view('frontend.home.index', compact('latestNews', 'latestProducts'));
})->name('frontend.home');

Route::get('/about', function () {
    return view('frontend.about.index');
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

// Route::get('/about/galeri', function () {
//     $galeri = \App\Models\GaleriAlbum::latest('id_album')->get();

//     return view('frontend.about.galeri', compact('galeri'));
// })->name('frontend.about.galeri');

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