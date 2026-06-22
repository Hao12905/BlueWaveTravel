<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blue Wave - Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --bg-main: #fdfaf7; --sidebar-bg: #1e1e1e; --orange-active: #f36d21; --text-gray: #a0a0a0; }
        body { background-color: var(--bg-main); font-family: 'Segoe UI', sans-serif; margin: 0; }

        /* Sidebar Styles */
        .sidebar { width: 260px; height: 100vh; background: var(--sidebar-bg); position: fixed; left: 0; top: 0; padding: 25px; color: white; z-index: 1000; }
        .logo-area { display: flex; align-items: center; margin-bottom: 40px; }
        .logo-icon { background: var(--orange-active); width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 15px; }
        .nav-menu { list-style: none; padding: 0; }
        .nav-link-custom { display: flex; align-items: center; padding: 12px 20px; color: var(--text-gray); text-decoration: none; border-radius: 15px; margin-bottom: 5px; transition: 0.3s; }
        .nav-link-custom.active { background: var(--orange-active); color: white; }
        .nav-link-custom:hover:not(.active) { background: rgba(255,255,255,0.05); color: white; }
        .nav-link-home { color: #5cb85c !important; font-weight: bold; margin-bottom: 20px; border: 1px solid #5cb85c; }
        .nav-link-home:hover { background: #5cb85c !important; color: white !important; }

        /* Main Content Styles */
        .main-content { margin-left: 260px; padding: 40px; }
        .dash-title { font-weight: 900; font-style: italic; font-size: 2.2rem; color: #1e1e1e; }
        
        /* Elements Cards */
        .stat-card { background: white; border-radius: 35px; padding: 30px; display: flex; align-items: center; box-shadow: 0 10px 20px rgba(0,0,0,0.02); border: none; height: 100%; }
        .stat-icon { width: 55px; height: 55px; border-radius: 18px; margin-right: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .table-card { background: white; border-radius: 35px; padding: 30px; margin-top: 35px; border: none; box-shadow: 0 10px 20px rgba(0,0,0,0.02); }
        .tour-img { width: 55px; height: 55px; border-radius: 15px; object-fit: cover; background: #eee; }
        .btn-edit { width: 35px; height: 35px; border-radius: 12px; border: none; background: #f5f5f5; color: #888; transition: 0.3s; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; }
        .btn-edit:hover { background: var(--orange-active); color: white; }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar">
    <div class="logo-area">
        <div class="logo-icon"><i class="fas fa-water"></i></div>
        <div class="logo-text">
            <h5 class="m-0 fw-bold">BLUE WAVE</h5>
            <span style="font-size: 0.7rem; color: var(--orange-active); font-weight: bold;">ADMIN BW</span>
        </div>
    </div>
    <ul class="nav-menu">
        <li><a href="{{ url('/') }}" class="nav-link-custom nav-link-home"><i class="fas fa-home me-2"></i> Trang chủ Web</a></li>
        
        <li><a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ Route::is('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-th-large me-2"></i> Tổng quan</a></li>
        
        <li><a href="{{ route('admin.tours.index') }}" class="nav-link-custom {{ Route::is('admin.tours.*') ? 'active' : '' }}"><i class="fas fa-map-marked-alt me-2"></i> Quản lý Tour</a></li>
        
        <li><a href="{{ route('admin.bookings.index') }}" class="nav-link-custom {{ Route::is('admin.bookings.*') ? 'active' : '' }}"><i class="fas fa-shopping-cart me-2"></i> Đơn hàng</a></li>
        
        <li><a href="{{ route('admin.revenue') }}" class="nav-link-custom {{ Route::is('admin.revenue') ? 'active' : '' }}"><i class="fas fa-chart-line me-2"></i> Doanh thu</a></li>
        
        <li><a href="{{ route('admin.users.index') }}" class="nav-link-custom {{ Route::is('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users-cog me-2"></i> Quản lý Nhân sự</a></li>
        
        <li class="mt-4">
            <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">@csrf</form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link-custom text-danger">
                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
            </a>
        </li>
    </ul>
</div>

<div class="main-content">
    @if(session('error_alert'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background-color: #f8d7da; color: #842029;">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Cảnh báo:</strong> {{ session('error_alert') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

    @stack('scripts')
</body>
</html>
