@extends('layouts.app')

@section('title', 'Hoàn tất đặt tour')

@section('content')
    <section class="py-5 bg-light" style="min-height: 75vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-body text-center p-5">
                            
                            <div class="mb-4 d-inline-block p-4 rounded-circle bg-success bg-opacity-10 text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                            </div>

                            <h1 class="fw-bold text-success mb-3" style="font-size: 2rem;">Đặt Tour Thành Công!</h1>

                            @if(session('success'))
                                <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-3 mb-4 py-3">
                                    {{ session('success') }}
                                </div>
                            @else
                                <p class="lead text-muted mb-4">
                                    Cảm ơn bạn đã đặt hành trình cùng <strong>Blue Wave Travel</strong>. Hệ thống đã ghi nhận thông tin đăng ký của bạn.
                                </p>
                            @endif

                            <hr class="my-4 border-light-subtle">

                            <div class="text-start mb-4 bg-light p-4 rounded-3 border border-dashed text-secondary">
                                <h5 class="fw-bold text-dark mb-3">📌 Các bước tiếp theo:</h5>
                                <ul class="list-unstyled mb-0" style="font-size: 0.95rem; line-height: 1.6;">
                                    <li class="mb-3 d-flex align-items-start">
                                        <span class="badge bg-primary rounded-circle me-2 mt-1 d-inline-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">1</span>
                                        <span>Đội ngũ tư vấn viên sẽ gọi điện trực tiếp hoặc gửi Email xác nhận lịch trình chi tiết và số lượng chỗ trong vòng <strong>15 - 30 phút</strong>.</span>
                                    </li>
                                    <li class="mb-0 d-flex align-items-start">
                                        <span class="badge bg-primary rounded-circle me-2 mt-1 d-inline-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">2</span>
                                        <span>Nếu lựa chọn phương thức <strong>Chuyển khoản</strong>, bạn có thể thực hiện thanh toán trước theo thông tin bên dưới hoặc chờ cuộc gọi để được hướng dẫn nhận mã hóa đơn chiết khấu.</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="text-start mb-4 border rounded-3 p-4 bg-white shadow-sm">
                                <h6 class="fw-bold text-secondary text-uppercase mb-3" style="font-size: 0.8rem; letter-spacing: 1px;">
                                    🏦 Thông tin tài khoản nhận thanh toán chính thức
                                </h6>
                                <div class="row g-3 text-secondary" style="font-size: 0.95rem;">
                                    <div class="col-sm-6">
                                        <span class="text-muted d-block small">Ngân hàng giao dịch</span>
                                        <strong class="text-dark">Vietcombank (VCB)</strong>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted d-block small">Chủ tài khoản hưởng dụng</span>
                                        <strong class="text-dark">CONG TY TNHH BLUE WAVE TRAVEL</strong>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted d-block small">Số tài khoản (STK)</span>
                                        <strong class="text-primary fs-5 fw-bold">1023456789</strong>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="text-muted d-block small">Cú pháp / Nội dung chuyển tiền</span>
                                        <strong class="text-danger">Họ tên + Số điện thoại đặt tour</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid d-sm-flex justify-content-sm-center gap-3 pt-2">
                                <a href="{{ route('home') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm fw-semibold" style="font-size: 1rem;">
                                    Quay về trang chủ
                                </a>
                                <a href="{{ url('/tours') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4 fw-semibold" style="font-size: 1rem;">
                                    Khám phá thêm tour khác
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection