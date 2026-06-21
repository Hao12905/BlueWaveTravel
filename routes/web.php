<?php

use Illuminate\Support\Facades\Route;

// --- FRONTEND CONTROLLERS ---
use App\Http\Controllers\TourController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Frontend\BookingController as FrontendBookingController;
use App\Http\Controllers\Frontend\CheckCouponController;
use App\Http\Controllers\Frontend\CompleteBookingController;
use App\Http\Controllers\Frontend\ProfileController;

// --- AUTH & ADMIN CONTROLLERS ---
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES - FRONTEND (KHÁCH HÀNG)
|--------------------------------------------------------------------------
*/

// Trang chủ - Hiển thị hành trình nổi bật
Route::get('/', [TourController::class, 'index'])->name('home');

// Trang danh sách tour công khai + Bộ lọc vùng miền, tìm kiếm
Route::get('/tours', [TourController::class, 'tours'])->name('tours.index');
Route::get('/tours/{id}', [TourController::class, 'show'])->name('tours.show');

// Giới thiệu & Liên hệ
Route::view('/gioi-thieu', 'about')->name('about');
Route::get('/lien-he', [ContactController::class, 'create'])->name('contact');
Route::post('/process-contact', [ContactController::class, 'store'])->name('contact.process');

// Đặt tour & Coupon
Route::get('/booking', [FrontendBookingController::class, 'booking'])->name('booking');
Route::post('/book-tour', [FrontendBookingController::class, 'store'])->middleware('auth')->name('booking.store.legacy');
Route::get('/complete-booking', [FrontendBookingController::class, 'complete'])->name('complete.booking');

Route::post('/process-booking', [FrontendBookingController::class, 'processBooking'])->name('booking.process');

Route::post('/booking/store', [FrontendBookingController::class, 'store'])->middleware('auth')->name('booking.store');
Route::post('/check-coupon', [CheckCouponController::class, 'checkCoupon'])->name('coupon.check');
Route::get('/complete-booking', [CompleteBookingController::class, 'completeBooking'])->name('booking.complete');

// Xác thực tài khoản (Auth)
Route::get('/login', [CustomLoginController::class, 'showLogin'])->name('login');
Route::post('/login', [CustomLoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [CustomLoginController::class, 'logout'])->name('logout');
Route::get('/register', [CustomRegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [CustomRegisterController::class, 'register'])->name('register.submit');

// Quản lý hồ sơ khách hàng (Yêu cầu đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/approve-booking/{id}', [ProfileController::class, 'approveBooking'])->name('profile.approve_booking');
});

/*
|--------------------------------------------------------------------------
| WEB ROUTES - BACKEND (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1,2'])->prefix('admin')->name('admin.')->group(function () {
    
    // Quyền chung: Nhân viên (role 1) và Quản trị viên (role 2)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::put('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::delete('/bookings/{id}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue');

    // Phân quyền nâng cao: Chỉ Admin/Chủ tịch (Sử dụng Middleware 'admin.role')
    Route::middleware(['admin.role'])->group(function () {
        Route::resource('tours', AdminTourController::class)->except(['show']);
        Route::get('/users', [UserAdminController::class, 'index'])->name('users.index');
        Route::post('/users/{id}/update-role', [UserAdminController::class, 'updateRole'])->name('users.update_role');
    });
});
