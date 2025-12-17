<?php

use App\Http\Controllers\ProfileController; // <--- Bạn đang thiếu dòng này
use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

// 1. Trang chủ
Route::get('/', function () {
    return view('welcome');
});

// 2. Logic rút gọn link (Public)
Route::post('/shorten', [LinkController::class, 'store'])
    ->name('shorten')
    ->middleware(['throttle:6,1']); // Chống Spam: Tối đa 6 lần/phút

// 3. Nhóm các route yêu cầu Đăng nhập (Dashboard + Profile)
Route::middleware('auth')->group(function () {
    
    // Dashboard: Trỏ về LinkController để hiện danh sách link
    Route::get('/dashboard', [LinkController::class, 'index'])->name('dashboard');

    // --- CÁC ROUTE PROFILE BỊ THIẾU (Nguyên nhân gây lỗi) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. Kích hoạt Authentication (Login, Register...)
// Phải đặt TRƯỚC route wildcard
require __DIR__.'/auth.php';

// 5. Route chuyển hướng Link Rút Gọn (Wildcard)
// LUÔN LUÔN ĐỂ Ở CUỐI CÙNG
Route::get('/{short_code}', [LinkController::class, 'shortenLink'])->name('link.redirect');