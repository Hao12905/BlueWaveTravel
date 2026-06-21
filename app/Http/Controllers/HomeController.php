<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour; // Chỉ cần dùng Model Tour là đủ

class HomeController extends Controller
{
    /**
     * 1. Hiển thị Trang chủ
     */
    public function index()
    {
        $featuredTours = \App\Models\Tour::where('featured', 1)->limit(4)->get();

        return view('home', compact('featuredTours'));
    }

    public function detail($id)
    {
        // Dùng Model để lấy dữ liệu thay vì DB::table
        $tour = Tour::find($id);

        if (!$tour) {
            abort(404, 'Tour không tồn tại!');
        }

        return view('tour-detail', compact('tour'));
    }

    /**
     * 3. Trang danh sách Tour với bộ lọc
     */
    public function tours(Request $request)
    {
        $query = Tour::query(); // Sử dụng Query Builder của Model

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Tìm kiếm theo từ khóa
        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        // Lọc theo khoảng giá
        $price = $request->input('price_range');
        if ($price == '0-5') {
            $query->where('price', '<', 5000000);
        } elseif ($price == '5-10') {
            $query->whereBetween('price', [5000000, 10000000]);
        } elseif ($price == '10+') {
            $query->where('price', '>', 10000000);
        }

        $tours = $query->orderBy('id', 'DESC')->get();

        return view('tours', compact('tours'));
    }

    // --- CÁC HÀM XỬ LÝ KHÁC (GIỮ NGUYÊN) ---
    public function booking() { return view('booking'); }
    public function processBooking(Request $request) { return back()->with('success', 'Đã nhận yêu cầu!'); }
    public function checkCoupon(Request $request) { return response()->json(['status' => 'success', 'message' => 'Mã hợp lệ']); }
    public function completeBooking() { return view('complete-booking'); }
    public function contact() { return view('contact'); }
    public function processContact(Request $request) { return back()->with('success', 'Đã gửi liên hệ!'); }
    public function profile() { return view('profile'); }
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }
    public function logout() { return redirect('/'); }
}