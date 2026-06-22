@extends('layouts.admin')

@section('title', 'Quản Lý Đơn Hàng - BLUE WAVE')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0 text-dark" style="letter-spacing: -0.5px;">Danh Sách Đặt Tour</h2>
            <p class="text-muted small m-0 mt-1">Hệ thống xử lý và phê duyệt hóa đơn đặt lịch hành trình trực tuyến.</p>
        </div>
        <div class="bg-white px-3 py-2 rounded-4 shadow-sm border border-light">
            <span class="small text-muted fw-semibold">
                <i class="far fa-calendar-alt me-2 text-primary"></i>Hôm nay: {{ date('d/m/Y') }}
            </span>
        </div>
    </div>
    
    {{-- Thông báo xử lý thành công (Cập nhật trạng thái / Cộng điểm thưởng) --}}
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 shadow-sm px-4 py-3 mb-4" style="border-radius: 16px; background-color: #e6f4ea; color: #137333;">
            <i class="fas fa-check-circle me-3 fs-5"></i>
            <div class="fw-semibold small">{{ session('success') }}</div>
        </div>
    @endif
    
    {{-- Thông báo đẩy chặn quyền Nhân viên - Tránh lỗi khoảng trắng to --}}
    <div class="table-card mt-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle border-0 m-0">
                <thead>
                    <tr class="text-secondary small text-uppercase">
                        <th class="border-0" style="width: 12%">Mã đơn</th>
                        <th class="border-0" style="width: 23%">Khách hàng</th>
                        <th class="border-0" style="width: 25%">Tour đăng ký</th>
                        <th class="border-0" style="width: 15%">Tổng tiền</th>
                        <th class="border-0" style="width: 13%">Trạng thái</th>
                        <th class="border-0 text-end" style="width: 12%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                    <tr>
                        <td class="fw-bold text-dark border-0">#BW-{{ $b->id }}</td>
                        <td class="border-0">
                            <div class="fw-semibold text-dark" style="font-size: 0.95rem;">{{ $b->user->name ?? 'Ẩn danh' }}</div>
                            <small class="text-muted d-block mt-0.5" style="font-size: 0.8rem;">{{ $b->user->email ?? 'Không có email' }}</small>
                        </td>
                        <td class="border-0">
                            <span class="fw-semibold text-dark text-wrap d-block" style="font-size: 0.92rem; max-width: 260px; line-height: 1.4;">
                                {{ $b->tour->title ?? 'Tour đã xóa hoặc ngừng kinh doanh' }}
                            </span>
                            @if(!empty($b->departure_date))
                                <small class="text-muted d-block mt-1">
                                    {{ \Carbon\Carbon::parse($b->departure_date)->format('d/m/Y') }}
                                    @if(!empty($b->end_date))
                                        - {{ \Carbon\Carbon::parse($b->end_date)->format('d/m/Y') }}
                                    @endif
                                </small>
                            @endif
                        </td>
                        <td class="border-0">
                            <span class="fw-bold text-danger" style="font-size: 1.05rem;">
                                {{ number_format($b->total_amount ?? $b->price ?? 0, 0, ',', '.') }}đ
                            </span>
                            @if(!empty($b->coupon_code))
                                <small class="d-block text-success mt-1">
                                    {{ $b->coupon_code }} -{{ number_format($b->discount_amount ?? 0, 0, ',', '.') }}d
                                </small>
                            @endif
                            @if(($b->points_earned ?? 0) > 0)
                                <small class="d-block text-primary mt-1">
                                    +{{ number_format($b->points_earned, 0, ',', '.') }} điểm
                                </small>
                            @endif
                        </td>
                        <td class="border-0">
                            @if($b->status == 'Pending' || $b->status == 'Chờ duyệt') 
                                <span class="badge rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.75rem; background-color: #fef3c7; color: #d97706;">Chờ duyệt</span>
                            @elseif($b->status == 'Completed' || $b->status == 'Thành công') 
                                <span class="badge rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.75rem; background-color: #d1fae5; color: #059669;">Thành công</span>
                            @else 
                                <span class="badge rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.75rem; background-color: #f1f5f9; color: #64748b;">Đã hủy</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap border-0">
                            {{-- ĐÃ CHUẨN HÓA: Chỉ hiển thị nút xử lý nếu đơn đang ở trạng thái Chờ duyệt --}}
                            @if($b->status == 'Pending' || $b->status == 'Chờ duyệt')
                                {{-- Form Duyệt đơn (Đổi sang PUT và gọi route admin.bookings.updateStatus) --}}
                                <form action="{{ route('admin.bookings.updateStatus', $b->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Completed">
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-semibold me-1">Duyệt</button>
                                </form>
                                
                                {{-- Form Hủy đơn (Đổi sang PUT và gọi route admin.bookings.updateStatus) --}}
                                <form action="{{ route('admin.bookings.updateStatus', $b->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('PUT')
                                    <input type="hidden" name="status" value="Cancelled">
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold">Hủy</button>
                                </form>
                            @else
                                <span class="badge bg-light text-muted border px-3 py-2 rounded-pill fw-normal" style="font-size: 0.75rem;">Hoàn tất</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted border-0">
                            <i class="fas fa-inbox fa-3x mb-3 text-light"></i>
                            <p class="m-0 fw-semibold">Hiện chưa có đơn đặt hàng nào trong hệ thống.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Khung hiển thị thanh phân trang chuẩn hóa Bootstrap 5 --}}
        @if(method_exists($bookings, 'hasPages') && $bookings->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top border-light">
                <div class="small text-muted fw-semibold">
                    Hiển thị từ {{ $bookings->firstItem() }} đến {{ $bookings->lastItem() }} của tổng số {{ $bookings->total() }} đơn hàng
                </div>
                <div>
                    {{ $bookings->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
@endsection
