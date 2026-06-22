<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Hiển thị trang cá nhân cùng lịch sử đơn hàng
     */
    public function profile()
    {
        $user = Auth::user();

        // 1. Lấy lịch sử đặt tour của chính user đó (kèm thông tin tour)
        $bookings = Booking::where(function ($query) use ($user) {
                            $query->where('user_id', $user->id)
                                  ->orWhere('email', $user->email);
                        })
                        ->with('tour')
                        ->orderBy('id', 'desc')
                        ->get();

        Booking::whereNull('user_id')
            ->where('email', $user->email)
            ->update(['user_id' => $user->id]);

        // 2. TỐI ƯU: Nếu role >= 1 (Quản lý hoặc Chủ tịch), lấy danh sách chờ duyệt.
        // Thay vì trả về null, trả về một Collection trống để tránh lỗi crash view (.isNotEmpty())
        $pendingBookings = collect(); 
        if ($user && $user->role >= 1) {
            $pendingBookings = Booking::where('status', 'Pending')
                                      ->with(['tour', 'user'])
                                      ->orderBy('id', 'asc')
                                      ->get();
        }

        // Truyền dữ liệu an toàn vào view
        return view('profile', compact('user', 'bookings', 'pendingBookings'));
    }

    /**
     * Cập nhật thông tin cá nhân
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // TỐI ƯU: Làm mới session đăng nhập với mật khẩu mới để không bị logout bất ngờ
        if ($request->filled('password')) {
            Auth::login($user);
        }

        return redirect()->route('profile')->with('success', 'Hồ sơ đã được cập nhật thành công!');
    }

    /**
     * Xử lý xác nhận đơn hàng (Dành cho Quản lý & Chủ tịch)
     */
    public function approveBooking($id)
    {
        if (Auth::user()->role < 1) {
            return redirect()->route('profile')->with('error', 'Bạn không có quyền thực hiện.');
        }

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'Completed']);

        return redirect()->route('profile')->with('success', 'Đơn hàng đã được duyệt!');
    }
}
