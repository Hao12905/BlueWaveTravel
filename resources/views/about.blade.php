@extends('layouts.app')

@section('title', 'Về Chúng Tôi - Blue Wave Travel')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    :root { 
        --wave-blue: #0077b6; 
        --wave-light: rgba(0, 119, 182, 0.1); 
        --accent-gold: #ffb703; 
        --blue-deep: #001d3d; 
    }
    .about-hero { 
        min-height: 50vh; 
        background: linear-gradient(rgba(0, 29, 61, 0.8), rgba(0, 29, 61, 0.8)), url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80'); 
        background-size: cover; 
        background-position: center; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        text-align: center; 
    }
    .sub-title { color: var(--accent-gold); font-weight: 800; letter-spacing: 3px; font-size: 0.75rem; text-transform: uppercase; }
    .main-title { font-weight: 800; font-size: 2.5rem; color: var(--blue-deep); }
    .value-card { padding: 40px; border-radius: 20px; border: 1px solid #eee; transition: 0.3s; height: 100%; text-align: center; }
    .value-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    
    /* Thêm CSS cho phần mới bổ sung */
    .stat-box { border-right: 1px solid rgba(0,0,0,0.1); }
    .stat-box:last-child { border-right: none; }
    @media (max-width: 768px) { .stat-box { border-right: none; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 20px; margin-bottom: 20px; } .stat-box:last-child { border-bottom: none; } }
    
    .team-card { border-radius: 20px; overflow: hidden; background: #white; transition: 0.3s; }
    .team-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    .member-img-wrap { position: relative; width: 100%; padding-top: 110%; overflow: hidden; }
    .member-img { position: absolute; top: 0; start: 0; width: 100%; height: 100%; object-fit: cover; }
    
    .partner-logo { filter: grayscale(100%); opacity: 0.6; transition: 0.3s; max-height: 50px; }
    .partner-logo:hover { filter: grayscale(0%); opacity: 1; }
</style>

{{-- 1. Hero Section --}}
<section class="about-hero">
    <div class="container text-white">
        <span class="sub-title text-white">Blue Wave Travel</span>
        <h1 class="display-3 fw-bold my-3">Câu Chuyện Xanh</h1>
        <p class="max-w-600 mx-auto opacity-75">Kiến tạo những hành trình độc bản, kết nối tâm hồn với đại dương xanh.</p>
    </div>
</section>

{{-- 2. Tầm nhìn & Sứ mệnh --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800" class="img-fluid rounded-4 shadow" alt="Story">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="sub-title text-primary">Tầm nhìn & Sứ mệnh</span>
                <h2 class="main-title mb-4">Khởi nguồn từ đam mê biển đảo</h2>
                <p class="text-muted fs-5">Chúng tôi ra đời với khát vọng mang vẻ đẹp hoang sơ của biển đảo Việt Nam đến gần hơn với du khách thượng lưu.</p>
                <div class="mt-4">
                    <p class="mb-2"><strong><i class="fas fa-check text-primary me-2"></i>Chất lượng 5 sao:</strong> Trải nghiệm đẳng cấp quốc tế.</p>
                    <p class="mb-2"><strong><i class="fas fa-check text-primary me-2"></i>Tận tâm 24/7:</strong> Luôn đồng hành trên mọi hành trình.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BỔ SUNG NEW: 3. Thống kê số liệu ấn tượng --}}
<section class="py-5 bg-white border-top border-bottom">
    <div class="container" data-aos="fade-up">
        <div class="row text-center">
            <div class="col-md-3 col-6 stat-box">
                <h2 class="display-5 fw-bold text-primary mb-1">5+</h2>
                <p class="text-muted text-uppercase small fw-bold mb-0">Năm Kinh Nghiệm</p>
            </div>
            <div class="col-md-3 col-6 stat-box">
                <h2 class="display-5 fw-bold text-primary mb-1">15K+</h2>
                <p class="text-muted text-uppercase small fw-bold mb-0">Khách Hàng Hài Lòng</p>
            </div>
            <div class="col-md-3 col-6 stat-box">
                <h2 class="display-5 fw-bold text-primary mb-1">50+</h2>
                <p class="text-muted text-uppercase small fw-bold mb-0">Tour Biển Độc Quyền</p>
            </div>
            <div class="col-md-3 col-6 stat-box">
                <h2 class="display-5 fw-bold text-primary mb-1">99%</h2>
                <p class="text-muted text-uppercase small fw-bold mb-0">Đánh Giá 5 Sao</p>
            </div>
        </div>
    </div>
</section>

{{-- 4. Giá trị cốt lõi --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="main-title">Giá trị cốt lõi</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card bg-white">
                    <i class="fas fa-heart fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Tận Tâm</h5>
                    <p class="text-muted mb-0">Phục vụ như người thân.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card bg-primary text-white">
                    <i class="fas fa-crown fa-3x mb-3 text-warning"></i>
                    <h5 class="fw-bold text-white">Đẳng Cấp</h5>
                    <p class="text-white-50 mb-0">Sự xa hoa trong từng trải nghiệm.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card bg-white">
                    <i class="fas fa-leaf fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Bền Vững</h5>
                    <p class="text-muted mb-0">Bảo vệ môi trường biển.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 5.ĐộingũBanđiềuhành --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="sub-title text-primary">Những người truyền lửa</span>
            <h2 class="main-title mt-2">Đội Ngũ Điều Hành</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="team-card border shadow-sm p-3">
                    <div class="member-img-wrap rounded-4">
                        <img src="{{ asset('images/team-huynh-nhat-hao.png') }}" class="member-img" alt="Huynh Nhat Hao - CEO">
                    </div>
                    <div class="text-center pt-3">
                        <h6 class="fw-bold mb-1">Huỳnh Nhật Hào</h6>
                        <small class="text-primary fw-medium">Founder & CEO</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="team-card border shadow-sm p-3">
                    <div class="member-img-wrap rounded-4">
                        <img src="{{ asset('images/team-huynh-nhat-hao.png') }}" class="member-img" alt="Huynh Nhat Hao - Marketing">
                    </div>
                    <div class="text-center pt-3">
                        <h6 class="fw-bold mb-1">Huỳnh Nhật Hào</h6>
                        <small class="text-primary fw-medium">Giám Đốc Marketing</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="team-card border shadow-sm p-3">
                    <div class="member-img-wrap rounded-4">
                        <img src="{{ asset('images/team-huynh-nhat-hao.png') }}" class="member-img" alt="Huynh Nhat Hao - Operation Manager">
                    </div>
                    <div class="text-center pt-3">
                        <h6 class="fw-bold mb-1">Huỳnh Nhật Hào</h6>
                        <small class="text-primary fw-medium">Trưởng Phòng Điều Hành Tour</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
@endsection
