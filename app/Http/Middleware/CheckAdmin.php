<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Kiểm tra nếu chưa đăng nhập
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Kiểm tra nếu role >= 2 (Chủ tịch) mới được cho qua
        if (auth()->user()->role >= 2) {
            return $next($request);
        }

        // 3. Nếu là Nhân viên (role=1) hoặc thấp hơn, 
        // chuyển hướng về trang danh sách đơn hàng thay vì báo lỗi 403
        return redirect()->route('admin.bookings.index')
                         ->with('error_alert', 'Bạn không có quyền truy cập vào khu vực này!');
    }
}