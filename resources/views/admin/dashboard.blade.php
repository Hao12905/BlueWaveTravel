@extends('layouts.admin')

@section('title', 'Blue Wave - Admin Dashboard')

@section('content')
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h1 class="dash-title">DASHBOARD THỐNG KÊ</h1>
            <p class="text-muted mb-0">Chào mừng bạn trở lại, hệ thống đang hoạt động ổn định.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="bg-white d-inline-block p-3 rounded-4 shadow-sm text-center">
                <small class="text-muted fw-bold d-block" style="font-size: 0.6rem; letter-spacing: 0.5px;">HÔM NAY</small>
                <span class="fw-bold text-dark">{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: #fff1e6; color: var(--orange-active);"><i class="fas fa-wallet"></i></div>
                <div>
                    <p class="text-muted fw-bold small mb-1">DOANH THU (ĐÃ XONG)</p>
                    <h3 class="fw-bold m-0" style="color: var(--orange-active);">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h3>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: #eef2ff; color: #4e73df;"><i class="fas fa-shopping-cart"></i></div>
                <div>
                    <p class="text-muted fw-bold small mb-1">BOOKING ĐANG CHỜ</p>
                    <h3 class="fw-bold m-0" style="color: #4e73df;">{{ $newBookings }} đơn</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: #ebfaf2; color: #1cc88a;"><i class="fas fa-box"></i></div>
                <div>
                    <p class="text-muted fw-bold small mb-1">TỔNG SỐ TOUR</p>
                    <h3 class="fw-bold m-0" style="color: #1cc88a;">{{ $totalTours }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold m-0"><i class="fas fa-history me-2" style="color: var(--orange-active);"></i> TOUR MỚI CẬP NHẬT</h5>
            @if(auth()->user()?->role >= 2)
                <a href="{{ route('admin.tours.index') }}" class="text-decoration-none fw-bold small" style="color: var(--orange-active);">XEM TẤT CẢ TOUR ></a>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle border-0">
                <thead class="text-muted small fw-bold">
                    <tr>
                        <th class="border-0">THÔNG TIN TOUR</th>
                        <th class="border-0">GIÁ NIÊM YẾT</th>
                        @if(auth()->user()?->role >= 2)
                            <th class="border-0 text-end">THAO TÁC</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestTours as $tour)
                        <tr>
                            <td class="border-0">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/' . $tour->image_url) }}" 
                                         class="tour-img me-3" 
                                         onerror="this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=80&q=80'">
                                    <div>
                                        <span class="d-block fw-bold text-dark">{{ $tour->title }}</span>
                                        <small class="text-muted">ID: #{{ $tour->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="border-0 fw-bold text-dark">{{ number_format($tour->price, 0, ',', '.') }}đ</td>
                            @if(auth()->user()?->role >= 2)
                                <td class="border-0 text-end">
                                    <a href="{{ route('admin.tours.edit', $tour->id) }}" class="btn-edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()?->role >= 2 ? 3 : 2 }}" class="text-center py-5 text-muted fw-medium">
                                <i class="fas fa-folder-open fa-2x d-block mb-2 text-light"></i>
                                Hệ thống chưa có dữ liệu hành trình tour nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
