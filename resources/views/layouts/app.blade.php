<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blue Wave Travel Việt Nam')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        :root {
            --primary: #00d2ff;
            --bg-light: #ffffff;
            --text-light: #1a1a1a;
            --bg-dark: #121212;
            --text-dark: #f5f5f5;
        }
        
        /* Cấu trúc Dark Mode nền tảng toàn hệ thống */
        body.dark-mode { background-color: var(--bg-dark); color: var(--text-dark); }
        body.dark-mode .navbar { background: rgba(18, 18, 18, 0.9) !important; border-bottom: 1px solid #333; }
        body.dark-mode .card { background: #1e1e1e !important; color: white !important; border: 1px solid #333 !important; }
        body.dark-mode .text-muted { color: #aaa !important; }
        body.dark-mode .text-secondary { color: #ccc !important; }
        body.dark-mode .nav-link { color: #f5f5f5 !important; }
        
        /* Bổ sung xử lý đồng bộ Dark Mode cho các thẻ nội dung động */
        body.dark-mode .bg-white { background-color: #1e1e1e !important; color: #fff !important; }
        body.dark-mode .bg-light { background-color: #2a2a2a !important; color: #eee !important; }
        body.dark-mode .text-dark { color: #ffffff !important; }
        body.dark-mode .border-top, body.dark-mode .border-bottom { border-color: #333333 !important; }
        body.dark-mode input.form-control,
        body.dark-mode textarea.form-control,
        body.dark-mode select.form-select {
            background-color: #252525 !important;
            color: #fff !important;
            border-color: #444 !important;
        }
        body.dark-mode input.form-control::placeholder,
        body.dark-mode textarea.form-control::placeholder {
            color: #8b949e !important;
        }
        body.dark-mode section,
        body.dark-mode .profile-wrapper {
            background-color: #121212 !important;
            color: #f5f5f5 !important;
        }
        body.dark-mode .contact-info-card,
        body.dark-mode .glass-card,
        body.dark-mode .table-card,
        body.dark-mode .modal-content,
        body.dark-mode .dropdown-menu {
            background-color: #1e1e1e !important;
            color: #f5f5f5 !important;
            border-color: #333 !important;
        }
        body.dark-mode table,
        body.dark-mode .table {
            color: #f5f5f5 !important;
        }
        body.dark-mode .table-hover > tbody > tr:hover > * {
            background-color: #252525 !important;
            color: #ffffff !important;
        }
        body.dark-mode .empty-state {
            background: #171717 !important;
            border-color: #333 !important;
        }
        body.dark-mode .navbar-brand,
        body.dark-mode .navbar-brand span {
            color: #ffffff !important;
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s, color 0.3s; }
        .navbar { backdrop-filter: blur(15px); background: rgba(255,255,255,0.8); padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.05); transition: all 0.3s; z-index: 1000; }
        .nav-link { font-weight: 600; margin: 0 5px; position: relative; color: #1a1a1a; transition: 0.3s; }
        .nav-link::after { content: ''; position: absolute; width: 0; height: 2px; bottom: -2px; left: 50%; background: var(--primary); transition: 0.3s; transform: translateX(-50%); }
        .nav-link:hover::after { width: 80%; }
        
        .util-btn { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 1px solid rgba(0,0,0,0.1); transition: all 0.3s ease; background: white; color: #333; }
        body.dark-mode .util-btn { background: #333; border-color: #444; color: white; }
        .util-btn:hover { background: var(--primary); color: white !important; transform: translateY(-2px); }
        
        .points-badge { background: linear-gradient(90deg, #FFD700, #FFA500); padding: 5px 15px; border-radius: 50px; font-weight: 800; color: #000; box-shadow: 0 4px 10px rgba(255,165,0,0.3); font-size: 0.9rem; }
        .fw-800 { font-weight: 800; }
        
        /* Footer CSS */
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: #a0a0a0; text-decoration: none; transition: all 0.3s ease; font-size: 0.95rem; }
        .footer-links a:hover { color: #f36d21; padding-left: 8px; }
        .social-icon { width: 38px; height: 38px; background-color: #333; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none; transition: 0.3s; }
        .social-icon:hover { background-color: #f36d21; color: white; transform: translateY(-3px); }
        .newsletter-form .form-control::placeholder { color: #666; font-size: 0.9rem; }

        /* BẢO VỆ CHATBOT: Vô hiệu hóa tính năng chiếm dụng click chuột của các khối đồ họa sóng nền */
        .hero-glass-overlay, .video-container, .wave-wrapper, .parallax-waves {
            pointer-events: none !important;
        }
        
        /* Đảm bảo khung bọc ngoài chatbot luôn ở đỉnh cao nhất và nhận tương tác chuột */
        #bw-chat-wrapper {
            pointer-events: auto !important;
            z-index: 2147483647 !important;
        }
    </style>
    @stack('styles')
</head>

<body class="d-flex flex-column" style="min-height: 100vh;">

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fw-800 fs-3" href="{{ route('home') }}">
            <span class="text-primary">BLUE WAVE</span> TRAVEL
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto text-uppercase small">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Giới thiệu</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tours.index') }}">Tour</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Liên hệ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">Hồ sơ</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <div class="util-btn shadow-sm" onclick="toggleDarkMode()" title="Chỉnh sáng tối">
                    <i class="fas fa-moon" id="theme-icon"></i>
                </div>
                <div class="util-btn shadow-sm" onclick="toggleLanguage()" title="Dịch tiếng">
                    <span id="lang-text" class="fw-bold" style="font-size: 0.7rem;">EN</span>
                </div>
                @auth
                    <div class="points-badge ms-2">
                        <i class="fas fa-star"></i> {{ number_format(auth()->user()->points ?? 0) }} P
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill ms-2 fw-bold">Thoát</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm text-dark fw-bold ms-2">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold shadow-sm" style="background-color: #00d2ff; border: none;">Đăng ký</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Nội dung thay đổi động của các trang con --}}
<main class="flex-grow-1">
    @yield('content')
</main>

<footer class="footer mt-5 pt-5 pb-3" style="background-color: #1a1a1a; color: #ffffff;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-4" style="color: #f36d21;">
                    <i class="fas fa-water me-2"></i>BLUE WAVE TRAVEL
                </h5>
                <p class="text-secondary" style="line-height: 1.8;">
                    Tự hào là đơn vị cung cấp các trải nghiệm du lịch nội địa hàng đầu Việt Nam. Cam kết hành trình an toàn và đáng nhớ.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h6 class="text-uppercase fw-bold mb-4">Khám phá</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Miền Bắc</a></li>
                    <li><a href="#">Miền Trung</a></li>
                    <li><a href="#">Miền Nam</a></li>
                    <li><a href="#">Du lịch Biển đảo</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold mb-4">Thông tin cần biết</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                    <li><a href="#">Quy định đặt Tour</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold mb-4">Nhận ưu đãi sớm</h6>
                <form class="newsletter-form">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control bg-dark border-secondary text-white shadow-none" placeholder="Email của bạn...">
                        <button class="btn btn-primary" type="button" style="background-color: #f36d21; border: none;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <hr class="my-4" style="background-color: #444;">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <span class="text-secondary small">
                    &copy; {{ date("Y") }} <strong>Blue Wave Travel</strong>. Toàn bộ bản quyền được bảo lưu.
                </span>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        updateThemeIcon();
    }
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
    }
    function updateThemeIcon() {
        const icon = document.getElementById('theme-icon');
        if (icon) {
            if (document.body.classList.contains('dark-mode')) {
                icon.className = 'fas fa-sun';
            } else {
                icon.className = 'fas fa-moon';
            }
        }
    }
    updateThemeIcon();

    // Hệ thống dịch ngôn ngữ đồng bộ dữ liệu đa năng
    let currentLang = localStorage.getItem('lang') || 'vi';
    function toggleLanguage() {
        currentLang = currentLang === 'vi' ? 'en' : 'vi';
        localStorage.setItem('lang', currentLang);
        applyLanguage();
    }
    function applyLanguage() {
        document.querySelectorAll('[data-vi][data-en]').forEach(el => {
            el.innerText = currentLang === 'vi' ? el.getAttribute('data-vi') : el.getAttribute('data-en');
        });
        const langText = document.getElementById('lang-text');
        if (langText) langText.innerText = currentLang === 'vi' ? 'EN' : 'VI';
    }
    document.addEventListener('DOMContentLoaded', applyLanguage);
</script>

<script src="{{ asset('js/bw-preferences.js') }}"></script>

@stack('scripts')

@include('includes.chatbot')

</body>
</html>
