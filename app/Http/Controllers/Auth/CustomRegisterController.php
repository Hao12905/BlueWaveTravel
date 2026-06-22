<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomRegisterController extends Controller
{
    /**
     * Hiển thị giao diện đăng ký tài khoản thành viên công khai
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Xử lý logic kiểm tra và lưu tài khoản mới trực tiếp vào MySQL
     */
    public function register(Request $request)
    {
        // 1. Xác thực dữ liệu đầu vào - Đồng bộ hóa với thuộc tính "name" truyền từ Form
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // Ô xác nhận bắt buộc là name="password_confirmation"
        ], [
            // Thông báo lỗi bằng Tiếng Việt trực quan, chuyên nghiệp
            'name.required'      => 'Vui lòng điền họ và tên của bạn.',
            'name.string'        => 'Họ và tên bắt buộc phải là định dạng chuỗi ký tự.',
            'name.max'           => 'Họ và tên không được vượt quá giới hạn 255 ký tự.',
            'email.required'     => 'Vui lòng nhập địa chỉ email.',
            'email.email'        => 'Địa chỉ email không đúng định dạng quy chuẩn (ví dụ: abc@gmail.com).',
            'email.unique'       => 'Địa chỉ email này đã được đăng ký sử dụng trên hệ thống.',
            'password.required'  => 'Vui lòng thiết lập mật khẩu bảo mật.',
            'password.min'       => 'Mật khẩu bắt buộc phải chứa ít nhất từ 6 ký tự trở lên.',
            'password.confirmed' => 'Xác nhận lại mật khẩu chưa trùng khớp với ô mật khẩu phía trên.',
        ]);

        // 2. Tiến hành ghi bản ghi tài khoản mới vào cơ sở dữ liệu MySQL
        // Đã loại bỏ trường 'name' bị thừa để khắc phục lỗi "Unknown column 'name' in 'field list'"
        $user = User::create([
            'full_name' => $request->name, // Lấy dữ liệu ô "name" từ Form, nạp trực tiếp vào cột "full_name" trong DB
            'email'     => $request->email,
            'password'  => Hash::make($request->password), // Sử dụng Hash::make để mã hóa mật khẩu bảo mật tuyệt đối
            'role'      => 0, // Mặc định gán cấp độ tài khoản sau khi đăng ký (0 = khách hàng thông thường)
            'points'    => 0, // Điểm thưởng tích lũy ban đầu (Travel Points) bằng 0
            'status'    => 1, // Tài khoản ở trạng thái kích hoạt hoạt động bình thường
        ]);

        // 3. Đăng nhập tự động ngay lập tức thông qua Auth Facade sau khi lưu thành công
        Auth::login($user);
        
        // 4. Kiểm tra quyền hạn (Role) để điều hướng trang đích phù hợp nhất
        if ($user->role === 2) {
            return redirect()->route('admin.dashboard')->with('success', 'Đăng ký tài khoản quản trị tối cao thành công!');
        }
        
        // Điều hướng người dùng về trang chủ Frontend kèm thông báo session thành công
        return redirect('/')->with('success', 'Đăng ký tài khoản thành công! Chào mừng bạn đến với Blue Wave Travel.');
    }
}