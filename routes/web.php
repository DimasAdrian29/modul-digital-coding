<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\SoalController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('role:siswa,guru,admin')->group(function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/bab/{bab}', [HomeController::class, 'showBab'])->name('bab.show');
    Route::get('/bab/{bab}/materi', [HomeController::class, 'babMateri'])->name('bab.materi');
    Route::get('/bab/{bab}/latihan', [HomeController::class, 'babLatihan'])->name('bab.latihan');
    Route::post('/bab/{bab}/latihan/hasil', [HomeController::class, 'storeBabAttempt'])->name('bab.latihan.store');
    Route::post('/bab/{bab}/selesai', [HomeController::class, 'completeBab'])->name('bab.complete');
    Route::get('/sertifikat/{sertifikat}', [SertifikatController::class, 'show'])->name('sertifikat.show');
    Route::get('/sertifikat/{sertifikat}/download', [SertifikatController::class, 'download'])->name('sertifikat.download');
    Route::get('/bab/{bab}/forum', [HomeController::class, 'babForum'])->name('bab.forum');
    Route::post('/bab/{bab}/forum', [HomeController::class, 'storeForumPost'])->name('bab.forum.store');
    Route::post('/bab/{bab}/forum/{post}/balas', [HomeController::class, 'storeForumReply'])->name('bab.forum.reply.store');
    Route::get('/materi', [HomeController::class, 'materi'])->name('materi.index');
    Route::get('/materi/{materi}', [HomeController::class, 'showMateri'])->name('materi.show');
    Route::get('/latihan-soal', [HomeController::class, 'quiz'])->name('quiz.index');
});

Route::prefix('admin')->name('admin.')->middleware('role:guru,admin')->group(function (): void {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('materi', MateriController::class)->except(['show']);
    Route::resource('soal', SoalController::class)->except(['show']);
    Route::resource('forum', ForumPostController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::get('sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
});
