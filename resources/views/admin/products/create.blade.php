@extends('admin.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm rounded border-0 bg-white">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-dark fw-bold border-bottom pb-3">
                        <i class="fas fa-plus-circle text-primary me-2"></i>Thêm Sản Phẩm Mới
                    </h4>

                    <form action="{{ url('/admin/products/store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tên Sản Phẩm Đồng Hồ</label>
                            <input type="text" name="TenSP" class="form-control" placeholder="Nhập tên sản phẩm..." required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Giá Bán (đ)</label>
                            <input type="number" name="Gia" class="form-control" placeholder="Nhập giá bán..." required>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="{{ url('/admin/products') }}" class="btn btn-secondary btn-sm px-3">
                                <i class="fas fa-arrow-left me-1"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                <i class="fas fa-save me-1"></i> Thêm sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection