@extends('layouts.app')

@section('title', $tour->title ?? 'Chi tiết Tour')

@section('content')
<div class="container py-5">
    @if(isset($tour))
        <div class="row g-4">
            {{-- CỘT TRÁI (8 phần): Ảnh chính & Thư viện ảnh --}}
            <div class="col-lg-8">
                {{-- Ảnh chính --}}
                <div class="main-image-container mb-3 position-relative shadow-sm rounded-4 overflow-hidden">
                    <img id="mainImage" src="{{ asset('images/' . $tour->image_url) }}" 
                         class="img-fluid w-100" style="height: 450px; object-fit: cover;" alt="{{ $tour->title }}">
                </div>
                
                {{-- Khu vực 3 ảnh phụ --}}
                <div class="row g-3">
                    @for($i = 0; $i < 3; $i++)
                        <div class="col-4">
                            <div class="ratio ratio-16x9">
                                <img src="{{ asset('images/' . $tour->image_url) }}" 
                                     class="img-fluid rounded-3 border shadow-sm thumb-img" 
                                     style="object-fit: cover; cursor: pointer;"
                                     onclick="changeImage(this.src)">
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- CỘT PHẢI (4 phần): Thông tin đặt tour (Sticky) --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white sticky-top" style="top: 100px; z-index: 10;">
                    <span class="badge bg-primary text-white align-self-start mb-3 px-3 py-2 rounded-pill shadow-sm">
                        {{ $tour->category }}
                    </span>
                    <h1 class="fw-bold h2 mb-3 text-dark">{{ $tour->title }}</h1>
                    <div class="price-box mb-4">
                        <span class="text-muted small">Giá trọn gói từ:</span>
                        <h2 class="text-danger fw-800 mb-0">{{ number_format($tour->price) }}đ</h2>
                        <small class="text-muted">/ khách</small>
                    </div>
                    
                    <div class="tour-meta text-secondary mb-4 border-top pt-3">
                        <p class="mb-2"><i class="fas fa-map-marker-alt text-primary me-2"></i> Khởi hành: <strong>{{ $tour->location }}</strong></p>
                        <p class="mb-0"><i class="far fa-clock text-warning me-2"></i> Thời gian: <strong>{{ $tour->duration }}</strong></p>
                    </div>

                    {{-- Nút Đặt Tour mở Form cửa sổ nổi (Modal) --}}
                    <div class="weather-box mb-4 p-3 rounded-4 border bg-light">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Du bao thoi tiet</h6>
                                <small class="text-muted" id="weatherLocationText">{{ $tour->location }}</small>
                            </div>
                            <i class="fas fa-cloud-sun text-warning fs-4"></i>
                        </div>
                        <div id="weatherForecast" class="small text-muted">
                            Dang tai du bao...
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary btn-lg w-100 py-3 rounded-pill fw-bold text-uppercase shadow-sm" 
                            data-bs-toggle="modal" data-bs-target="#bookingModal"
                            style="background: linear-gradient(45deg, #0d6efd, #00d2ff); border: none;">
                        <i class="fas fa-paper-plane me-2"></i> Đặt Tour Ngay
                    </button>
                </div>
            </div>
        </div>

        {{-- PHẦN MÔ TẢ CHI TIẾT --}}
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                    <h4 class="fw-bold mb-4 border-bottom pb-3"><i class="fas fa-file-alt text-primary me-2"></i>Giới thiệu hành trình</h4>
                    <div class="description-content lh-lg text-secondary" style="font-size: 1.05rem;">
                        {!! nl2br(e($tour->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL THÔNG TIN ĐẶT TOUR --}}
        <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header text-white border-0 py-3" style="background: linear-gradient(135deg, #0f4c81, #1d70b8);">
                        <h5 class="modal-title fw-bold">THÔNG TIN ĐẶT TOUR</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                        <input type="hidden" name="coupon_code" id="appliedCouponCode">

                        <div class="modal-body p-4 bg-light">
                            @if(isset($errors) && $errors->any())
                                <div class="alert alert-danger small mb-3">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger small mb-3">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div id="bookingFormMessage" class="alert d-none small mb-3"></div>
                            {{-- Thông tin người dùng (Lấy tự động nếu đã đăng nhập) --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Họ và tên</label>
                                <input type="text" class="form-control" name="fullname"
                                    value="{{ Auth::check() ? Auth::user()->full_name : '' }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Số điện thoại</label>
                                <input type="tel" class="form-control" name="phone">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                    {{ Auth::check() ? 'readonly' : '' }}>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Ngay khoi hanh</label>
                                    <input type="date" class="form-control" name="departure_date" id="departureDateInput"
                                        value="{{ old('departure_date') }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Ngay ket thuc</label>
                                    <input type="date" class="form-control" name="end_date" id="endDateInput"
                                        value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Mã giảm giá</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-uppercase" id="couponInput" placeholder="Nhập mã coupon">
                                    <button type="button" class="btn btn-outline-primary fw-semibold" id="applyCouponBtn">Áp dụng</button>
                                </div>
                                <div id="couponMessage" class="small mt-2"></div>
                            </div>

                            <div class="mb-3 p-3 bg-white rounded-3 border shadow-sm">
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Tạm tính</span>
                                    <strong id="subtotalText">{{ number_format($tour->price, 0, ',', '.') }}d</strong>
                                </div>
                                <div class="d-flex justify-content-between small text-success mb-2">
                                    <span>Giảm giá</span>
                                    <strong id="discountText">0d</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                    <span class="fw-bold text-dark">Tổng thanh toán</span>
                                    <strong class="text-danger fs-5" id="totalText">{{ number_format($tour->price, 0, ',', '.') }}d</strong>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Phương thức thanh toán</label>
                                <select class="form-select" id="paymentMethodSelect" name="payment_method">
                                    <option value="" selected>-- Chọn phương thức thanh toán --</option>
                                    <option value="Chuyển khoản" >Chuyển khoản QR</option>
                                    <option value="Trực tiếp">Tiền mặt</option>
                                </select>
                            </div>

                            {{-- Khối QR Code linh hoạt --}}
                            <div id="qrCodeBlock" class="mb-3 p-3 bg-white rounded-3 border text-center shadow-sm">
                                <h6 class="fw-bold text-primary mb-2">🏦 QUÉT MÃ QR THANH TOÁN</h6>
                                <img id="paymentQrImage" src="https://img.vietqr.io/image/MB-8000692004-compact2.png?amount={{ $tour->price }}&addInfo=DatTour{{ $tour->id }}" class="img-fluid" alt="QR Thanh toán">
                                <div class="text-start p-2 rounded bg-light" style="font-size: 0.85rem;">
                                    <p class="mb-1">Ngân hàng: <strong>{{ config('payment.bank_name') }}</strong></p>
                                    <p class="mb-1">Số TK: <strong class="text-danger">{{ config('payment.account_number') }}</strong></p>
                                    <p class="mb-0">Chủ TK: <strong>{{ config('payment.account_owner') }}</strong></p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ghi chú hoặc Yêu cầu riêng (Nếu có)</label>
                                <textarea name="note" class="form-control" rows="3" placeholder=""></textarea>
                            </div>
                        </div>

                        <div class="modal-footer border-0 bg-light p-3">
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2" id="bookingSubmitBtn">🚀 XÁC NHẬN ĐẶT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h3 class="text-muted">Thông tin chuyến đi này hiện không khả dụng.</h3>
            <a href="{{ url('/tours') }}" class="btn btn-outline-primary mt-3">Quay lại danh sách</a>
        </div>
    @endif
</div>

{{-- SCRIPT ĐỔI ẢNH CHÍNH & XỬ LÝ ẨN HIỆN BLOCK QR CODE --}}
<script>
function changeImage(imageSrc) {
    document.getElementById('mainImage').src = imageSrc;
}

document.addEventListener("DOMContentLoaded", function () {
    const selectElement = document.getElementById('paymentMethodSelect');
    const qrBlock = document.getElementById('qrCodeBlock');
    const couponInput = document.getElementById('couponInput');
    const applyCouponBtn = document.getElementById('applyCouponBtn');
    const couponMessage = document.getElementById('couponMessage');
    const appliedCouponCode = document.getElementById('appliedCouponCode');
    const discountText = document.getElementById('discountText');
    const totalText = document.getElementById('totalText');
    const paymentQrImage = document.getElementById('paymentQrImage');
    const bookingForm = document.getElementById('bookingForm');
    const bookingSubmitBtn = document.getElementById('bookingSubmitBtn');
    const bookingFormMessage = document.getElementById('bookingFormMessage');
    const departureDateInput = document.getElementById('departureDateInput');
    const endDateInput = document.getElementById('endDateInput');
    const weatherForecast = document.getElementById('weatherForecast');
    const weatherLocationText = document.getElementById('weatherLocationText');
    const subtotal = Number({{ (float) $tour->price }});
    const qrBaseUrl = 'https://img.vietqr.io/image/MB-8000692004-compact2.png';
    const weatherLocation = @json($tour->location ?? $tour->title ?? 'Vietnam');

    function formatMoney(value) {
        return new Intl.NumberFormat('vi-VN').format(Math.max(0, Math.round(value))) + 'd';
    }

    function updatePaymentTotal(discount) {
        const total = Math.max(0, subtotal - discount);
        discountText.textContent = formatMoney(discount);
        totalText.textContent = formatMoney(total);

        if (paymentQrImage) {
            paymentQrImage.src = `${qrBaseUrl}?amount=${Math.round(total)}&addInfo=DatTour{{ $tour->id }}`;
        }
    }

    function normalizeText(value) {
        return String(value || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '');
    }

    function weatherFallback(location) {
        const text = normalizeText(location);
        const places = [
            { keys: ['sapa', 'sa pa', 'fansipan'], name: 'Sa Pa', latitude: 22.3364, longitude: 103.8438 },
            { keys: ['ha noi', 'hanoi'], name: 'Ha Noi', latitude: 21.0278, longitude: 105.8342 },
            { keys: ['ha giang'], name: 'Ha Giang', latitude: 22.8026, longitude: 104.9784 },
            { keys: ['ninh binh'], name: 'Ninh Binh', latitude: 20.2506, longitude: 105.9745 },
            { keys: ['da nang', 'ba na'], name: 'Da Nang', latitude: 16.0471, longitude: 108.2068 },
            { keys: ['hue'], name: 'Hue', latitude: 16.4637, longitude: 107.5909 },
            { keys: ['hoi an'], name: 'Hoi An', latitude: 15.8801, longitude: 108.3380 },
            { keys: ['quy nhon'], name: 'Quy Nhon', latitude: 13.7820, longitude: 109.2190 },
            { keys: ['da lat'], name: 'Da Lat', latitude: 11.9404, longitude: 108.4583 },
            { keys: ['phu quoc'], name: 'Phu Quoc', latitude: 10.2899, longitude: 103.9840 },
            { keys: ['ha long'], name: 'Ha Long', latitude: 20.9712, longitude: 107.0448 },
            { keys: ['ly son'], name: 'Ly Son', latitude: 15.3833, longitude: 109.1167 },
            { keys: ['con dao'], name: 'Con Dao', latitude: 8.6864, longitude: 106.6082 },
            { keys: ['can tho'], name: 'Can Tho', latitude: 10.0452, longitude: 105.7469 },
            { keys: ['vung tau'], name: 'Vung Tau', latitude: 10.4114, longitude: 107.1362 }
        ];

        return places.find(place => place.keys.some(key => text.includes(key)));
    }

    function weatherLabel(code) {
        const labels = {
            0: ['Nang dep', 'fa-sun'],
            1: ['It may', 'fa-cloud-sun'],
            2: ['Co may', 'fa-cloud'],
            3: ['Nhieu may', 'fa-cloud'],
            45: ['Suong mu', 'fa-smog'],
            48: ['Suong mu', 'fa-smog'],
            51: ['Mua phun nhe', 'fa-cloud-rain'],
            53: ['Mua phun', 'fa-cloud-rain'],
            55: ['Mua phun day', 'fa-cloud-rain'],
            61: ['Mua nhe', 'fa-cloud-rain'],
            63: ['Mua vua', 'fa-cloud-showers-heavy'],
            65: ['Mua to', 'fa-cloud-showers-heavy'],
            80: ['Mua rao nhe', 'fa-cloud-rain'],
            81: ['Mua rao', 'fa-cloud-showers-heavy'],
            82: ['Mua rao manh', 'fa-cloud-showers-heavy'],
            95: ['Giong set', 'fa-bolt']
        };

        return labels[code] || ['Dang cap nhat', 'fa-cloud'];
    }

    function renderWeather(data, placeName) {
        const days = (data.daily?.time || []).slice(0, 3);
        const maxTemps = data.daily?.temperature_2m_max || [];
        const minTemps = data.daily?.temperature_2m_min || [];
        const rain = data.daily?.precipitation_probability_max || [];
        const codes = data.daily?.weather_code || [];

        if (!weatherForecast || days.length === 0) {
            return;
        }

        if (weatherLocationText) {
            weatherLocationText.textContent = placeName || weatherLocation;
        }

        weatherForecast.innerHTML = days.map((date, index) => {
            const dayName = new Intl.DateTimeFormat('vi-VN', {
                weekday: 'short',
                day: '2-digit',
                month: '2-digit'
            }).format(new Date(date));
            const [label, icon] = weatherLabel(codes[index]);

            return `
                <div class="weather-day d-flex align-items-center justify-content-between py-2 border-top">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas ${icon} text-primary"></i>
                        <div>
                            <div class="fw-semibold text-dark">${dayName}</div>
                            <div class="text-muted">${label}</div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-danger">${Math.round(maxTemps[index])}°C</div>
                        <div class="text-muted">${Math.round(minTemps[index])}°C | Mua ${rain[index] ?? 0}%</div>
                    </div>
                </div>
            `;
        }).join('');
    }

    async function loadWeather() {
        if (!weatherForecast) {
            return;
        }

        try {
            let place = weatherFallback(weatherLocation);

            if (!place) {
                const geoUrl = `https://geocoding-api.open-meteo.com/v1/search?name=${encodeURIComponent(weatherLocation)}&count=1&language=vi&format=json`;
                const geoResponse = await fetch(geoUrl);
                const geoData = await geoResponse.json();
                const result = geoData.results?.[0];

                if (result) {
                    place = {
                        name: result.name,
                        latitude: result.latitude,
                        longitude: result.longitude
                    };
                }
            }

            if (!place) {
                throw new Error('No weather location found');
            }

            const forecastUrl = `https://api.open-meteo.com/v1/forecast?latitude=${place.latitude}&longitude=${place.longitude}&daily=weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max&timezone=Asia%2FBangkok&forecast_days=3`;
            const forecastResponse = await fetch(forecastUrl);
            const forecastData = await forecastResponse.json();

            renderWeather(forecastData, place.name);
        } catch (error) {
            weatherForecast.innerHTML = '<div class="text-muted">Chua the tai du bao thoi tiet. Vui long thu lai sau.</div>';
        }
    }

    if (selectElement && qrBlock) {
        function toggleQR() {
            if (selectElement.value === 'Chuyển khoản') {
                qrBlock.style.display = 'block';
            } else {
                qrBlock.style.display = 'none';
            }
        }

        // Khởi chạy kiểm tra khi vừa load trang
        toggleQR();

        // Lắng nghe sự thay đổi của Select box phương thức thanh toán
        selectElement.addEventListener('change', toggleQR);
    }

    if (departureDateInput && endDateInput) {
        departureDateInput.addEventListener('change', function () {
            endDateInput.min = departureDateInput.value || '{{ date('Y-m-d') }}';

            if (endDateInput.value && departureDateInput.value && endDateInput.value < departureDateInput.value) {
                endDateInput.value = departureDateInput.value;
            }
        });
    }

    if (applyCouponBtn && couponInput) {
        applyCouponBtn.addEventListener('click', async function () {
            const code = couponInput.value.trim().toUpperCase();
            couponInput.value = code;
            appliedCouponCode.value = '';
            updatePaymentTotal(0);

            if (!code) {
                couponMessage.className = 'small mt-2 text-danger';
                couponMessage.textContent = 'Vui lòng nhập mã giảm giá.';
                return;
            }

            applyCouponBtn.disabled = true;
            applyCouponBtn.textContent = 'Đang kiểm tra...';

            try {
                const response = await fetch('{{ route('coupon.check') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code, subtotal })
                });

                const data = await response.json();

                if (data.success) {
                    appliedCouponCode.value = code;
                    couponMessage.className = 'small mt-2 text-success';
                    couponMessage.textContent = data.msg;
                    updatePaymentTotal(Number(data.discount || 0));
                } else {
                    couponMessage.className = 'small mt-2 text-danger';
                    couponMessage.textContent = data.msg || 'Mã giảm giá không hợp lệ.';
                }
            } catch (error) {
                couponMessage.className = 'small mt-2 text-danger';
                couponMessage.textContent = 'Không thể kiểm tra mã giảm giá. Vui lòng thử lại.';
            } finally {
                applyCouponBtn.disabled = false;
                applyCouponBtn.textContent = 'Áp dụng';
            }
        });
    }

    if (bookingForm && bookingSubmitBtn) {
        bookingForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            bookingSubmitBtn.disabled = true;
            bookingSubmitBtn.textContent = 'Đang gửi đơn...';

            if (bookingFormMessage) {
                bookingFormMessage.className = 'alert alert-info small mb-3';
                bookingFormMessage.textContent = 'Đang gửi thông tin đặt tour, vui lòng chờ...';
            }

            try {
                const response = await fetch(bookingForm.action, {
                    method: 'POST',
                    body: new FormData(bookingForm),
                    headers: {
                        'Accept': 'text/html,application/xhtml+xml'
                    },
                    credentials: 'same-origin'
                });

                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                if (response.ok) {
                    window.location.href = '{{ route('profile') }}';
                    return;
                }

                const text = await response.text();
                throw new Error(text ? 'Không thể tạo đơn đặt tour. Vui lòng kiểm tra lại thông tin.' : 'Không thể tạo đơn đặt tour.');
            } catch (error) {
                if (bookingFormMessage) {
                    bookingFormMessage.className = 'alert alert-danger small mb-3';
                    bookingFormMessage.textContent = error.message || 'Không thể gửi đơn đặt tour. Vui lòng thử lại.';
                }

                bookingSubmitBtn.disabled = false;
                bookingSubmitBtn.textContent = '🚀 XÁC NHẬN ĐẶT';
            }
        });
    }

    loadWeather();
});
</script>

<style>
    /* CSS Định dạng form input đồng bộ */
    .style-input {
        background-color: #ffffff;
        border: 1px solid #ced4da;
        color: #212529;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .style-input:focus {
        border-color: #0f4c81;
        box-shadow: 0 0 0 0.25rem rgba(15, 76, 129, 0.15);
        outline: 0;
    }
    .style-textarea {
        border: 1px solid #ced4da;
    }
    .style-textarea:focus {
        border-color: #0f4c81;
        box-shadow: 0 0 0 0.25rem rgba(15, 76, 129, 0.15);
        outline: 0;
    }

    /* Tối ưu hiển thị cấu trúc Dark Mode */
    body.dark-mode .card, 
    body.dark-mode .bg-white,
    body.dark-mode .modal-content { 
        background-color: #1e1e1e !important; 
        color: #eee !important; 
        border: 1px solid #333 !important; 
    }
    body.dark-mode .modal-header { background: linear-gradient(135deg, #111, #222) !important; }
    body.dark-mode .modal-footer { background-color: #252525 !important; }
    body.dark-mode .text-dark { color: #fff !important; }
    body.dark-mode .text-secondary { color: #bbb !important; }
    body.dark-mode .style-input,
    body.dark-mode .style-textarea { 
        background-color: #2b2b2b !important; 
        color: #fff !important; 
        border: 1px solid #444 !important; 
    }
    body.dark-mode .style-input::placeholder,
    body.dark-mode .style-textarea::placeholder { 
        color: #777 !important; 
    }
    
    .fw-800 { font-weight: 800; }
    .weather-box {
        border-color: #e5e7eb !important;
    }
    .weather-day:first-child {
        border-top: 0 !important;
    }
    body.dark-mode .weather-box {
        background-color: #252525 !important;
        border-color: #444 !important;
    }
    body.dark-mode .weather-day {
        border-color: #444 !important;
    }
    .ratio-16x9 img { transition: transform 0.3s ease; }
    .ratio-16x9 img:hover { transform: scale(1.05); filter: brightness(90%); }
</style>
@endsection
