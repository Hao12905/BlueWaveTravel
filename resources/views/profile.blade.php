@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* CSS tùy chỉnh cho trang Profile để đảm bảo luôn đẹp */
    body { background-color: #f4f7f6; }
    .profile-wrapper { min-height: 100vh; padding-top: 40px; padding-bottom: 60px; }
    
    /* Thiết kế thẻ Glass/Card hiện đại */
    .glass-card { 
        background: #ffffff; 
        border-radius: 24px; 
        box-shadow: 0 10px 40px rgba(0,0,0,0.04); 
        overflow: hidden; 
        border: 1px solid rgba(0,0,0,0.02); 
    }
    
    /* Khu vực Cover & Avatar */
    .cover-bg { 
        background: linear-gradient(135deg, #0077b6, #00b4d8); 
        height: 140px; 
        width: 100%; 
    }
    .cover-bg.role-2 { background: linear-gradient(135deg, #1f2937, #4b5563); }
    .avatar-wrapper { 
        margin-top: -65px; 
        text-align: center; 
        position: relative; 
    }
    .avatar-wrapper img { 
        border: 6px solid #ffffff; 
        box-shadow: 0 8px 20px rgba(0,0,0,0.08); 
        width: 130px; 
        height: 130px; 
        object-fit: cover; 
        background: white;
    }

    /* Thiết kế thẻ Tour History */
    .tour-card { 
        transition: all 0.3s ease; 
        border: 1px solid #f0f0f0; 
        border-radius: 20px; 
    }
    .tour-card:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 12px 30px rgba(0,0,0,0.06); 
        border-color: #e2e8f0;
    }
    .tour-img { 
        width: 100px; 
        height: 100px; 
        border-radius: 16px; 
        object-fit: cover; 
    }

    /* Badge & Label */
    .badge-role-1 { background-color: #e0f2fe; color: #0284c7; }
    .badge-role-2 { background-color: #f3e8ff; color: #7e22ce; }
    .badge-role-0 { background-color: #f1f5f9; color: #475569; }
    
    /* Trạng thái trống (Empty State) */
    .empty-state { 
        border: 2px dashed #cbd5e1; 
        border-radius: 24px; 
        background: #f8fafc; 
        padding: 50px 20px;
    }
</style>

<div class="profile-wrapper">
    <div class="container">
        <div class="row g-5">
            
            {{-- THÔNG TIN TÀI KHOẢN (SIDEBAR) --}}
            <div class="col-lg-4">
                <div class="glass-card pb-4 text-center sticky-top" style="top: 100px;">
                    <div class="cover-bg {{ $user->role == 2 ? 'role-2' : '' }}"></div>
                    
                    <div class="avatar-wrapper">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->full_name) }}&background=random&size=150&bold=true" class="rounded-circle" alt="Avatar">
                    </div>
                    
                    <div class="px-4 mt-3">
                        <h4 class="fw-bold mb-1 text-dark">{{ $user->full_name }}</h4>
                        
                        @php
                            $roleClass = $user->role == 2 ? 'badge-role-2' : ($user->role == 1 ? 'badge-role-1' : 'badge-role-0');
                            $roleText = $user->role == 2 ? 'CHỦ TỊCH' : ($user->role == 1 ? 'QUẢN LÝ' : 'THÀNH VIÊN');
                        @endphp
                        <span class="badge {{ $roleClass }} rounded-pill px-4 py-2 mt-2 mb-4 fs-6 fw-semibold">{{ $roleText }}</span>
                        
                        <div class="d-flex justify-content-center mb-4 border-top pt-4">
                            <div>
                                <h2 class="fw-bolder text-primary mb-0">{{ $user->role >= 1 ? '∞' : number_format($user->points) }}</h2>
                                <span class="text-muted small fw-bold tracking-wide">POINTS</span>
                            </div>
                        </div>
                        
                        {{-- Nút Đăng Xuất --}}
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-light text-danger border-0 fw-bold w-100 rounded-pill py-3 hover-danger shadow-sm">
                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất khỏi hệ thống
                            </button>
                        </form>

                        {{-- Nút quản trị hệ thống chuẩn (Chỉ hiển thị cho Chủ tịch/Admin - Role 2) --}}
                        @if($user->role == 2 || $user->role == 1)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary fw-bold w-100 rounded-pill py-3 mt-3 shadow-sm text-white text-decoration-none d-flex align-items-center justify-content-center">
                                <i class="fas fa-chart-line me-2"></i> Xem báo cáo doanh thu
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- DANH SÁCH ĐƠN HÀNG & LỊCH SỬ --}}
            <div class="col-lg-8">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 fw-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 fw-semibold">
                        {{ session('error') }}
                    </div>
                @endif
                
                {{-- KHU VỰC QUẢN LÝ: ĐƠN CHỜ DUYỆT (Chỉ dành cho Quản lý / Chủ tịch) --}}
                @if($user->role >= 1 && isset($pendingBookings) && $pendingBookings->isNotEmpty())
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="fw-bold text-dark mb-0">Đơn hàng cần xác nhận</h4>
                        <span class="badge bg-danger rounded-pill ms-3 px-3 py-2">{{ $pendingBookings->count() }} đơn chờ</span>
                    </div>
                    
                    <div class="mb-5">
                        @foreach($pendingBookings as $p)
                            <div class="glass-card p-3 mb-3 border-start border-5 border-warning">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="fw-bold text-dark mb-1">{{ $p->user->full_name ?? 'Khách hàng' }}</h6>
                                        <p class="text-muted mb-0">Vừa đặt: <span class="text-dark fw-bold">{{ $p->tour->title ?? 'N/A' }}</span></p>
                                    </div>
                                    <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex flex-column align-items-md-end">
                                        <div class="text-danger fw-bolder fs-5 mb-2">{{ number_format($p->total_amount) }}đ</div>
                                        <a href="{{ route('profile.approve_booking', $p->id) }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm">
                                            <i class="fas fa-check me-1"></i> Duyệt ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- KHU VỰC LỊCH SỬ TOUR CỦA TÀI KHOẢN --}}
                <h4 class="fw-bold text-dark mb-4">Lịch sử đặt tour của tôi</h4>
                
                @if(isset($bookings) && $bookings->isNotEmpty())
                    <div class="d-flex flex-column gap-3">
                        @foreach($bookings as $row)
                            <div class="glass-card tour-card p-3">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        {{-- Xử lý an toàn tránh lỗi crash nếu Tour bị xoá --}}
                                        @if(isset($row->tour) && !empty($row->tour->image_url))
                                            <img src="{{ asset('images/'.$row->tour->image_url) }}" class="tour-img shadow-sm" alt="Tour">
                                        @else
                                            <img src="{{ asset('images/default.jpg') }}" class="tour-img shadow-sm" alt="Default Tour">
                                        @endif
                                    </div>
                                    
                                    <div class="col">
                                        <h5 class="fw-bold text-dark mb-2">{{ $row->tour->title ?? 'Tour đã kết thúc hoặc bị đóng' }}</h5>
                                        @php
                                            $statusClass = $row->status == 'Completed' ? 'bg-success' : ($row->status == 'Pending' ? 'bg-warning text-dark' : 'bg-secondary');
                                            $statusText = $row->status == 'Completed' ? 'Hoàn thành' : ($row->status == 'Pending' ? 'Chờ xác nhận' : $row->status);
                                        @endphp
                                        <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 fw-semibold">{{ $statusText }}</span>
                                        @if(!empty($row->departure_date))
                                            <div class="text-muted small mt-2">
                                                {{ \Carbon\Carbon::parse($row->departure_date)->format('d/m/Y') }}
                                                @if(!empty($row->end_date))
                                                    - {{ \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') }}
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-auto text-end px-4">
                                        <p class="text-muted small fw-bold mb-1">Tổng thanh toán</p>
                                        <h5 class="text-danger fw-bolder mb-0">{{ number_format($row->total_amount) }}đ</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Trạng thái khi tài khoản trống, chưa mua tour nào --}}
                    <div class="empty-state text-center mt-3 shadow-sm">
                        <div class="mb-3">
                            <i class="fas fa-suitcase-rolling fa-3x text-muted opacity-50"></i>
                        </div>
                        <h5 class="text-dark fw-bold mb-2">Bạn chưa có chuyến đi nào</h5>
                        <p class="text-muted mb-4">Hãy bắt đầu hành trình khám phá những vùng đất mới cùng Blue Wave Travel ngay hôm nay!</p>
                        <a href="{{ route('tours.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm">Khám phá Tour</a>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection
