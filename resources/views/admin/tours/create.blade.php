@extends('layouts.admin')

@section('title', 'Them Tour - BLUE WAVE')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold m-0 text-dark">THÊM TOUR MỚI</h1>
        <p class="text-muted m-0">Nhập thông tin tour mới để hiển thị trên website.</p>
    </div>
    <a href="{{ route('admin.tours.index') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">
        <i class="fas fa-arrow-left me-2"></i> Quay lại
    </a>
</div>

@if(isset($errors) && $errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-4">
        <div class="fw-bold mb-1">Không thể thêm tour</div>
        <div>{{ $errors->first() }}</div>
    </div>
@endif

<div class="card border-0 shadow-sm p-4" style="border-radius: 24px;">
    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên tour</label>
                    <input type="text" name="title" class="form-control rounded-3" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mô tả ngắn</label>
                    <input type="text" name="short_desc" class="form-control rounded-3" value="{{ old('short_desc') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mô tả chi tiết</label>
                    <textarea name="description" class="form-control rounded-3" rows="7" required>{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Giá tour</label>
                    <input type="number" name="price" class="form-control rounded-3" min="0" step="1000" value="{{ old('price') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Thời gian</label>
                    <input type="text" name="duration" class="form-control rounded-3" value="{{ old('duration') }}" placeholder="VD: 3 ngay 2 dem" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Địa điểm</label>
                    <input type="text" name="location" class="form-control rounded-3" value="{{ old('location') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Danh mục</label>
                    <select name="category" class="form-select rounded-3" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Ảnh đại diện</label>
                    <input type="file" name="image_url" class="form-control rounded-3" accept="image/jpeg,image/png,image/jpg,image/webp" required>
                    <small class="text-muted">Chấp nhận jpeg, png, jpg, webp. Tối đa 2MB.</small>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" name="featured" value="1" id="featuredSwitch" {{ old('featured') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="featuredSwitch">Tour nổi bật</label>
                </div>

                <button type="submit" class="btn text-white w-100 rounded-pill py-3 fw-bold shadow-sm" style="background-color: #f36d21;">
                    <i class="fas fa-save me-2"></i> Lưu tour
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
