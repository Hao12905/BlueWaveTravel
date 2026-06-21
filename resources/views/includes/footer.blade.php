<footer class="footer mt-5 pt-5 pb-3" style="background-color: #1a1a1a; color: #ffffff;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-4" style="color: #f36d21;">
                    <i class="fas fa-water me-2"></i>BLUE WAVE TRAVEL
                </h5>
                <p class="text-secondary" style="line-height: 1.8;">
                    Tự hào là đơn vị cung cấp các trải nghiệm du lịch nội địa hàng đầu Việt Nam. Chúng tôi cam kết mang lại những hành trình an toàn, thú vị và đáng nhớ nhất cho mọi khách hàng.
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
                    {{-- Trỏ link trực tiếp kèm param danh mục tương ứng với bộ lọc Route tours --}}
                    <li><a href="{{ route('tours', ['category' => 'Miền Bắc']) }}">Miền Bắc</a></li>
                    <li><a href="{{ route('tours', ['category' => 'Miền Trung']) }}">Miền Trung</a></li>
                    <li><a href="{{ route('tours', ['category' => 'Miền Nam']) }}">Miền Nam</a></li>
                    <li><a href="{{ route('tours', ['category' => 'Biển Đảo']) }}">Du lịch Biển đảo</a></li>
                    <li><a href="{{ route('tours') }}">Tour hiện có</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold mb-4">Thông tin cần biết</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                    <li><a href="#">Quy định đặt Tour</a></li>
                    <li><a href="#">Hướng dẫn thanh toán</a></li>
                    <li><a href="{{ route('contact') }}">Liên hệ hỗ trợ</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="text-uppercase fw-bold mb-4">Nhận ưu đãi sớm</h6>
                <p class="small text-secondary mb-3">Đăng ký để nhận thông tin về các tour giá rẻ sớm nhất.</p>
                <form class="newsletter-form">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control bg-dark border-secondary text-white shadow-none" placeholder="Email của bạn..." style="border-radius: 8px 0 0 8px;">
                        <button class="btn btn-primary" type="button" style="background-color: #f36d21; border: none; border-radius: 0 8px 8px 0;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
                <div class="mt-3">
                    <p class="small text-secondary mb-1"><i class="fas fa-phone-alt me-2"></i> Hotline: 1900 1234</p>
                    <p class="small text-secondary"><i class="fas fa-envelope me-2"></i> support@bluewave.com</p>
                </div>
            </div>
        </div>

        <hr class="my-4" style="background-color: #444;">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <span class="text-secondary small">
                    {{-- Thay đổi cú pháp echo php date bằng cặp ngoặc nhọn Blade --}}
                    &copy; {{ date('Y') }} <strong>Blue Wave Travel</strong>. Toàn bộ bản quyền được bảo lưu.
                </span>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-links li {
        margin-bottom: 12px;
    }
    .footer-links a {
        color: #a0a0a0;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    .footer-links a:hover {
        color: #f36d21;
        padding-left: 8px;
    }
    .social-icon {
        width: 38px;
        height: 38px;
        background-color: #333;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        text-decoration: none;
        transition: 0.3s;
    }
    .social-icon:hover {
        background-color: #f36d21;
        color: white;
        transform: translateY(-3px);
    }
    .newsletter-form .form-control::placeholder {
        color: #666;
        font-size: 0.9rem;
    }
</style>