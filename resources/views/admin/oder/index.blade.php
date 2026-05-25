@extends('admin.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="main__title mb-3 rounded">
        Quản lý đơn hàng
    </div>
    <div class="main__content shadow p-3 bg-white rounded">
        <div class="main__table">
            <table class="table table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-center">
                        <th>Mã Phiếu Đặt</th>
                        <th>Mã KH</th>
                        <th>Thời Gian Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="text-center">
                            <td><strong>#{{ $order->MaPhieuDat }}</strong></td>
                            <td>{{ $order->MaKH }}</td>
                            <td>{{ date('d-m-Y', strtotime($order->ThoiGianDat)) }}</td>
                            <td class="text-danger fw-bold">
                                {{ number_format($order->TongTien, 0, ',', '.') }} đ
                            </td>
                            <td>
                                @if($order->TrangThai == 'Hoàn thành')
                                    <span class="badge bg-success">{{ $order->TrangThai }}</span>
                                @elseif($order->TrangThai == 'Đang giao')
                                    <span class="badge bg-primary">{{ $order->TrangThai }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $order->TrangThai }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/admin/orders/delete/'.$order->MaPhieuDat) }}" class="text-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Hiện tại hệ thống chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection