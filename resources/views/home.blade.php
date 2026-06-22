@extends('layouts.app')

@section('content')

{{-- 1. HERO SECTION --}}
<section class="hero-ultimate">
    <div class="video-container">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="https://assets.mixkit.co/videos/preview/mixkit-top-view-of-a-luxury-resort-and-the-sea-41005-original.mp4" type="video/mp4">
        </video>
        <div class="hero-glass-overlay"></div>
    </div>

    <div class="container h-100 d-flex align-items-center justify-content-center text-center position-relative z-10">
        <div class="hero-box">
            <h1 class="brand-title" data-aos="zoom-out" data-aos-duration="1200">Blue Wave Travel</h1>
            <div class="typed-box mb-4">
                <span class="static-txt">Trải nghiệm </span>
                <span id="typed-text" class="dynamic-txt"></span>
            </div>
            <p class="hero-desc" data-aos="fade-up" data-aos-delay="400">
                Kiến tạo những hành trình độc bản, kết nối tâm hồn với đại dương xanh và tận hưởng đặc quyền tích lũy Travel Points.
            </p>
        </div>
    </div>

    <div class="wave-wrapper">
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs><path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
            <g class="parallax-waves">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="var(--bg-body)" />
            </g>
        </svg>
    </div>
</section>

{{-- 2. STATS BAR SECTION --}}
<section class="stats-bar py-4 shadow-sm bg-white position-relative" style="z-index: 10;">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-md-4 border-end border-fix"><div class="d-flex align-items-center justify-content-center gap-3"><i class="fas fa-shield-alt text-primary fs-3"></i><div class="text-start"><h6 class="fw-bold m-0 text-dark heading-fix">An Toàn Tuyệt Đối</h6><small class="text-muted">Bảo hiểm du lịch cao cấp</small></div></div></div>
            <div class="col-md-4 border-end border-fix"><div class="d-flex align-items-center justify-content-center gap-3"><i class="fas fa-gem text-warning fs-3"></i><div class="text-start"><h6 class="fw-bold m-0 text-dark heading-fix">Travel Points</h6><small class="text-muted">Tích điểm đổi quà hấp dẫn</small></div></div></div>
            <div class="col-md-4"><div class="d-flex align-items-center justify-content-center gap-3"><i class="fas fa-headset text-primary fs-3"></i><div class="text-start"><h6 class="fw-bold m-0 text-dark heading-fix">Hỗ Trợ 24/7</h6><small class="text-muted">Luôn đồng hành cùng bạn</small></div></div></div>
        </div>
    </div>
</section> 

{{-- 3. FEATURED TOURS SECTION --}}
<section id="featured" class="py-5 bg-soft">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
            <div>
                <span class="sub-title" style="font-size: 0.85rem; letter-spacing: 2px; color: var(--accent-gold); font-weight: 700;">SIGNATURE COLLECTION</span>
                <h2 class="main-title fw-bold text-dark m-0" style="font-size: 2.2rem;">Hành Trình <span class="text-blue">Nổi Bật</span></h2>
                <div class="short-line mt-2" style="width: 60px; height: 3px; background-color: var(--wave-blue);"></div>
            </div>
            <a href="{{ url('/tours') }}" class="view-all-link text-decoration-none fw-bold" style="color: var(--wave-blue);">
                Xem tất cả tour <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="row">
            {{-- SỬA LỖI: Nhận diện cả biến $tours hoặc $featuredTours từ Controller truyền qua --}}
            @forelse($tours ?? $featuredTours ?? [] as $tour)
                <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="card tour-card h-100 border-0 shadow-sm" style="border-radius: 20px; overflow: hidden; transition: 0.4s ease;">
                        
                        <div class="position-relative">
                            <img src="{{ asset('images/' . ($tour->image_url ?? 'default.jpg')) }}" 
                                 class="card-img-top" 
                                 alt="{{ $tour->title ?? 'Tour du lịch' }}" 
                                 loading="lazy" 
                                 style="height: 200px; width: 100%; object-fit: cover;">
                            @if(!empty($tour->category))
                                <span class="badge position-absolute top-0 start-0 m-3 bg-primary rounded-pill px-3 py-2" style="font-size: 0.75rem; background-color: var(--wave-blue) !important;">
                                    {{ $tour->category }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column" style="padding: 1.5rem;">
                            <h5 class="card-title fw-bold text-dark" style="font-size: 1.1rem; line-height: 1.4;">
                                {{ $tour->title ?? 'Chưa cập nhật tên' }}
                            </h5>
                            
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($tour->description ?? 'Đang cập nhật mô tả cho hành trình này...', 80) }}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-danger fw-bold" style="font-size: 1.1rem;">
                                    {{ isset($tour->price) ? number_format($tour->price) . 'đ' : 'Liên hệ' }}
                                </span>
                                <a href="{{ url('/tours/' . ($tour->id ?? '#')) }}" 
                                   class="btn btn-sm btn-primary rounded-pill px-3" 
                                   style="background-color: var(--wave-blue); border: none;">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-map-marked-alt text-muted mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-muted fw-normal">Hiện tại hệ thống đang cập nhật các hành trình nổi bật mới. Xin vui lòng quay lại sau!</h5>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- 4. ABOUT US SECTION --}}
<section class="py-5 bg-white page-block-fix overflow-hidden">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="sub-title">VỀ CHÚNG TÔI</span>
                <h2 class="main-title">Hành Trình Gắn Kết <br><span class="italic-serif text-blue">Giá Trị Đích Thực</span></h2>
                <p class="description text-muted">Blue Wave Travel khởi nguồn từ niềm đam mê đại dương bất tận. Chúng tôi không chỉ cung cấp những chuyến đi, mà còn kiến tạo những kỷ niệm vô giá thông qua dịch vụ cá nhân hóa và hệ thống điểm thưởng Luxury dành riêng cho thành viên.</p>
            </div>
            <div class="col-lg-6 position-relative" data-aos="fade-left">
                <div class="image-stack text-end">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" class="img-1 rounded-4 shadow-lg img-fluid">
                    <div class="points-info-card shadow-lg text-start">
                        <i class="fas fa-coins text-warning mb-2 fs-4"></i>
                        <h6 class="fw-bold text-dark heading-fix">Tích điểm ngay</h6>
                        <p class="m-0 small text-muted">Mọi hành trình đều được hoàn tiền vào ví điểm của bạn.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    :root { --bg-body: #ffffff; --bg-soft: #f8fafc; --text-heading: #001d3d; --text-main: #334155; --text-muted: #64748b; --wave-blue: #0077b6; --accent-gold: #c5a059; --card-bg: #ffffff; --border-color: #e2e8f0; }
    .wave-wrapper, .parallax-waves, .video-container, .hero-glass-overlay { pointer-events: none !important; }
    body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); transition: 0.3s; overflow-x: hidden; }
    .italic-serif { font-family: 'Playfair Display', serif; font-style: italic; }
    .text-blue { color: var(--wave-blue); }
    .hero-ultimate { height: 75vh; position: relative; overflow: hidden; background: #000; }
    .video-container { position: absolute; top:0; left:0; width:100%; height:100%; z-index: 1; }
    .hero-video { width: 100%; height: 100%; object-fit: cover; }
    .hero-glass-overlay { position: absolute; top:0; left:0; width:100%; height:100%; background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.2), rgba(0,29,61,0.8)); z-index: 2; }
    .brand-title { font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 900; color: #fff; text-shadow: 0 10px 30px rgba(0,0,0,0.3); margin: 0; letter-spacing: -2px; }
    .dynamic-txt { color: #00b4d8; font-size: 1.4rem; font-weight: 800; border-right: 3px solid #fff; padding-right: 5px; }
    
    /* SỬA LỖI: Thêm Keyframes bổ sung cho chuyển động sóng SVG mượt mà */
    .parallax-waves > use { animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite; }
    @keyframes move-forever {
        0% { transform: translate3d(-90px,0,0); }
        100% { transform: translate3d(85px,0,0); }
    }
    
    .tour-card { border-radius: 20px; overflow: hidden; border: 1px solid var(--border-color); height: 100%; transition: 0.4s ease; }
    .tour-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important; }
    .img-1 { width: 100%; height: 400px; object-fit: cover; }
    .points-info-card { position: absolute; bottom: -20px; left: 20px; background: var(--card-bg); padding: 20px; border-radius: 15px; width: 250px; border-left: 5px solid var(--wave-blue); }
    
    /* Dark mode */
    body.dark-mode { --bg-body: #121212; --bg-soft: #1a1a1a; --card-bg: #1e1e1e; --border-color: #333333; }
    body.dark-mode .stats-bar, body.dark-mode .page-block-fix { background-color: #1e1e1e !important; }
    body.dark-mode .heading-fix, body.dark-mode .main-title { color: #ffffff !important; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if(document.getElementById('typed-text')) {
            new Typed('#typed-text', { strings: ['Xanh Ngắt.', 'Trong Mơ.', 'Đẳng Cấp.', 'Trọn Vẹn.'], typeSpeed: 70, backSpeed: 40, backDelay: 1500, loop: true });
        }
        AOS.init({ duration: 1000, once: true });
    });
</script>
@endpush