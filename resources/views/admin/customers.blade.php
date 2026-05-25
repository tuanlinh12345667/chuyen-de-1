@extends('admin.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="main__title mb-3 rounded">
        Quản lý khách hàng
    </div>
    <div class="main__content shadow p-3 bg-white rounded">
        <div class="main__top mb-3">
            <div class="input-group">
                <div class="form-outline">
                    <input id="Search" type="text" onkeyup="searchTable()" class="form-control" placeholder="Nhập tên khách hàng" required style="width: 350px"/>
                </div> 
                <button class="btn search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="main__table">
            <table class="table" id="myTable">
                <thead>
                    <tr class="text-center">
                        <th scope="col" onclick="sortTableNumber(0)" class="sort">Mã</th>
                        <th scope="col" onclick="sortTable(1)" class="sort">Tên Khách Hàng</th>
                        <th scope="col">Giới Tính</th>
                        <th scope="col" onclick="sortTableNumber(3)" class="sort">Điện Thoại</th>
                        <th scope="col" onclick="sortTable(4)" class="sort">Địa Chỉ</th>
                        <th colspan="3" style="min-width: 85px;">Tác vụ</th>
                    </tr>
                </thead>    
                <tbody>
                    @foreach($customers as $customer)
                        <tr class="table__row text-center">
                            <td scope="row" style="width:60px !important; padding: 10px 0 !important;">
                                {{ $customer->MaKH }}
                            </td>
                            <td>{{ $customer->TenKH }}</td>
                            <td>{{ $customer->GioiTinh ?? 'N/A' }}</td>
                            <td>{{ $customer->SDT }}</td>
                            <td>{{ $customer->DiaChi ?? 'N/A' }}</td>
                            
                            <td style="padding: 10px 3px !important; width: 27px">
                                <a class="submit" data-id="{{ $customer->MaKH }}" style="color: #4399e3; cursor: pointer;">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
                            
                            <td style="padding: 10px 3px !important; width: 27px">
                                <a href="{{ url('/admin/customers/edit/' . $customer->MaKH) }}" style="color: green;">
                                    <i class="fas fa-tools"></i>
                                </a>
                            </td>
                            
                            <td style="padding: 10px 3px !important; width: 27px">
                                <a href="javascript:Delete_ID('{{ $customer->MaKH }}')" style="color: red;">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 60% !important">
                    <div class="modal-content">
                        <div class="modal-header text-center text-white" style="background-color: #4399e3;">
                            <h5 class="modal-title" id="exampleModalLabel">Chi tiết khách hàng</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>        
$(document).ready(function(){
    $('.submit').click(function(){
        var ID = $(this).data('id');
        $.ajax({
            url: '{{ url("/admin/customers/detail-ajax") }}',
            type: 'POST',
            data: {
                ID: ID,
                _token: '{{ csrf_token() }}'
            },
            success: function(trave){
                $('.modal-body').html(trave);
                $('#exampleModal').modal('show');    
            }
        });
    });
});

// Hàm JavaScript xác nhận xóa khách hàng
function Delete_ID(id)
{
    if(confirm('Bạn có chắc chắn muốn xóa tài khoản khách hàng này khỏi hệ thống không?'))
    {
        window.location.href = "{{ url('/admin/customers/delete') }}/" + id;
    }
}
</script>

<script src="{{ asset('table.js') }}"></script>
@endsection