@extends('layouts.app')

@section('title', 'Liên hệ - Blue Wave Travel')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    :root { 
        --gold-luxury: #d4a373; 
        --blue-dark: #001d3d; 
    }
    
    /* Hero header đồng bộ với trang giới thiệu và danh sách tour */
    .contact-hero { 
        min-height: 35vh; 
        background: linear-gradient(rgba(0, 29, 61, 0.75), rgba(0, 29, 61, 0.75)), 
                    url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80'); 
        background-size: cover; 
        background-position: center; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        text-align: center; 
    }
    
    .contact-info-card {
        background: white;
        border-radius: 24px;
        border: 1px solid rgba(0,0,0,0.04);
        transition: 0.3s;
    }
    .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 29, 61, 0.08) !important;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        background: rgba(0, 119, 182, 0.08);
        color: #0077b6;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .form-control:focus {
        border-color: #0077b6;
        box-shadow: 0 0 0 0.25rem rgba(0, 119, 182, 0.15);
    }

    .btn-gold-action {
        background: var(--gold-luxury) !important;
        color: white !important;
        border-radius: 12px !important;
        border: none;
        transition: 0.3s;
    }
    .btn-gold-action:hover {
        background: #bc8a5f !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(212, 163, 115, 0.3);
    }
    
    .social-link {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f1f5f9;
        color: var(--blue-dark);
        transition: 0.3s;
        text-decoration: none;
    }
    .social-link:hover {
        background: var(--blue-dark);
        color: white;
        transform: scale(1.1);
    }
    
    .map-container {
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
</style>

{{-- 1. Hero Section Banner --}}
<section class="contact-hero">
    <div class="container text-white" data-aos="zoom-in">
        <span style="color: var(--gold-luxury); font-weight: 800; letter-spacing: 3px; font-size: 0.8rem; text-transform: uppercase;">Kết nối ngay</span>
        <h1 class="display-4 fw-bold mt-2 mb-0">Liên Hệ Với Chúng Tôi</h1>
    </div>
</section>

{{-- 2. Main Content Section --}}
<section class="py-5" style="background: #f8fafc;">
    <div class="container py-4">
        
        {{-- Khối thông báo phản hồi từ Laravel Controller nếu có --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4 p-3" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 lg-g-5">
            {{-- Cột thông tin liên hệ phía bên trái --}}
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info-card p-4 p-md-5 shadow-sm h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h4 class="fw-bold text-dark mb-2">Thông Tin Liên Hệ</h4>
                        <p class="text-muted small mb-5">Đội ngũ hỗ trợ của Blue Wave luôn sẵn sàng phản hồi bạn trong thời gian sớm nhất.</p>
                        
                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-box me-3 flex-shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Địa chỉ trụ sở</h6>
                                <p class="text-muted mb-0">123 Đường Du Lịch, TP. Dĩ An, Bình Dương</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-box me-3 flex-shrink-0">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Hotline 24/7</h6>
                                <p class="text-muted mb-0 fw-bold text-dark">1900 666 888</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-box me-3 flex-shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Email hỗ trợ</h6>
                                <p class="text-muted mb-0">support@bluewave.travel</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top">
                        <h6 class="fw-bold mb-3 text-dark">Mạng xã hội truyền thông</h6>
                        <div class="d-flex gap-2">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-tiktok"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cột Form nhập thông tin phía bên phải --}}
            <div class="col-lg-7" data-aos="fade-left">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border border-light">
                    <h4 class="fw-bold text-dark mb-2">Gửi Tin Nhắn Cho Chúng Tôi</h4>
                    <p class="text-muted small mb-4">Nếu bạn có bất kỳ câu hỏi nào về tour tuyến hoặc dịch vụ, hãy điền vào form dưới đây.</p>
                    
                    <form action="{{ route('contact.process') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold text-secondary mb-1">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control py-2.5 rounded-3" placeholder="Nguyễn Văn A" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="small fw-bold text-secondary mb-1">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control py-2.5 rounded-3" placeholder="0901234567" required>
                            </div>
                            
                            <div class="col-12">
                                <label class="small fw-bold text-secondary mb-1">Địa chỉ Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control py-2.5 rounded-3" placeholder="example@gmail.com" required>
                            </div>
                            
                            <div class="col-12">
                                <label class="small fw-bold text-secondary mb-1">Chủ đề cần hỗ trợ</label>
                                <input type="text" name="subject" class="form-control py-2.5 rounded-3" placeholder="Tư vấn đặt tour biển đảo, góp ý dịch vụ...">
                            </div>
                            
                            <div class="col-12">
                                <label class="small fw-bold text-secondary mb-1">Nội dung chi tiết</label>
                                <textarea name="message" class="form-control rounded-3" rows="4" placeholder="Vui lòng nhập nội dung lời nhắn tại đây..."></textarea>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-gold-action w-100 py-3 fw-bold text-uppercase letter-spacing-1">Gửi Yêu Cầu Liên Hệ</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- 3. Google Maps nhúng tăng độ tin cậy --}}
        <div class="row mt-5" data-aos="fade-up">
            <div class="col-12">
                <div class="map-container">
                    {{-- Đã cập nhật tọa độ nhúng Google Maps chuẩn cho khu vực Dĩ An, Bình Dương --}}
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.4312891393663!2d106.77259797584164!3d10.854779657738228!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d85e042bf04b%3A0xbb26ba7b7e3f8906!2zVFA.IETx_QW4sIEP_bmggRM_MeeG7b25n!5e0!3m2!1svi!2svn!4v1716900000000!5m2!1svi!2svn" 
                        width="100%" 
                        height="450" 
                        style="border:0; display: block;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>
@endsection