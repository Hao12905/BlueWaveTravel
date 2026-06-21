@extends('layouts.auth')

@section('content')

<style>
.btn-luxury-primary {
    /* Màu sắc gradient giống các trang web chuyên nghiệp */
    background: linear-gradient(45deg, #007bff, #00d2ff); 
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    transition: 0.4s;
    text-transform: uppercase;
}

.btn-luxury-primary:hover {
    background: linear-gradient(45deg, #0056b3, #0099cc);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
}
</style>
<div class="card shadow-lg p-5" style="width: 100%; max-width: 400px; border-radius: 20px; border: none;">
    <h2 class="text-center fw-bold mb-4">ĐĂNG NHẬP</h2>
    
    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Địa chỉ Email</label>
            <input type="email" name="email" class="form-control" style="padding: 12px; border-radius: 10px;" required>
        </div>
        <div class="mb-4">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" style="padding: 12px; border-radius: 10px;" required>
        </div>
        
        <button type="submit" class="btn-luxury-primary w-100 py-3 shadow-lg">
            ĐĂNG NHẬP NGAY <i class="fas fa-arrow-right ms-2"></i>
        </button>
    </form>

    <div class="text-center mt-2">
        <span class="text-muted">Chưa có tài khoản?</span>
        <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Đăng ký ngay</a>
    </div>
</div>
@endsection