<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FrontendProfileController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\MasterObatController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PengangkutController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\StatusKantorController;
use App\Http\Controllers\StokObatController;
use App\Http\Controllers\SubKategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\News;
use Illuminate\Support\Facades\Route;

// --- Root Redirect ---
Route::get('/', function () {
    return redirect('/home');
});

// Auth Routes (Backend / Admin)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');

// Frontend Auth Routes (Pengunjung / Pelanggan)
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'showFrontendLoginForm'])->name('frontend.login');
    Route::post('/masuk', [AuthController::class, 'frontendLogin'])->name('frontend.login.post')->middleware('throttle:5,1');
    Route::get('/daftar', fn () => redirect()->route('frontend.login'));
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin', fn () => redirect()->route('dashboard'))->name('admin');
    Route::get('/backend', fn () => redirect()->route('dashboard'))->name('backend');
    Route::get('/backend/admin', fn () => redirect()->route('dashboard'))->name('backend.admin');

    // Profil Pengguna (Backend & Frontend)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('/profil', [FrontendProfileController::class, 'index'])->name('frontend.profile');
    Route::put('/profil', [FrontendProfileController::class, 'update'])->name('frontend.profile.update');
    Route::put('/profil/password', [FrontendProfileController::class, 'updatePassword'])->name('frontend.profile.update-password');

    // Manajemen Data Master
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    // Manajemen E-Commerce & Katalog
    Route::resource('categories', CategoryController::class);
    Route::get('/products', fn () => redirect()->route('master-obat.index'))->name('products.index');

    Route::resource('news', NewsController::class);

    // --- RUTE STOK OBAT & EXPORT (HARUS DI DALAM MIDDLEWARE AUTH KALAU PERLU AMAN) ---
    // Posisikan rute khusus export & bulk action DI ATAS Route::resource('stok-obat')
    Route::get('/stok-obat/export-excel', [StokObatController::class, 'exportExcel'])->name('stok-obat.export');
    Route::get('/stok-obat/export-csv', [StokObatController::class, 'exportCsv'])->name('stok-obat.export-csv');
    Route::get('/stok-obat/print', [StokObatController::class, 'print'])->name('stok-obat.print');
    Route::post('/stok-obat/bulk-destroy', [StokObatController::class, 'bulkDestroy'])->name('stok-obat.bulk-destroy');

    // Rute resource stok obat (mencakup index, create, store, edit, update, destroy)
    Route::resource('stok-obat', StokObatController::class);

    // Rute untuk Master Obat
    Route::get('/master-obat/export-excel', [MasterObatController::class, 'exportExcel'])->name('master-obat.export');
    Route::get('/master-obat/export-csv', [MasterObatController::class, 'exportCsv'])->name('master-obat.export-csv');
    Route::get('/master-obat/print', [MasterObatController::class, 'print'])->name('master-obat.print');
    Route::post('/master-obat/{id}/toggle-status', [MasterObatController::class, 'toggleStatus'])->name('master-obat.toggle-status');
    Route::resource('master-obat', MasterObatController::class);

    // --- Rute khusus Permohonan Obat (OPD & Admin) ---
    Route::get('/permohonan/{permohonan}/print', [PermohonanController::class, 'print'])->name('permohonan.print');
    Route::post('/permohonan/{permohonan}/verifikasi', [PermohonanController::class, 'verifikasi'])->name('permohonan.verifikasi');
    Route::resource('permohonan', PermohonanController::class);

    // Rute khusus Transaksi Pemasukan
    Route::get('/pemasukan', [TransaksiController::class, 'indexPemasukan'])->name('pemasukan.index');
    Route::get('/pemasukan/import-csv', [TransaksiController::class, 'showImportCsvPemasukan'])->name('pemasukan.import-csv.form');
    Route::get('/pemasukan/download-template-csv', [TransaksiController::class, 'downloadTemplateCsvPemasukan'])->name('pemasukan.download-template-csv');
    Route::post('/pemasukan/import-csv', [TransaksiController::class, 'importCsvPemasukan'])->name('pemasukan.import-csv');
    Route::post('/pemasukan/bulk-delete', [TransaksiController::class, 'bulkDeletePemasukan'])->name('pemasukan.bulk-delete');
    Route::get('/pemasukan/create', [TransaksiController::class, 'createPemasukan'])->name('pemasukan.create');
    Route::post('/pemasukan', [TransaksiController::class, 'storePemasukan'])->name('pemasukan.store');
    Route::get('/pemasukan/{transaksi}', [TransaksiController::class, 'showPemasukan'])->name('pemasukan.show');
    Route::delete('/pemasukan/{transaksi}', [TransaksiController::class, 'destroyPemasukan'])->name('pemasukan.destroy');

    // Rute khusus Transaksi Pengeluaran
    Route::get('/pengeluaran', [TransaksiController::class, 'indexPengeluaran'])->name('pengeluaran.index');
    Route::post('/pengeluaran/bulk-delete', [TransaksiController::class, 'bulkDeletePengeluaran'])->name('pengeluaran.bulk-delete');
    Route::get('/pengeluaran/stok-by-gudang/{gudang}', [TransaksiController::class, 'getStokByGudang'])->name('pengeluaran.stok-by-gudang');
    Route::get('/pengeluaran/create', [TransaksiController::class, 'createPengeluaran'])->name('pengeluaran.create');
    Route::post('/pengeluaran', [TransaksiController::class, 'storePengeluaran'])->name('pengeluaran.store');
    Route::get('/pengeluaran/{transaksi}', [TransaksiController::class, 'showPengeluaran'])->name('pengeluaran.show');
    Route::delete('/pengeluaran/{transaksi}', [TransaksiController::class, 'destroyPengeluaran'])->name('pengeluaran.destroy');

    // Rute khusus Transaksi Pemindahan
    Route::get('/pemindahan', [TransaksiController::class, 'indexPemindahan'])->name('pemindahan.index');
    Route::get('/pemindahan/create', [TransaksiController::class, 'createPemindahan'])->name('pemindahan.create');
    Route::post('/pemindahan', [TransaksiController::class, 'storePemindahan'])->name('pemindahan.store');
    Route::get('/pemindahan/{transaksi}', [TransaksiController::class, 'showPemindahan'])->name('pemindahan.show');
    Route::delete('/pemindahan/{transaksi}', [TransaksiController::class, 'destroyPemindahan'])->name('pemindahan.destroy');

    // Rute untuk Master Gudang
    Route::resource('gudang', GudangController::class);

    // Rute untuk Master Instansi / OPD
    Route::get('/opd/import', [OpdController::class, 'showImportForm'])->name('opd.import.form');
    Route::post('/opd/import', [OpdController::class, 'import'])->name('opd.import');
    Route::resource('opd', OpdController::class);

    // Manajemen Pemasok
    Route::get('/pemasok/import', [PemasokController::class, 'showImportForm'])->name('pemasok.import.form');
    Route::post('/pemasok/import', [PemasokController::class, 'import'])->name('pemasok.import');
    Route::resource('pemasok', PemasokController::class);

    // Manajemen Galeri Dokumentasi (Foto & Video)
    Route::resource('galleries', GalleryController::class);

    // Pengaturan
    Route::get('/site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::put('/site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::resource('faq', FaqController::class);
    Route::resource('pejabat', PejabatController::class);
    Route::resource('program', ProgramController::class);
    Route::resource('subkategori', SubKategoriController::class);
    Route::resource('pengangkut', PengangkutController::class);
    Route::resource('status-kantor', StatusKantorController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
});

// Frontend
Route::get('/home', function () {
    $latestNews = News::with(['category', 'user'])
        ->where('status', 'publish')
        ->latest('published_at')
        ->take(3)
        ->get();

    $latestGalleries = Gallery::active()->take(6)->get();

    return view('frontend.home.index', compact('latestNews', 'latestGalleries'));
})->name('frontend.home');

Route::get('/about', function () {
    $totalNews = News::where('status', 'publish')->count();
    $totalGalleries = Gallery::active()->count();
    $totalCategories = Category::where('type', 'news')->count();
    $totalPublishedInfo = $totalNews + $totalGalleries;

    return view('frontend.about.index', compact(
        'totalNews',
        'totalGalleries',
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
    $faqs = Faq::active()->get();

    return view('frontend.about.faq', compact('faqs'));
})->name('frontend.about.faq');

// Galeri Publik
Route::get('/galeri', [GalleryController::class, 'frontendIndex'])
    ->name('frontend.galeri');
Route::get('/galeri/{gallery}', [GalleryController::class, 'frontendShow'])
    ->name('frontend.galeri.show');
Route::get('/about/galeri', fn () => redirect()->route('frontend.galeri'))
    ->name('frontend.about.galeri');

// Berita & Informasi Obat
Route::get('/berita', [NewsController::class, 'frontendIndex'])
    ->name('frontend.berita');

Route::get('/berita/kategori', [NewsController::class, 'frontendCategory'])
    ->name('frontend.berita.kategori');

Route::get('/berita/informasi-obat', function () {
    return view('frontend.obat.informasi');
})->name('frontend.informasi-obat');

Route::get('/berita/{slug}', [NewsController::class, 'frontendShow'])
    ->name('frontend.berita.detail');

// Redirect jalur lama obat ke Berita/Informasi Obat
Route::get('/obat/informasi', fn () => redirect()->route('frontend.informasi-obat'))
    ->name('frontend.obat.informasi');
Route::get('/obat', fn () => redirect()->route('frontend.galeri'))
    ->name('frontend.obat');
Route::get('/obat/{slug}', fn () => redirect()->route('frontend.informasi-obat'))
    ->name('frontend.obat.detail');

// Keranjang dinonaktifkan (redirect ke Beranda publik)
Route::any('/keranjang/{any?}', fn () => redirect()->route('frontend.home'))
    ->where('any', '.*')
    ->name('frontend.cart.index');

Route::get('/kontak', function () {
    return view('frontend.contact.index');
})->name('frontend.contact');
