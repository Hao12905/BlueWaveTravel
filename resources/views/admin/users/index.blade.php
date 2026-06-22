@extends('layouts.admin')

@section('title', 'Quản Lý Nhân Sự - BLUE WAVE')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0 text-dark" style="letter-spacing: -0.5px;">CẤP QUYỀN & PHÂN NHÂN SỰ</h2>
            <p class="text-muted small m-0 mt-1">Quản lý danh sách tài khoản, phân quyền hạn và chức vụ trong hệ thống.</p>
        </div>
        <div class="bg-white px-3 py-2 rounded-4 shadow-sm border border-light">
            <span class="small text-muted fw-semibold">
                <i class="far fa-calendar-alt me-2 text-primary"></i>Hôm nay: {{ date('d/m/Y') }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 shadow-sm px-4 py-3 mb-4" style="border-radius: 16px; background-color: #e6f4ea; color: #137333;">
            <i class="fas fa-check-circle me-3 fs-5"></i>
            <div class="fw-semibold small">{{ session('success') }}</div>
        </div>
    @endif

    <div class="table-card mt-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle border-0 m-0">
                <thead>
                    <tr class="text-secondary small text-uppercase">
                        <th class="border-0">Họ và tên</th>
                        <th class="border-0">Email đăng ký</th>
                        <th class="border-0">Quyền hạn hiện tại</th>
                        <th class="border-0 text-end">Thay đổi chức vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="fw-bold text-dark border-0">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2 bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold" style="width: 35px; height: 35px; font-size: 0.85rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted border-0">{{ $user->email }}</td>
                        <td class="border-0">
                            @if($user->role == 2) 
                                <span class="badge rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.75rem; background-color: #fce8e6; color: #c5221f;">Chủ tịch (Admin)</span>
                            @elseif($user->role == 1) 
                                <span class="badge rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.75rem; background-color: #e8f0fe; color: #1a73e8;">Quản lý (Staff)</span>
                            @else 
                                <span class="badge rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.75rem; background-color: #f1f5f9; color: #64748b;">Khách hàng</span>
                            @endif
                        </td>
                        <td class="text-end border-0">
                            <form action="{{ url('/admin/users/'.$user->id.'/update-role') }}" method="POST" class="d-inline-block">
                                @csrf
                                <div class="input-group input-group-sm border rounded-pill overflow-hidden bg-light" style="max-width: 240px; margin-left: auto;">
                                    <select name="role" class="form-select border-0 bg-transparent px-3 py-1.5 small text-dark fw-medium" style="outline: none; box-shadow: none;">
                                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Khách hàng</option>
                                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Quản lý</option>
                                        <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Chủ tịch</option>
                                    </select>
                                    <button type="submit" class="btn btn-dark px-3 fw-semibold small border-0" style="background-color: #1e1e1e;">Cập nhật</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted border-0">
                            <i class="fas fa-users fa-3x mb-3 text-light"></i>
                            <p class="m-0 fw-semibold">Hệ thống chưa ghi nhận tài khoản nhân sự nào.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Khung hiển thị thanh phân trang nếu dữ liệu phân trang có tồn tại --}}
        @if(method_exists($users, 'hasPages') && $users->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top border-light">
                <div class="small text-muted fw-semibold">
                    Hiển thị từ {{ $users->firstItem() }} đến {{ $users->lastItem() }} của tổng số {{ $users->total() }} người dùng
                </div>
                <div>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
@endsection