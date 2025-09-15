<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RuangController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PeminjamanController::class, 'index'])->name('home');

// Login & Register
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Peminjaman
Route::middleware('auth')->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'create']);
    Route::post('/peminjaman', [PeminjamanController::class, 'store']);
    Route::get('/jadwal', [PeminjamanController::class, 'jadwal']);
});

// Admin/Petugas
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/ruang', [RuangController::class, 'index']);
    Route::post('/ruang', [RuangController::class, 'store']);
    Route::delete('/ruang/{id}', [RuangController::class, 'destroy']);
    Route::get('/peminjaman/manage', [PeminjamanController::class, 'manage']);
    Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve']);
    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject']);
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);
});

// Admin only: Tambah User
use App\Http\Controllers\AdminUserController;
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tambah-user', [AdminUserController::class, 'create'])->name('tambah_user.create');
    Route::post('/tambah-user', [AdminUserController::class, 'store'])->name('tambah_user.store');
});
