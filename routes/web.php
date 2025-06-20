<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.home');
})->name('pages.home');

// Berita routes dengan controller
Route::get('/berita', [NewsController::class, 'newsFrontend'])->name('pages.berita');
Route::get('/berita/{news}', [NewsController::class, 'newsDetail'])->name('pages.perArtikel');

// Galeri routes dengan controller
Route::get('/galeri', [GalleryController::class, 'galleryFrontend'])->name('pages.galeri');
Route::get('/galeri/{gallery}', [GalleryController::class, 'galleryDetail'])->name('pages.perGaleri');

Route::get('/profilguru', [TeacherController::class, 'teacherFrontend'])->name('pages.profilguru');

Route::get('/ekstrakulikuler/detail', function () {
    return view('frontend.ekstrakulikuler.detail');
})->name('pages.perEkstrakulikuler');

Route::get('/kontak', function () {
    return view('frontend.kontak');
})->name('pages.kontak');

// Halaman Admin
Route::get('/login', function () {
    return view('auth.login');
})->name('pages.login');

Route::post('/login', function () {
    // Simulasi login sederhana
    $username = request('username');
    $password = request('password');
    
    if ($username === 'admin' && $password === 'admin123') {
        session(['admin' => true]);
        return redirect()->route('admin.dashboard');
    }
    
    return back()->withErrors(['message' => 'Username atau password salah']);
})->name('login.post');

Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $galleries = \App\Models\Gallery::latest()->get();
        $news = \App\Models\News::latest()->get();
        $teachers = \App\Models\Teacher::latest()->get();
        return view('admin.dashboard', compact('galleries', 'news', 'teachers'));
    })->name('admin.dashboard');
    
    Route::get('/logout', function () {
        session()->forget('admin');
        return redirect()->route('pages.home');
    })->name('admin.logout');
    
    // Admin Gallery Routes
    Route::resource('gallery', GalleryController::class, ['as' => 'admin']);
    Route::resource('news', NewsController::class, ['as' => 'admin']);
    Route::resource('teachers', TeacherController::class, ['as' => 'admin']);
    
    // Gallery Manager dengan PHP
    Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
    Route::get('/news-manager', [NewsController::class, 'newsManager'])->name('admin.news.manager');
    Route::get('/news', [NewsController::class, 'index'])->name('admin.news.index');
    Route::get('/teacher-manager', [TeacherController::class, 'teacherManager'])->name('admin.teachers.manager');
    Route::get('/teachers', [TeacherController::class, 'index'])->name('admin.teachers.index');
  
});

// API Routes untuk AJAX
Route::prefix('api')->group(function () {
    // Gallery API
    Route::get('/galleries', [GalleryController::class, 'apiIndex']);
    Route::post('/galleries', [GalleryController::class, 'apiStore'])->name('admin.gallery.apiStore');
    Route::put('/galleries/{id}', [GalleryController::class, 'apiUpdate']);
    Route::delete('/galleries/{id}', [GalleryController::class, 'apiDestroy']);
    
    // News API
    Route::get('/news', [NewsController::class, 'apiIndex']);
    Route::get('/news/{id}', [NewsController::class, 'apiShow']);
    Route::post('/news', [NewsController::class, 'apiStore'])->name('admin.news.apiStore');
    Route::put('/news/{id}', [NewsController::class, 'apiUpdate']);
    Route::delete('/news/{id}', [NewsController::class, 'apiDestroy']);
    
    // Teachers API
    Route::get('/teachers', [TeacherController::class, 'apiIndex']);
    Route::get('/teachers/{id}', [TeacherController::class, 'apiShow']);
    Route::post('/teachers', [TeacherController::class, 'apiStore'])->name('admin.teachers.apiStore');
    Route::put('/teachers/{id}', [TeacherController::class, 'apiUpdate']);
    Route::delete('/teachers/{id}', [TeacherController::class, 'apiDestroy']);
});
