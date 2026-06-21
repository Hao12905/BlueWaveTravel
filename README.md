# BlueWaveTravel
The travel website is written in PHP (Laravel Framework)
# BlueWave Travel

BlueWave Travel là website quản lý và đặt tour du lịch được xây dựng bằng Laravel 12. Hệ thống kết hợp giao diện khách hàng, quy trình đặt tour, mã giảm giá, tích điểm thành viên, thanh toán QR, dự báo thời tiết, liên hệ qua email và khu vực quản trị có phân quyền.

## 1. Mục tiêu hệ thống

Website được thiết kế để giải quyết ba nhóm nhu cầu:

1. **Khách hàng** tìm kiếm tour, xem thông tin hành trình, kiểm tra thời tiết, áp dụng coupon, đặt tour và theo dõi lịch sử.
2. **Quản lý** theo dõi tổng quan, xử lý đơn hàng và xem báo cáo doanh thu.
3. **Admin** quản trị toàn bộ tour, đơn hàng, doanh thu và tài khoản nhân sự.

## 2. Công nghệ sử dụng

- PHP 8.2 trở lên.
- Laravel 12.
- MySQL/MariaDB, phù hợp với XAMPP và phpMyAdmin.
- Blade Template Engine.
- Bootstrap 5.
- Font Awesome.
- JavaScript thuần cho coupon, QR, dark mode, ngôn ngữ và thời tiết.
- Vite, Tailwind CSS và Axios có sẵn trong môi trường frontend.
- Open-Meteo cho dự báo thời tiết, không yêu cầu API key.
- VietQR để tạo mã QR thanh toán theo số tiền đơn hàng.
- Gmail SMTP để gửi yêu cầu liên hệ thật đến email quản trị.

## 3. Phân quyền người dùng

Hệ thống sử dụng cột `role` trong bảng `users`.

| Role | Vai trò | Quyền chính |
|---|---|---|
| `0` | Khách hàng | Xem tour, đặt tour, dùng coupon, xem hồ sơ và điểm thưởng |
| `1` | Quản lý | Xem dashboard, đơn hàng và doanh thu; không được quản lý tour hoặc nhân sự |
| `2` | Admin | Có toàn bộ quyền quản lý tour, đơn hàng, doanh thu và nhân sự |

Hai middleware tùy chỉnh được sử dụng:

- `role:1,2`: cho phép quản lý và admin vào khu vực quản trị chung.
- `admin.role`: chỉ cho phép admin role `2` vào quản lý tour và nhân sự.

Nếu tài khoản không đủ quyền, hệ thống chuyển về trang phù hợp và hiển thị cảnh báo thay vì để người dùng thao tác trái phép.

## 4. Chức năng phía khách hàng

### 4.1 Trang chủ

- Hiển thị tối đa 4 tour mới nhất được đánh dấu `featured = 1`.
- Hero giới thiệu thương hiệu BlueWave Travel.
- Các thông tin nổi bật: an toàn, Travel Points và hỗ trợ 24/7.
- Điều hướng nhanh đến danh sách và chi tiết tour.
- Giao diện responsive cho desktop và mobile.

### 4.2 Trang giới thiệu

- Trình bày câu chuyện thương hiệu, tầm nhìn và sứ mệnh.
- Hiển thị số liệu, giá trị cốt lõi và đội ngũ điều hành.
- Ảnh thành viên được lưu cục bộ trong `public/images`, không phụ thuộc URL ảnh bên ngoài.

### 4.3 Danh sách tour

Khách hàng có thể:

- Xem danh sách tour có phân trang, 8 tour mỗi trang.
- Lọc theo khu vực hoặc danh mục.
- Tìm kiếm theo tên tour hoặc địa điểm.
- Lọc theo khoảng giá:
  - Dưới 5 triệu.
  - Từ 5 đến 10 triệu.
  - Trên 10 triệu.
- Giữ nguyên bộ lọc khi chuyển trang nhờ `appends($request->all())`.

### 4.4 Chi tiết tour

Trang chi tiết hiển thị:

- Tên, danh mục, địa điểm, thời lượng và giá tour.
- Ảnh chính và thư viện ảnh thu nhỏ.
- Mô tả chi tiết hành trình.
- Form đặt tour dạng modal.
- Dự báo thời tiết ba ngày theo địa điểm của tour.

#### Dự báo thời tiết

- Dùng Open-Meteo Geocoding API để đổi tên địa điểm thành tọa độ.
- Dùng Open-Meteo Forecast API để lấy nhiệt độ cao nhất, thấp nhất, khả năng mưa và mã trạng thái thời tiết.
- Có tọa độ dự phòng cho các địa điểm phổ biến như Sa Pa, Hà Nội, Đà Nẵng, Huế, Hội An, Đà Lạt, Phú Quốc, Hạ Long, Lý Sơn và Côn Đảo.
- Khi API lỗi, giao diện hiển thị thông báo nhẹ nhàng và không làm hỏng chức năng đặt tour.

### 4.5 Đăng ký và đăng nhập

#### Đăng ký

- Kiểm tra họ tên, email, mật khẩu và xác nhận mật khẩu.
- Email phải duy nhất.
- Mật khẩu tối thiểu 6 ký tự và được băm bằng Bcrypt.
- Tài khoản mới mặc định:
  - `role = 0`.
  - `points = 0`.
  - Trạng thái hoạt động.
- Sau khi đăng ký, khách hàng được đăng nhập tự động.

#### Đăng nhập

- Hỗ trợ mật khẩu Bcrypt chuẩn Laravel.
- Có cơ chế tương thích tài khoản cũ dùng MD5 hoặc plain text.
- Khi tài khoản cũ đăng nhập thành công, mật khẩu được tự động nâng cấp sang Bcrypt.
- Session được regenerate sau đăng nhập để giảm nguy cơ session fixation.
- Điều hướng theo role:
  - Khách hàng về trang chủ.
  - Quản lý và admin về dashboard.

### 4.6 Đặt tour

Khách hàng phải đăng nhập trước khi đặt tour. Form đặt tour gồm:

- Họ tên.
- Số điện thoại.
- Email tài khoản.
- Ngày khởi hành.
- Ngày kết thúc.
- Mã giảm giá.
- Phương thức thanh toán.
- Ghi chú hoặc yêu cầu riêng.

#### Quy tắc ngày đi

- Ngày khởi hành không được trước ngày hiện tại.
- Ngày kết thúc phải bằng hoặc sau ngày khởi hành.
- JavaScript tự cập nhật ngày tối thiểu của ô ngày kết thúc.
- Backend vẫn validate lại để không phụ thuộc hoàn toàn vào trình duyệt.

#### Quy trình tạo booking

1. Xác thực người dùng và dữ liệu form.
2. Lấy giá gốc từ bảng `tours`, không tin giá do trình duyệt gửi lên.
3. Kiểm tra coupon nếu khách đã áp dụng.
4. Tính tiền giảm và tổng tiền cuối cùng.
5. Mở database transaction.
6. Tạo booking với trạng thái `Pending`.
7. Nếu coupon hợp lệ, tăng `used_count` và ghi `coupon_history`.
8. Commit transaction.
9. Chuyển khách về hồ sơ và hiển thị thông báo thành công.

Nếu coupon không còn hợp lệ tại thời điểm lưu, đơn vẫn được tạo với giá gốc để tránh mất booking của khách.

### 4.7 Mã giảm giá

Coupon hỗ trợ hai loại:

- `percent`: giảm theo phần trăm.
- `fixed`: giảm một số tiền cố định.

Điều kiện kiểm tra coupon:

- Người dùng đã đăng nhập.
- Mã tồn tại và `status = 1`.
- Đơn đạt giá trị tối thiểu `min_order`.
- Người dùng chưa dùng mã trước đó.
- Coupon chưa hết hạn.
- `used_count` chưa đạt `limit_usage`.

Công thức:

```text
Giảm phần trăm = Giá tour × value / 100
Giảm cố định   = value
Tiền giảm thực tế không vượt max_discount
Tổng thanh toán = Giá gốc - Tiền giảm
```

Frontend kiểm tra coupon qua AJAX để cập nhật tiền ngay lập tức. Backend kiểm tra lại trong transaction để tránh sửa dữ liệu trên trình duyệt hoặc sử dụng coupon đồng thời vượt giới hạn.

### 4.8 Thanh toán QR

- Khách có thể chọn chuyển khoản QR hoặc thanh toán trực tiếp.
- QR được tạo bằng VietQR.
- Số tiền trong QR tự thay đổi sau khi áp dụng coupon.
- Nội dung chuyển khoản có mã tour.
- Thông tin ngân hàng nằm trong `config/payment.php`.

Thiết lập hiện tại:

```text
Ngân hàng: MB Bank
Số tài khoản: cấu hình trong config/payment.php
Chủ tài khoản: CONG TY BLUE WAVE TRAVEL
```

Không nên đưa thông tin tài khoản nhạy cảm trực tiếp vào JavaScript nếu triển khai hệ thống thực tế quy mô lớn.

### 4.9 Hồ sơ thành viên

- Hiển thị họ tên, vai trò và tổng Travel Points.
- Hiển thị lịch sử booking của tài khoản.
- Booking được tìm theo `user_id` hoặc email để tương thích dữ liệu cũ.
- Tự liên kết booking cũ chưa có `user_id` nếu email trùng với tài khoản hiện tại.
- Mỗi booking hiển thị tour, trạng thái, ngày đi, ngày kết thúc và tổng thanh toán.
- Nếu tour đã bị xóa, giao diện dùng nội dung và ảnh dự phòng thay vì bị lỗi.

### 4.10 Travel Points

Điểm chỉ được cộng khi đơn chuyển sang trạng thái `Completed`.

```text
Điểm nhận được = floor(Tổng tiền thực trả / 100.000)
```

Ví dụ: đơn 2.950.000 đồng nhận `29` điểm.

Hệ thống lưu:

- `points_earned`: số điểm của booking.
- `points_awarded_at`: thời điểm đã cộng điểm.

`points_awarded_at` ngăn việc cập nhật trạng thái nhiều lần làm cộng điểm trùng.

### 4.11 Liên hệ và gửi email thật

- Khách nhập họ tên, điện thoại, email, chủ đề và nội dung.
- Nội dung được lưu vào bảng `contacts` với `status = 0`.
- Laravel gửi email thông báo qua Gmail SMTP.
- Header `Reply-To` được đặt thành email của khách để quản trị viên có thể bấm trả lời trực tiếp.
- Có email template tại `resources/views/emails/contact-notification.blade.php`.
- Có lệnh kiểm tra SMTP:

```bash
php artisan mail:test-contact
```

Không commit `.env` hoặc Gmail App Password lên GitHub.

### 4.12 Sáng/tối và Anh/Việt

- Nút theme chuyển giữa light mode và dark mode.
- Nút ngôn ngữ chuyển giữa tiếng Việt và tiếng Anh cho các phần giao diện đã khai báo.
- Lựa chọn được lưu bằng `localStorage`, vì vậy vẫn giữ nguyên sau khi tải lại hoặc chuyển trang.
- Logic nằm trong `public/js/bw-preferences.js`.

### 4.13 Chatbot hỗ trợ

- Chatbot nổi được include trong layout frontend.
- Cung cấp phản hồi nhanh về tour, khu vực và các câu hỏi thường gặp.
- Chatbot hiện hoạt động theo dữ liệu/kịch bản JavaScript, chưa tích hợp mô hình AI hoặc dữ liệu thời gian thực từ database.

## 5. Chức năng quản trị

### 5.1 Dashboard

Dashboard hiển thị:

- Tổng doanh thu từ booking `Completed`.
- Số booking đang `Pending`.
- Tổng số tour.
- Năm tour mới nhất.

Quản lý và admin đều truy cập được dashboard.

### 5.2 Quản lý đơn hàng

- Danh sách booking mới nhất, phân trang 10 đơn mỗi trang.
- Hiển thị khách hàng, tour, ngày đi/về, coupon, tiền giảm, tổng tiền, điểm và trạng thái.
- Cập nhật trạng thái trong các giá trị:
  - `Pending`.
  - `Confirmed`.
  - `Completed`.
  - `Cancelled`.
- Khi cập nhật sang `Completed`, hệ thống cộng Travel Points đúng một lần.
- Có thể xóa đơn hàng.

### 5.3 Báo cáo doanh thu

- Chỉ tính booking `Completed`.
- Lọc theo năm.
- Lọc theo tháng hoặc quý.
- Tính tổng doanh thu theo bộ lọc.
- Tạo dữ liệu biểu đồ doanh thu 12 tháng.
- Hiển thị 10 đơn thành công gần nhất theo bộ lọc.

### 5.4 Quản lý tour

Chỉ admin role `2` được sử dụng module này.

- Danh sách tour có phân trang.
- Tìm theo tên hoặc địa điểm.
- Lọc theo danh mục và khoảng giá.
- Thêm tour mới.
- Chỉnh sửa tour.
- Xóa tour.
- Đánh dấu tour nổi bật.
- Upload ảnh `jpeg`, `png`, `jpg` hoặc `webp`, tối đa 2 MB.
- Ảnh được lưu trong `public/images`.
- Khi thay ảnh, hệ thống xóa ảnh cũ nếu file còn tồn tại.
- Khi xóa tour, hệ thống cố gắng xóa luôn ảnh liên quan.

### 5.5 Quản lý nhân sự

Chỉ admin role `2` được truy cập.

- Xem danh sách người dùng, không hiển thị chính tài khoản admin đang đăng nhập.
- Cập nhật role tài khoản.
- Controller kiểm tra role lần nữa ngoài middleware để tăng độ an toàn.

## 6. Vòng đời đơn hàng

```text
Khách chọn tour
    ↓
Nhập thông tin, ngày đi/về, phương thức thanh toán
    ↓
Kiểm tra coupon và tính tổng tiền
    ↓
Tạo booking: Pending
    ↓
Quản lý/Admin xử lý
    ├── Cancelled: đơn bị hủy, không cộng điểm
    ├── Confirmed: đơn đã được xác nhận
    └── Completed: hoàn thành và cộng Travel Points một lần
```

## 7. Cấu trúc database chính

### `users`

Lưu tài khoản, email, mật khẩu, họ tên, số điện thoại, role, trạng thái và điểm tích lũy.

### `tours`

Lưu tên tour, mô tả, mô tả ngắn, giá, thời lượng, địa điểm, danh mục, ảnh và cờ nổi bật.

### `bookings`

Lưu người đặt, tour, ngày khởi hành/kết thúc, phương thức thanh toán, giá gốc, tiền giảm, coupon, tổng tiền, điểm nhận được, trạng thái và ghi chú.

### `coupons`

Lưu mã, loại giảm giá, giá trị, mức giảm tối đa, giá trị đơn tối thiểu, số lượt tối đa, số lượt đã dùng, hạn sử dụng và trạng thái.

### `coupon_history`

Ghi lại người dùng đã sử dụng coupon và thời điểm dùng, phục vụ quy tắc mỗi tài khoản chỉ dùng một mã một lần.

### `contacts`

Lưu họ tên, email, điện thoại, chủ đề, nội dung và trạng thái xử lý yêu cầu liên hệ.

## 8. Quan hệ dữ liệu

```text
User 1 ─── n Booking n ─── 1 Tour
User 1 ─── n CouponHistory
Coupon được tham chiếu trong Booking bằng coupon_code
Contact hoạt động độc lập với tài khoản người dùng
```

## 9. Cấu trúc thư mục quan trọng

```text
app/
├── Http/Controllers/
│   ├── Admin/          # Dashboard, tour, booking, doanh thu, nhân sự
│   ├── Auth/           # Đăng nhập và đăng ký tùy chỉnh
│   └── Frontend/       # Booking, coupon và profile
├── Http/Middleware/    # CheckRole và CheckAdmin
└── Models/             # User, Tour, Booking, Coupon, CouponHistory, Contact

database/migrations/    # Cấu trúc database
public/images/          # Ảnh tour và ảnh giao diện cục bộ
public/js/              # Dark mode và ngôn ngữ
resources/views/
├── admin/              # Giao diện quản trị
├── auth/               # Đăng nhập, đăng ký
├── emails/             # Template email liên hệ
├── layouts/            # Layout frontend/admin/auth
├── home.blade.php
├── tours.blade.php
├── tour-detail.blade.php
├── profile.blade.php
├── contact.blade.php
└── about.blade.php

routes/web.php          # Route website
routes/console.php      # Lệnh test mail
config/payment.php      # Thông tin thanh toán QR
```

## 10. Các route chính

### Công khai

| Method | URL | Chức năng |
|---|---|---|
| GET | `/` | Trang chủ |
| GET | `/tours` | Danh sách và lọc tour |
| GET | `/tours/{id}` | Chi tiết tour |
| GET | `/gioi-thieu` | Giới thiệu |
| GET | `/lien-he` | Form liên hệ |
| POST | `/process-contact` | Lưu và gửi email liên hệ |
| GET/POST | `/login` | Đăng nhập |
| GET/POST | `/register` | Đăng ký |

### Yêu cầu đăng nhập

| Method | URL | Chức năng |
|---|---|---|
| POST | `/booking/store` | Tạo booking |
| POST | `/check-coupon` | Kiểm tra coupon qua AJAX |
| GET | `/profile` | Hồ sơ và lịch sử booking |
| POST | `/profile/update` | Cập nhật hồ sơ |
| POST | `/logout` | Đăng xuất |

### Quản trị

| URL | Role tối thiểu | Chức năng |
|---|---:|---|
| `/admin/dashboard` | 1 | Tổng quan |
| `/admin/bookings` | 1 | Quản lý đơn hàng |
| `/admin/revenue` | 1 | Báo cáo doanh thu |
| `/admin/tours` | 2 | CRUD tour |
| `/admin/users` | 2 | Quản lý nhân sự |

## 11. Cài đặt trên XAMPP

### Yêu cầu

- XAMPP có PHP 8.2 trở lên.
- MySQL đang chạy.
- Composer.
- Node.js và npm nếu cần build asset bằng Vite.

### Các bước

```bash
cd C:\xampp\htdocs\travel-web
composer install
copy .env.example .env
php artisan key:generate
```

Cấu hình MySQL trong `.env`:

```env
APP_NAME="Blue Wave Travel"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=travel_db
DB_USERNAME=root
DB_PASSWORD=
```

Tạo database `travel_db` trong phpMyAdmin, sau đó chạy:

```bash
php artisan migrate
php artisan optimize:clear
php artisan serve
```

Mở website:

```text
http://127.0.0.1:8000
```

Nếu sử dụng Vite:

```bash
npm install
npm run dev
```

## 12. Cấu hình Gmail SMTP

Tài khoản Gmail gửi mail phải bật xác minh hai bước và tạo App Password 16 ký tự.

```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_gmail_app_password
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Blue Wave Travel"
```

Sau khi thay `.env`:

```bash
php artisan optimize:clear
php artisan mail:test-contact
```

Không sử dụng mật khẩu Gmail thông thường và không đưa App Password vào README, source code hoặc Git.

## 13. Lệnh thường dùng

```bash
# Chạy server
php artisan serve

# Chạy migration
php artisan migrate

# Xóa cache Laravel
php artisan optimize:clear

# Xem route
php artisan route:list

# Test email liên hệ
php artisan mail:test-contact

# Chạy test
php artisan test

# Build frontend
npm run build
```

## 14. Bảo mật và tính toàn vẹn dữ liệu

- Form POST sử dụng CSRF token.
- Mật khẩu mới được băm bằng Bcrypt.
- Session được regenerate sau đăng nhập.
- Route admin được bảo vệ bằng `auth`, `role` và `admin.role`.
- Giá tour được lấy lại từ database khi tạo booking.
- Coupon được kiểm tra cả frontend và backend.
- Quá trình tạo booking, tăng lượt coupon và lưu lịch sử coupon dùng database transaction.
- Điểm thưởng có dấu thời gian để tránh cộng trùng.
- Upload ảnh giới hạn định dạng và dung lượng.
- Email khách được dùng làm `Reply-To`, không dùng làm địa chỉ `From` SMTP.

## 15. Lưu ý kỹ thuật hiện tại

- Bản dịch Anh/Việt hiện dùng JavaScript và chỉ áp dụng cho những nội dung đã khai báo trong `bw-preferences.js`; nội dung tour từ database chưa có bảng dịch riêng.
- Chatbot hiện là chatbot theo kịch bản, chưa phải chatbot AI.
- Thanh toán QR hỗ trợ tạo mã chuyển khoản nhưng chưa tự động đối soát giao dịch ngân hàng.
- Dự báo thời tiết phụ thuộc kết nối internet và dịch vụ Open-Meteo.
- Một số route legacy vẫn còn trong `routes/web.php`; luồng đặt tour chính hiện dùng `/booking/store`.
- Không commit `.env`, thông tin SMTP, App Password hoặc thông tin nhạy cảm lên repository công khai.

## 16. Hướng phát triển

- Tích hợp cổng thanh toán có webhook để tự động xác nhận giao dịch.
- Tạo module quản lý coupon trong admin thay vì thao tác trực tiếp bằng phpMyAdmin.
- Cho phép khách dùng Travel Points để giảm giá đơn tiếp theo.
- Gửi email xác nhận booking và email khi trạng thái thay đổi.
- Xây dựng hệ thống đa ngôn ngữ Laravel chuẩn bằng file `lang/` và dữ liệu tour đa ngôn ngữ.
- Cache dự báo thời tiết để giảm số lần gọi API.
- Thêm đánh giá tour, wishlist và thông báo trong hệ thống.
- Thêm test Feature cho đăng nhập, coupon, booking, phân quyền và tích điểm.

---

**BlueWave Travel** — nền tảng đặt tour, quản lý hành trình và chăm sóc thành viên trong một hệ thống thống nhất.
