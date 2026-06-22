@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h1 style="font-weight: 900; font-style: italic; font-size: 2.2rem; color: #1e1e1e; margin: 0;">DANH SÁCH TOUR</h1>
        <p class="text-muted m-0">Tổng số hiện có: <strong>{{ $tours->total() }}</strong> gói du lịch đang kinh doanh.</p>
    </div>
    <a href="{{ route('admin.tours.create') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">
        <i class="fas fa-plus me-2"></i> THÊM TOUR MỚI
    </a>
</div>

<div class="card border-0 p-4 mb-4 shadow-sm" style="border-radius: 20px; background: #fff;">
    <form action="{{ route('admin.tours.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <select name="category" class="form-select rounded-pill px-3">
                <option value="">-- Tất cả vùng miền --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ $category_filter == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" name="keyword" class="form-control rounded-pill px-3" placeholder="Tìm kiếm tên tour hoặc địa điểm..." value="{{ $search_query }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn text-white rounded-pill w-100 fw-bold shadow-sm" style="background-color: #f36d21;">
                <i class="fas fa-filter me-2"></i> LỌC
            </button>
        </div>
    </form>
</div>

<div class="card border-0" style="background: white; border-radius: 35px; padding: 30px; box-shadow: 0 10px 20px rgba(0,0,0,0.02);">
    <div class="table-responsive">
        <table class="table table-hover align-middle border-0">
            <thead class="text-muted small fw-bold">
                <tr>
                    <th class="border-0">THÔNG TIN TOUR</th>
                    <th class="border-0">DANH MỤC</th>
                    <th class="border-0">GIÁ NIÊM YẾT</th>
                    <th class="border-0">NGÀY TẠO</th>
                    <th class="border-0 text-end">HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tours as $tour)
                <tr>
                    <td class="border-0">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/' . $tour->image_url) }}" class="me-3" style="width: 60px; height: 60px; object-fit: cover; border-radius: 15px; border: 1px solid #f0f0f0;" onerror="this.src='https://via.placeholder.com/60?text=No+Img'">
                            <div>
                                <b class="d-block text-dark">{{ $tour->title }}</b>
                                <small class="text-muted">Mã: #{{ $tour->id }} | <i class="fas fa-map-marker-alt"></i> {{ $tour->location }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="border-0">
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 fw-semibold border">{{ $tour->category }}</span>
                    </td>
                    <td class="border-0 fw-bold">
                        <span style="color: #f36d21;">{{ number_format($tour->price, 0, ',', '.') }}đ</span>
                    </td>
                    <td class="border-0 text-muted small">
                        {{ $tour->created_at ? \Carbon\Carbon::parse($tour->created_at)->format('d/m/Y') : '08/01/2026' }}
                    </td>
                    <td class="border-0 text-end">
                        <a href="{{ route('admin.tours.edit', $tour->id) }}" class="btn btn-sm btn-light rounded-pill me-1 shadow-sm px-3">
                            <i class="fas fa-pen me-1"></i> Sửa
                        </a>
                        <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa tour này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill shadow-sm px-3">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">Không tìm thấy dữ liệu tour nào phù hợp.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4 custom-pagination">
        {{ $tours->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
    .custom-pagination .page-link { border: none; color: #1e1e1e; border-radius: 10px; margin: 0 3px; font-weight: 600; background: #f0f0f0; }
    .custom-pagination .page-item.active .page-link { background: #f36d21 !important; color: white !important; }
</style>
@endsection
