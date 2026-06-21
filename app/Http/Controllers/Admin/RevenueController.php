<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra quyền: Chỉ Chủ tịch (role == 2) mới được truy cập dữ liệu tài chính
        if (!Auth::check() || Auth::user()->role < 1) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // 1. Nhận các tham số lọc từ bộ form GET
        $selectedYear = $request->get('year', 2026); // Mặc định năm 2026
        $selectedMonth = $request->get('month');
        $selectedQuarter = $request->get('quarter');

        // 2. Khởi tạo Query nền tảng dựa trên bảng Bookings với các đơn hàng thành công
        $query = Booking::where('status', 'Completed')->whereYear('created_at', $selectedYear);

        // Áp dụng bộ lọc tháng hoặc quý nếu có
        if (!empty($selectedMonth)) {
            $query->whereMonth('created_at', $selectedMonth);
        } elseif (!empty($selectedQuarter)) {
            if ($selectedQuarter == '1') $query->whereIn(\DB::raw('MONTH(created_at)'), [1, 2, 3]);
            elseif ($selectedQuarter == '2') $query->whereIn(\DB::raw('MONTH(created_at)'), [4, 5, 6]);
            elseif ($selectedQuarter == '3') $query->whereIn(\DB::raw('MONTH(created_at)'), [7, 8, 9]);
            elseif ($selectedQuarter == '4') $query->whereIn(\DB::raw('MONTH(created_at)'), [10, 11, 12]);
        }

        // Tính tổng doanh thu sau khi lọc
        $filteredRevenue = $query->sum('total_amount') ?? 0;

        // 3. Tính doanh thu cố định của tháng hiện tại (Năm mặc định 2026)
        $currentMonth = date('m');
        $monthRevenueFixed = Booking::where('status', 'Completed')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', 2026)
            ->sum('total_amount') ?? 0;

        // 4. Khởi tạo mảng dữ liệu cho biểu đồ xu hướng 12 tháng (Năm dựa trên bộ lọc)
        $chartLabels = [];
        $chartData = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartLabels[] = "T" . $m;
            $chartData[] = Booking::where('status', 'Completed')
                ->whereMonth('created_at', $m)
                ->whereYear('created_at', $selectedYear)
                ->sum('total_amount') ?? 0;
        }

        // 5. Lấy danh sách 10 đơn hàng gần nhất theo bộ lọc kèm thông tin Tour liên kết
        // Sao chép lại query lọc phía trên để lấy dữ liệu danh sách chính xác
        $latestOrders = $query->with('tour')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        // 6. Trả toàn bộ dữ liệu sang giao diện Blade
        return view('admin.revenue.index', compact(
            'filteredRevenue',
            'monthRevenueFixed',
            'currentMonth',
            'selectedYear',
            'selectedMonth',
            'selectedQuarter',
            'chartLabels',
            'chartData',
            'latestOrders'
        ));
    }
}
