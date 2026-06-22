@extends('layouts.app')

@section('content')
{{-- BANNER TÌM KIẾM THEO GIAO DIỆN MẪU --}}
<section class="tours-filter-hero text-white position-relative d-flex align-items-center" style="background: linear-gradient(rgba(0, 29, 61, 0.6), rgba(0, 29, 61, 0.7)), url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80') no-repeat center center; background-size: cover; padding: 70px 0;">
    <div class="container text-center text-white position-relative" style="z-index: 5;">
        <span class="text-uppercase tracking-wider small fw-bold opacity-75" style="letter-spacing: 2px;">HÀNH TRÌNH BLUE WAVE</span>
        <h1 class="fw-bold mb-4" style="font-size: 2.5rem;">Khám Phá <span style="color: #00b4d8;">Việt Nam</span></h1>
        
        {{-- FORM TÌM KIẾM CHUNG --}}
        <div class="search-engine-wrap mx-auto bg-blur p-3 rounded-pill shadow-lg" style="max-width: 950px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px);">
            <form action="{{ route('tours.index') }}" method="GET" class="row g-2 align-items-center m-0">
                
                {{-- Lưu lại bộ lọc category hiện tại khi bấm Tìm kiếm trên thanh input --}}
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div class="col-md-4">
                    <div class="input-group bg-white rounded-pill px-3 py-1">
                        <span class="input-group-text bg-transparent border-0 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" name="keyword" class="form-control border-0 bg-transparent text-dark shadow-none" placeholder="Bạn muốn đi đâu?" value="{{ request('keyword') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="select_category" class="form-select bg-white rounded-pill px-3 py-2 border-0 text-muted shadow-none">
                        <option value="">Tất cả vùng miền</option>
                        <option value="Miền Bắc" {{ request('category') == 'Miền Bắc' || request('select_category') == 'Miền Bắc' ? 'selected' : '' }}>Miền Bắc</option>
                        <option value="Miền Trung" {{ request('category') == 'Miền Trung' || request('select_category') == 'Miền Trung' ? 'selected' : '' }}>Miền Trung</option>
                        <option value="Miền Nam" {{ request('category') == 'Miền Nam' || request('select_category') == 'Miền Nam' ? 'selected' : '' }}>Miền Nam</option>
                        <option value="Biển Đảo" {{ request('category') == 'Biển Đảo' || request('select_category') == 'Biển Đảo' ? 'selected' : '' }}>Biển Đảo</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="price_range" class="form-select bg-white rounded-pill px-3 py-2 border-0 text-muted shadow-none">
                        <option value="">Mọi mức giá</option>
                        <option value="0-5" {{ request('price_range') == '0-5' ? 'selected' : '' }}>Dưới 5.000.000đ</option>
                        <option value="5-10" {{ request('price_range') == '5-10' ? 'selected' : '' }}>5.000.000đ - 10.000.000đ</option>
                        <option value="10+" {{ request('price_range') == '10+' ? 'selected' : '' }}>Trên 10.000.000đ</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn text-white w-100 rounded-pill fw-bold py-2 shadow-sm" style="background-color: #c5a059; transition: 0.3s;">TÌM KIẾM</button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- DANH SÁCH TOURS VÀ TABS PHÂN LOẠI --}}
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">
        
        {{-- BỘ TABS PHÂN LOẠI MIỀN (GIỮ NGUYÊN PARAMS TÌM KIẾM CŨ KHI BẤM CHUYỂN TAB) --}}
        <div class="d-flex justify-content-center flex-wrap gap-2 mb-5">
            @php
                $currentParams = request()->except(['category', 'page']);
            @endphp
            
            <a href="{{ route('tours.index', $currentParams) }}" 
               class="btn-region-tab {{ !request('category') ? 'active' : '' }}">
                Tất cả
            </a>
            
            <a href="{{ route('tours.index', array_merge($currentParams, ['category' => 'Miền Bắc'])) }}" 
               class="btn-region-tab {{ request('category') == 'Miền Bắc' ? 'active' : '' }}">
                Miền Bắc
            </a>
            
            <a href="{{ route('tours.index', array_merge($currentParams, ['category' => 'Miền Trung'])) }}" 
               class="btn-region-tab {{ request('category') == 'Miền Trung' ? 'active' : '' }}">
                Miền Trung
            </a>
            
            <a href="{{ route('tours.index', array_merge($currentParams, ['category' => 'Miền Nam'])) }}" 
               class="btn-region-tab {{ request('category') == 'Miền Nam' ? 'active' : '' }}">
                Miền Nam
            </a>
            
            <a href="{{ route('tours.index', array_merge($currentParams, ['category' => 'Biển Đảo'])) }}" 
               class="btn-region-tab {{ request('category') == 'Biển Đảo' ? 'active' : '' }}">
                Biển Đảo
            </a>
        </div>

        {{-- LƯỚI HIỂN THỊ TOUR --}}
        <div class="row">
            @forelse($tours as $tour)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm position-relative style-tour-card">
                        
                        {{-- Khối đa phương tiện của Tour --}}
                        <div class="position-relative overflow-hidden" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <img src="{{ asset('images/' . ($tour->image_url ?? 'default.jpg')) }}" class="w-100 d-block object-fit-cover" style="height: 220px;" alt="{{ $tour->title }}">
                            
                            {{-- Vùng miền Badge ghim góc trái --}}
                            <span class="position-absolute top-0 start-0 m-3 badge rounded-pill px-2 py-1 bg-dark-trans text-white shadow-sm" style="font-size: 0.7rem; background: rgba(0, 29, 61, 0.75);">
                                {{ $tour->category ?? 'Tour Hot' }}
                            </span>

                            {{-- Giá cả Badge đè góc phải dưới ảnh theo mẫu --}}
                            <span class="position-absolute bottom-0 end-0 m-3 badge bg-white rounded-pill text-danger fw-bold shadow" style="font-size: 0.9rem; padding: 6px 14px;">
                                {{ number_format($tour->price) }}đ
                            </span>
                        </div>

                        {{-- Thân Thẻ Giao Diện --}}
                        <div class="card-body d-flex flex-column p-3">
                            <div class="d-flex gap-3 text-muted small mb-2">
                                <span><i class="far fa-clock text-warning me-1"></i> {{ $tour->duration ?? 1 }} Ngày</span>
                                <span class="text-truncate" style="max-width: 140px;"><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $tour->location }}</span>
                            </div>

                            <h6 class="card-title fw-bold text-dark mb-3 text-line-2" style="font-size: 0.95rem; min-height: 2.6rem; line-height: 1.4;">
                                {{ $tour->title }}
                            </h6>

                            <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top border-light">
                                <div class="text-warning small">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <a href="{{ route('tours.show', $tour->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-none border-fix" style="font-size: 0.75rem; border-color: #0077b6; color: #0077b6;">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search-location text-muted mb-3" style="font-size: 3.5rem;"></i>
                    <h5 class="text-muted fw-normal">Không tìm thấy hành trình phù hợp với tiêu chí của bạn.</h5>
                </div>
            @endforelse
        </div>

        {{-- KHỐI PHÂN TRANG BOOTSTRAP CHUẨN --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $tours->links() }}
        </div>

    </div>
</section>
@endsection

@push('styles')
<style>
    /* CSS Định hình cho cấu trúc Tabs Vùng Miền */
    .btn-region-tab {
        padding: 8px 24px;
        border-radius: 30px;
        background-color: #ffffff;
        color: #334155;
        border: 1px solid #e2e8f0;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .btn-region-tab:hover {
        background-color: #f1f5f9;
        color: #001d3d;
    }
    .btn-region-tab.active {
        background-color: #001d3d !important;
        color: #ffffff !important;
        border-color: #001d3d !important;
        box-shadow: 0 4px 12px rgba(0, 29, 61, 0.2);
    }

    /* Bo góc và đổ bóng cho card dựa trên ảnh mẫu */
    .style-tour-card {
        border-radius: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .style-tour-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
    }
    .text-line-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .border-fix:hover {
        background-color: #0077b6 !important;
        color: #fff !important;
    }
</style>
@endpush