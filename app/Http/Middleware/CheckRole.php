<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Cách dùng trong route: middleware('role:1,2')  
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Kiểm tra đăng nhập
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // 2. Kiểm tra nếu user không thuộc danh sách quyền được phép
        if (!in_array($user->role, $roles)) {
            // Thay vì abort(403), hãy điều hướng họ về trang phù hợp với quyền của họ
            if ($user->role == 1) { // Nếu là nhân viên
                return redirect()->route('admin.bookings.index')
                                 ->with('error_alert', 'Bạn không có quyền truy cập vào khu vực Chủ tịch!');
            }
            
            // Nếu là khách hàng hoặc các trường hợp khác, đưa về trang chủ
            return redirect()->route('home')
                             ->with('error_alert', 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}