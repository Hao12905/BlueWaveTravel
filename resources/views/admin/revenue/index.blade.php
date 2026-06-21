@extends('layouts.admin')

@section('title', 'Thống Kê Doanh Thu - Blue Wave Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="dash-title m-0">BÁO CÁO DOANH THU</h1>
            <p class="text-muted mb-0 mt-1">Dữ liệu kinh doanh hệ thống năm {{ $selectedYear }}</p>
        </div>
        <button class="btn btn-dark rounded-pill px-4 shadow-sm btn-print" onclick="window.print()">
            <i class="fas fa-print me-2"></i> Xuất báo cáo
        </button>
    </div>

    <div class="filter-card">
        <form method="GET" action="{{ url('/admin/revenue') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">THÁNG</label>
                <select name="month" class="form-select">
                    <option value="">-- Tất cả tháng --</option>
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">QUÝ</label>
                <select name="quarter" class="form-select">
                    <option value="">-- Tất cả quý --</option>
                    <option value="1" {{ $selectedQuarter == '1' ? 'selected' : '' }}>Quý 1 (T1-T3)</option>
                    <option value="2" {{ $selectedQuarter == '2' ? 'selected' : '' }}>Quý 2 (T4-T6)</option>
                    <option value="3" {{ $selectedQuarter == '3' ? 'selected' : '' }}>Quý 3 (T7-T9)</option>
                    <option value="4" {{ $selectedQuarter == '4' ? 'selected' : '' }}>Quý 4 (T10-T12)</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold text-muted">NĂM</label>
                <select name="year" class="form-select">
                    <option value="2026" {{ $selectedYear == '2026' ? 'selected' : '' }}>2026</option>
                    <option value="2025" {{ $selectedYear == '2025' ? 'selected' : '' }}>2025</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold border-0 shadow-sm" style="background: var(--orange-active); height: 45px;">
                    LỌC DỮ LIỆU
                </button>
                <a href="{{ url('/admin/revenue') }}" class="btn btn-light w-50 rounded-pill fw-bold border-0 shadow-sm d-flex align-items-center justify-content-center" style="height: 45px;">RESET</a>
            </div>
        </form>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="stat-box">
                <small class="text-muted fw-bold d-block mb-1">DOANH THU BỘ LỌC</small>
                <h2 class="fw-bold m-0" style="color: var(--orange-active);">{{ number_format($filteredRevenue, 0, ',', '.') }}đ</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-box" style="border-left-color: #4e73df;">
                <small class="text-muted fw-bold d-block mb-1">THÁNG HIỆN TẠI ({{ $currentMonth }}/2026)</small>
                <h2 class="fw-bold m-0" style="color: #4e73df;">{{ number_format($monthRevenueFixed, 0, ',', '.') }}đ</h2>
            </div>
        </div>
    </div>

    <div class="table-card mb-4">
        <h5 class="fw-bold mb-4 text-muted small"><i class="fas fa-chart-column me-2"></i>XU HƯỚNG DOANH THU 12 THÁNG</h5>
        <div style="height: 300px; position: relative;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="table-card">
        <h5 class="fw-bold mb-4 text-muted small"><i class="fas fa-list me-2"></i>CÁC ĐƠN HÀNG GẦN ĐÂY</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle border-0 m-0">
                <thead class="text-muted small fw-bold text-uppercase">
                    <tr>
                        <th class="border-0">Khách hàng</th>
                        <th class="border-0">Tour hành trình</th>
                        <th class="border-0">Ngày đặt</th>
                        <th class="border-0">Trạng thái</th>
                        <th class="border-0 text-end">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestOrders as $order)
                        <tr>
                            <td class="border-0">
                                <div class="fw-bold text-dark">{{ $order->fullname ?? ($order->user->name ?? 'Ẩn danh') }}</div>
                                <small class="text-muted">#BK-{{ $order->id }}</small>
                            </td>
                            <td class="border-0 fw-bold text-dark" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $order->tour->title ?? 'Tour không tồn tại hoặc đã xóa' }}
                            </td>
                            <td class="border-0 text-muted">
                                {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') : 'Chưa có ngày' }}
                            </td>
                            <td class="border-0">
                                @php 
                                    $st = $order->status;
                                    $class = ($st == 'Completed' || $st == 'Thành công') ? 'bg-completed' : (($st == 'Cancelled' || $st == 'Đã hủy') ? 'bg-cancelled' : 'bg-pending');
                                    $text = ($st == 'Completed' || $st == 'Thành công') ? 'Thành công' : (($st == 'Cancelled' || $st == 'Đã hủy') ? 'Đã hủy' : 'Chờ xử lý');
                                @endphp
                                <span class="status-badge {{ $class }}">{{ $text }}</span>
                            </td>
                            <td class="border-0 text-end fw-bold text-danger">{{ number_format($order->total_amount ?? 0, 0, ',', '.') }}đ</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted fw-semibold">
                                <i class="fas fa-folder-open fa-2x d-block mb-2 text-light"></i>
                                Chưa có dữ liệu giao dịch phù hợp với bộ lọc.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Doanh thu',
                data: @json($chartData),
                backgroundColor: '#f36d21',
                borderRadius: 8,
                barThickness: 25
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#f1f1f1' }, 
                    ticks: { callback: v => v.toLocaleString() + 'đ', color: '#888' } 
                },
                x: { grid: { display: false }, ticks: { color: '#888' } }
            }
        }
    });
});
</script>
@endpush
