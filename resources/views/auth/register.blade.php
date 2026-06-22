@extends('layouts.auth')

@section('content')
<div class="card shadow-lg p-5" style="width: 100%; max-width: 450px; border-radius: 20px; border: none;">
    <h2 class="text-center fw-bold mb-4">ĐĂNG KÝ</h2>
    
    {{-- Hiển thị thông báo lỗi tổng quan nếu có --}}
    @if($errors->any())
        <div class="alert alert-danger p-2 small" style="border-radius: 10px;">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Họ và Tên</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" style="padding: 10px; border-radius: 10px;" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" style="padding: 10px; border-radius: 10px;" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" style="padding: 10px; border-radius: 10px;" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" class="form-control" style="padding: 10px; border-radius: 10px;" required>
        </div>
        
        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold mb-3" style="border-radius: 10px; background: linear-gradient(45deg, #001d3d, #00d2ff); border: none;">
            ĐĂNG KÝ THÀNH VIÊN
        </button>
    </form>

    <div class="text-center mt-2">
        <span class="text-muted">Đã có tài khoản?</span>
        <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-bold">Đăng nhập</a>
    </div>
</div>
@endsection