<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Pagination\Paginator; // 1. Thêm dòng import này

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Giữ nguyên cấu hình phân quyền Admin hiện tại của bạn
        Gate::define('access-admin', function (User $user) {
            return $user->role === 2; 
        });

        // 2. Thêm dòng này để ép Laravel dùng giao diện phân trang Bootstrap 5
        Paginator::useBootstrapFive(); 
    }
}