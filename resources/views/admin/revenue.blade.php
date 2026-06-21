@extends('admin.layouts.app')
@section('title', 'Báo cáo Doanh thu')
@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .stat-box { background: white; border-radius: 30px; padding: 25px; border-left: 6px solid var(--orange-active); box-shadow: 0 10px 20px rgba(0,0,0,0.02); }
    .filter-card { background: #fff; border-radius: 25px; padding: 25px; margin-bottom: 35px; box-shadow: 0 5px 15px rgba(0,0,0,0.01); }
    .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
    .bg-completed { background: #ebfaf2; color: #1cc88a; }
    .bg-pending { background: #fff1e6; color: #f36d21; }
    .bg-cancelled { background: #ffe5e5; color: #e74a3b; }
    @media print { .sidebar, .filter-card, .btn-print { display: none !important; } .main-content { margin-left: 0; padding: 0; } }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h1 class="dash-title">BÁO CÁO DOANH THU</h1>
        <p class="text-muted">Dữ liệu kinh doanh hệ thống năm {{ $year }}</p>
    </div>
    <button class="btn btn-dark rounded-pill px-4 shadow-sm btn-print" onclick="window.print()"><i class="fas fa-print me-2"></i> Xuất báo cáo</button>
</div>

<div class="filter-card">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">THÁNG</label>
            <select name="month" class="form-select">
                <option value="">-- Tất cả tháng --</option>
                @for($m=1;$m<=12;$m++)
                    <option value="{{ $m }}" @selected($month == $m)>Tháng {{ $m }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-bold text-muted">QUÝ</label>
            <select name="quarter" class="form-select">
                <option value="">-- Tất cả quý --</option>
                <option value="1" @selected($quarter == '1')>Quý 1</option>
                <option value="2" @selected($quarter == '2')>Quý 2</option>
                <option value="3" @selected($quarter == '3')>Quý 3</option>
                <option value="4" @selected($quarter == '4')>Quý 4</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small fw-bold text-muted">NĂM</label>
            <select name="year" class="form-select">
                <option value="2025" @selected($year == '2025')>2025</option>
                <option value="2026" @selected($year == '2026')>2026</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold border-0 shadow-sm" style="background: #f36d21; height:45px;">LỌC DỮ LIỆU</button>
            <a href="{{ route('admin.revenue') }}" class="btn btn-light w-50 rounded-pill fw-bold border-0 shadow-sm d-flex align-items-center justify-content-center">RESET</a>
        </div>
    </form>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="stat-box"><small class="text-muted fw-bold d-block mb-1">DOANH THU BỘ LỌC</small><h2 class="fw-bold m-0" style="color:#f36d21;">{{ number_format($filteredRevenue) }}đ</h2></div>
    </div>
    <div class="col-md-6">
        <div class="stat-box" style="border-left-color:#4e73df;"><small class="text-muted fw-bold d-block mb-1">THÁNG HIỆN TẠI ({{ now()->format('m/Y') }})</small><h2 class="fw-bold m-0" style="color:#4e73df;">{{ number_format($currentMonthRevenue) }}đ</h2></div>
    </div>
</div>

<div class="table-card" style="background:white; border-radius:35px; padding:30px; margin-bottom:30px;">
    <h5 class="fw-bold mb-4 text-muted small"><i class="fas fa-chart-column me-2"></i>XU HƯỚNG DOANH THU 12 THÁNG</h5>
    <div style="height: 300px;"><canvas id="revenueChart"></canvas></div>
</div>

<div class="table-card" style="background:white; border-radius:35px; padding:30px;">
    <h5 class="fw-bold mb-4 text-muted small"><i class="fas fa-list me-2"></i>CÁC ĐƠN HÀNG GẦN ĐÂY</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle border-0">
            <thead class="text-muted small fw-bold text-uppercase">
                <tr><th class="border-0">Khách hàng</th><th class="border-0">Tour</th><th class="border-0">Ngày đặt</th><th class="border-0">Trạng thái</th><th class="border-0 text-end">Thành tiền</th></tr>
            </thead>
            <tbody>
                @forelse($latestOrders as $order)
                <tr>
                    <td class="border-0"><div class="fw-bold text-dark">{{ $order->fullname ?? 'N/A' }}</div><small>#BK-{{ $order->id }}</small></td>
                    <td class="border-0 fw-bold text-primary">{{ $order->tour->title ?? 'Đã xóa' }}</td>
                    <td class="border-0">{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') : 'Chưa có ngày' }}</td>
                    <td class="border-0"><span class="status-badge {{ $order->status == 'Completed' ? 'bg-completed' : ($order->status == 'Cancelled' ? 'bg-cancelled' : 'bg-pending') }}">{{ $order->status == 'Completed' ? 'Thành công' : ($order->status == 'Cancelled' ? 'Đã hủy' : 'Chờ xử lý') }}</span></td>
                    <td class="border-0 text-end fw-bold text-danger">{{ number_format($order->total_amount ?? 0) }}đ</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5 text-muted">Chưa có dữ liệu giao dịch.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: { labels: @json($chartLabels), datasets: [{ label: 'Doanh thu', data: @json($chartData), backgroundColor: '#f36d21', borderRadius: 8, barThickness: 25 }] },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString() + 'đ' } }, x: { grid: { display: false } } } }
});
</script>
@endpush
