<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAdminController extends Controller
{
    public function index()
    {
        // Kiểm tra phân quyền an toàn, không phụ thuộc vào Middleware Closure gây lỗi cache
        if (!Auth::check() || Auth::user()->role !== 2) {
            return redirect()
                ->route('admin.bookings.index')
                ->with('error_alert', 'Tài khoản của bạn không được cấp quyền truy cập vào danh mục này!');
        }

        // Lấy tất cả danh sách thành viên (trừ tài khoản chính mình đang đăng nhập)
        $users = User::where('id', '!=', Auth::id())->orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        // Chặn đứng hành vi thay đổi role trái phép từ các tài khoản cấp thấp hơn
        if (!Auth::check() || Auth::user()->role !== 2) {
            return redirect()
                ->route('admin.bookings.index')
                ->with('error_alert', 'Tài khoản của bạn không được cấp quyền truy cập vào danh mục này!');
        }

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Đã cập nhật phân quyền nhân sự thành công!');
    }
}