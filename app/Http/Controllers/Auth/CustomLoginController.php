<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CustomLoginController extends Controller
{
    public function showLogin()
    {
        // Nếu đã đăng nhập rồi thì tự động điều hướng theo quyền, không cho vào trang login nữa
        if (Auth::check()) {
            return $this->redirectByUserRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $plainPassword = $request->password;
            $storedHash = $user->password;
            $hashInfo = password_get_info($storedHash);

            // 1. Kiểm tra Bcrypt (Chuẩn Laravel)
            if ($hashInfo['algoName'] === 'bcrypt') {
                if (Hash::check($plainPassword, $storedHash)) {
                    $this->performLogin($request, $user);
                    return $this->redirectByUserRole($user);
                }
            } 
            // 2. Kiểm tra MD5/Plain text (nếu là tài khoản cũ chưa nâng cấp)
            elseif (hash_equals(md5($plainPassword), $storedHash) || hash_equals($plainPassword, $storedHash)) {
                
                // Tự động nâng cấp mật khẩu lên Bcrypt
                $user->update(['password' => Hash::make($plainPassword)]);
                
                $this->performLogin($request, $user);
                return $this->redirectByUserRole($user);
            }
        }

        // Trả về lỗi chung để bảo mật thông tin tài khoản
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->withInput($request->only('email'));
    }

    /**
     * Hàm điều hướng người dùng dựa trên chức vụ (Role)
     */
    private function redirectByUserRole($user)
    {
        // 1. Chỉ có Chủ tịch (role = 2) mới được vào xem Dashboard tổng quan
        if ($user->role == 2) {
            return redirect()->intended('/admin/dashboard');
            
        }
        if ($user->role == 1) {
        // Ví dụ: chỉ cho phép nhân viên vào module quản lý đơn hàng (bookings)
        return redirect()->intended('/admin/dashboard');
        }
    
        // 3. Tài khoản khách hàng thông thường (role = 0) điều hướng về trang chủ ngoài
        return redirect()->intended('/');
    }

    /**
     * Hàm phụ trợ để đăng nhập và thiết lập session
     */
    private function performLogin(Request $request, User $user)
    {
        Auth::login($user, $request->has('remember'));
        $request->session()->regenerate();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
