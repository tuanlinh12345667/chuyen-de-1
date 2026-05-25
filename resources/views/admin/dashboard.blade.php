@extends('admin.admin')

@section('admin_content')
<div class="container-fluid mt-3">
    <div class="row g-3 mb-3 text-white">
        <div class="col-md-4">
            <div class="p-4 rounded d-flex align-items-center justify-content-between shadow-sm" style="background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);">
                <div class="fs-1"><i class="far fa-clock"></i></div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0">{{ $dongHoDaBan }}</h2>
                    <small>Số lượng đồng hồ bán ra</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded d-flex align-items-center justify-content-between shadow-sm" style="background: linear-gradient(to right, #ff0844 0%, #ffb199 100%);">
                <div class="fs-1"><i class="far fa-clock"></i></div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0">{{ $thuongHieuUaChuong }}</h2>
                    <small>Thương hiệu ưa chuộng</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded d-flex align-items-center justify-content-between shadow-sm" style="background: linear-gradient(to right, #2af598 0%, #009efd 100%);">
                <div class="fs-1"><i class="far fa-clock"></i></div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0">{{ $thuongHieuDongHanh }}</h2>
                    <small>Thương hiệu đồng hành</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3 text-white">
        <div class="col-md-4">
            <div class="p-4 rounded d-flex align-items-center justify-content-between shadow-sm" style="background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);">
                <div class="fs-1"><i class="far fa-clock"></i></div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0">{{ $khachHangQuayLai }}</h2>
                    <small>Khách hàng quay trở lại</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded d-flex align-items-center justify-content-between shadow-sm" style="background: linear-gradient(to right, #ff0844 0%, #ffb199 100%);">
                <div class="fs-1"><i class="far fa-clock"></i></div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0">{{ $doTuoiMuaNhieu }}</h2>
                    <small>Độ tuổi mua nhiều nhất</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded d-flex align-items-center justify-content-between shadow-sm" style="background: linear-gradient(to right, #2af598 0%, #009efd 100%);">
                <div class="fs-1"><i class="far fa-clock"></i></div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0">{{ number_format($tongDoanhThu, 0, ',', '.') }}</h2>
                    <small>Tổng doanh thu (đ)</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 text-white">
        <div class="col-md-4">
            <div class="p-4 rounded d-flex align-items-center justify-content-between shadow-sm" style="background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);">
                <div class="fs-1"><i class="far fa-clock"></i></div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0">{{ $tongDonHang }}</h2>
                    <small>Tổng đơn hàng</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded d-flex align-items-center justify-content-between shadow-sm" style="background: linear-gradient(to right, #ff0844 0%, #ffb199 100%);">
                <div class="fs-1"><i class="far fa-clock"></i></div>
                <div class="text-end">
                    <h2 class="fw-bold mb-0">{{ $donChuaHoanThanh }}</h2>
                    <small>Đơn hàng chưa hoàn thành</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection