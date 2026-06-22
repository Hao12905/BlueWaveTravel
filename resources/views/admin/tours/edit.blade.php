@extends('layouts.admin')

@section('title', 'Sua Tour - BLUE WAVE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold m-0 text-dark">SỬA TOUR</h1>
        <p class="text-muted m-0">Cập nhật thông tin gói du lịch #{{ $tour->id }}.</p>
    </div>
    <a href="{{ route('admin.tours.index') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">
        <i class="fas fa-arrow-left me-2"></i> Quay lại
    </a>
</div>

@if(isset($errors) && $errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-4">
        <div class="fw-bold mb-1">Không thể cập nhật tour</div>
        <div>{{ $errors->first() }}</div>
    </div>
@endif

<div class="card border-0 shadow-sm p-4" style="border-radius: 24px;">
    <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên tour</label>
                    <input type="text" name="title" class="form-control rounded-3" value="{{ old('title', $tour->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mô tả ngắn</label>
                    <input type="text" name="short_desc" class="form-control rounded-3" value="{{ old('short_desc', $tour->short_desc) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mô tả chi tiết</label>
                    <textarea name="description" class="form-control rounded-3" rows="7" required>{{ old('description', $tour->description) }}</textarea>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Giá tour</label>
                    <input type="number" name="price" class="form-control rounded-3" min="0" step="1000" value="{{ old('price', $tour->price) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Thời gian</label>
                    <input type="text" name="duration" class="form-control rounded-3" value="{{ old('duration', $tour->duration) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Địa điểm</label>
                    <input type="text" name="location" class="form-control rounded-3" value="{{ old('location', $tour->location) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Danh mục</label>
                    <select name="category" class="form-select rounded-3" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $tour->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Ảnh đại diện</label>
                    @if($tour->image_url)
                        <img src="{{ asset('images/' . $tour->image_url) }}" class="img-fluid rounded-4 border mb-2" style="height: 160px; width: 100%; object-fit: cover;" alt="Tour">
                    @endif
                    <input type="file" name="image_url" class="form-control rounded-3" accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="text-muted">Để trống nếu muốn giữ ảnh hiện tại.</small>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" name="featured" value="1" id="featuredSwitch" {{ old('featured', $tour->featured) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="featuredSwitch">Tour nổi bật</label>
                </div>

                <button type="submit" class="btn text-white w-100 rounded-pill py-3 fw-bold shadow-sm" style="background-color: #f36d21;">
                    <i class="fas fa-save me-2"></i> Cập nhật tour
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
