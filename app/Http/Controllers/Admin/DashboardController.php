<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Nạp thêm thư viện Auth để kiểm tra quyền

class DashboardController extends Controller
{
    public function index()
    {
        // 🔒 Kiểm tra phân quyền trực tiếp, sạch lỗi gạch vàng và an toàn tuyệt đối với Cache
        if (!Auth::check() || Auth::user()->role < 1) {
            return redirect()
                ->route('admin.bookings.index')
                ->with('error_alert', 'Tài khoản của bạn không được cấp quyền truy cập vào danh mục này!');
        }

        // 1. Tổng doanh thu từ các đơn hàng đã hoàn tất (Completed)
        $totalRevenue = Booking::where('status', 'Completed')->sum('total_amount');

        // 2. Số lượng booking đang chờ duyệt (Pending)
        $newBookings = Booking::where('status', 'Pending')->count();

        // 3. Tổng số lượng tour hiện có
        $totalTours = Tour::count();

        // 4. Lấy 5 tour mới nhất để hiển thị ở bảng dưới
        $latestTours = Tour::orderBy('id', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('totalRevenue', 'newBookings', 'totalTours', 'latestTours'));
    }
}
