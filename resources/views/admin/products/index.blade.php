@extends('admin.admin') {{-- Gọi chính xác file admin.blade.php nằm trong thư mục admin làm khung --}}

@section('admin_content') {{-- Đổ nội dung khớp vào vùng trống admin_content trong file gốc của bạn --}}
<div class="container-fluid">
    <div class="card shadow-sm rounded border-0 bg-white">
        <div class="card-body p-4">
            
            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                <h4 class="mb-0 text-dark fw-bold text-uppercase" style="font-size: 18px;">
                    <i class="fas fa-clock text-primary me-2"></i>Danh Sách Quản Lý Sản Phẩm
                </h4>
                <a class="btn btn-primary btn-sm px-3 py-2" href="/admin/products/create">
                    <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 100px;">Mã SP</th>
                            <th>Tên Sản Phẩm Đồng Hồ</th>
                            <th style="width: 200px;">Giá Bán Hiện Tại</th>
                            <th style="width: 220px;">Hành Động</th>
                        </tr>
                    </thead>
 <tbody>
                        @forelse($products as $item)
                        <tr>
                            <td class="text-center fw-bold text-secondary">#{{ $item->MaSP }}</td>
                            <td class="fw-semibold text-dark">{{ $item->TenSP }}</td>
                            <td class="text-danger fw-bold text-end pe-4">{{ number_format($item->Gia ?? 0) }} đ</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-warning text-dark me-1 px-3" href="{{ url('/admin/products/edit/'.$item->MaSP) }}">
                                    <i class="fas fa-edit me-1"></i> Sửa
                                </a>
                                <a class="btn btn-sm btn-danger px-3" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')" href="{{ url('/admin/products/delete/'.$item->MaSP) }}">
                                    <i class="fas fa-trash me-1"></i> Xóa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                Cơ sở dữ liệu hiện tại chưa có sản phẩm nào!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection