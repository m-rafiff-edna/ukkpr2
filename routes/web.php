<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RuangController;

Route::get('/', [PeminjamanController::class, 'index'])->name('home');

// Login & Register
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Peminjaman
Route::middleware('auth')->group(function () {
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/jadwal', [PeminjamanController::class, 'jadwal'])->name('peminjaman.jadwal');
});

Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/peminjaman/jadwal/report', [PeminjamanController::class, 'report'])->name('peminjaman.jadwal.report');
    Route::get('/ruang', [RuangController::class, 'index']);
    Route::post('/ruang', [RuangController::class, 'store']);
    Route::delete('/ruang/{id}', [RuangController::class, 'destroy']);
    Route::get('/peminjaman/manage', [PeminjamanController::class, 'manage'])->name('peminjaman.manage');
    Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);
    Route::get('/api/peminjaman/{id}', [PeminjamanController::class, 'detail']);
});

// Admin only: Tambah User
use App\Http\Controllers\AdminUserController;
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tambah-user', [AdminUserController::class, 'create'])->name('tambah_user.create');
    Route::post('/tambah-user', [AdminUserController::class, 'store'])->name('tambah_user.store');
});
