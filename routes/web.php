<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\NotificationController;

Route::get('/', [PeminjamanController::class, 'index'])->name('home');

// Login & Register
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset langsung
Route::get('/reset-password', [AuthController::class, 'resetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Peminjaman
Route::middleware('auth')->group(function () {
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/jadwal', [PeminjamanController::class, 'jadwal'])->name('peminjaman.jadwal');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/peminjaman/jadwal/report', [PeminjamanController::class, 'report'])->name('peminjaman.jadwal.report');
    Route::get('/ruang', [RuangController::class, 'index']);
    Route::post('/ruang', [RuangController::class, 'store']);
    Route::put('/ruang/{id}', [RuangController::class, 'update']);
    Route::delete('/ruang/{id}', [RuangController::class, 'destroy']);
    Route::get('/peminjaman/manage', [PeminjamanController::class, 'manage'])->name('peminjaman.manage');
    Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy']);
    Route::get('/api/peminjaman/{id}', [PeminjamanController::class, 'detail']);
});

// Admin only: Kelola User
use App\Http\Controllers\AdminUserController;
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/kelola-user', [AdminUserController::class, 'index'])->name('kelola_user.index');
    Route::post('/user', [AdminUserController::class, 'store'])->name('user.store');
    Route::put('/user/{id}', [AdminUserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [AdminUserController::class, 'destroy'])->name('user.destroy');
});
