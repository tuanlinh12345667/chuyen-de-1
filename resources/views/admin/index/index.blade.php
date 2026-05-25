@extends('admin.admin')

@section('admin_content')
<div class="main__title mb-3 rounded">
    Quản lý sản phẩm
</div>
<div class="main__content shadow p-3 bg-white rounded">
    <div class="main__top d-flex justify-content-between align-items-center mb-3">
        <div>
            <div class="input-group">
                <div class="form-outline">
                    <input id="Search" type="text" onkeyup="searchTable()" class="form-control" placeholder="Nhập tên đồng hồ" required style="width: 350px"/>
                </div> 
                <button class="btn search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div> 
        <a href="{{ url('/admin/products/create') }}">
            <button class="btn__main" style="height: 46.6px;">
                <i class="fas fa-plus"></i> 
                Thêm mới    
            </button>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="main__table">
        <table class="table" id="myTable">
            <thead>
                <tr class="text-center">
                    <th scope="col" onclick="sortTableNumber(0)" class="sort">Mã</th>
                    <th scope="col" onclick="sortTable(1)" class="sort">Tên Đồng Hồ</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col" onclick="sortTable(3)" class="sort">Thương Hiệu</th>
                    <th scope="col" onclick="sortTableNumber(4)" class="sort">Giá</th>
                    <th colspan="3">Tác vụ</th>
                </tr>
            </thead>   
            
            <tbody>
                @foreach($products as $product)
                    <tr class="table__row text-center">
                        <td scope="row" style="width:60px !important; padding: 10px 0 !important;">{{ $product->MaSP }}</td>
                        <td>{{ $product->TenSP }}</td>
                        <td class="img-center">
                            <img class="img-size-s" src="{{ asset('image/' . $product->AnhSP) }}" width="50">
                        </td>
                        <td>{{ $product->ThuongHieu }}</td>
                        <td>{{ number_format(floatval($product->Gia), 0, ',', '.') }} đ</td>
                        
                        <td style="padding: 10px 3px !important; width: 27px">
                            <a class="submit" data-id="{{ $product->MaSP }}" style="color: #4399e3; cursor: pointer;">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </td>
                        
                        <td style="padding: 10px 3px !important; width: 27px">
                            <a href="{{ url('/admin/products/edit/' . $product->MaSP) }}" style="color: green;">
                                <i class="fas fa-tools"></i>
                            </a>
                        </td>
                        
                        <td style="padding: 10px 3px !important; width: 27px">
                            <a href="javascript:Delete_ID('{{ $product->MaSP }}')" style="color: red;">
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
                    <div class="modal-header text-center" style="background-color: var(--color-third);">
                        <h5 class="modal-title" id="exampleModalLabel">Chi tiết đồng hồ</h5>
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

<script>        
// Đoạn Script xử lý bật Modal Chi tiết qua Ajax
$(document).ready(function(){
    $('.submit').click(function(){
        var ID = $(this).data('id');
        $.ajax({
            url: '{{ url("/admin/products/detail-ajax") }}', // Bạn có thể cấu hình route này sau nếu cần thiết
            type: 'POST',
            data: {
                ID: ID,
                _token: '{{ csrf_token() }}' // Cần token bảo mật của Laravel khi dùng POST
            },
            success: function(trave){
                $('.modal-body').html(trave);
                $('#exampleModal').modal('show');    
            }
        });
    });
});

// Hàm JavaScript hỏi trước khi xóa sản phẩm
function Delete_ID(id)
{
    if(confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?'))
    {
        // Chuyển hướng thẳng tới đường dẫn xóa đã đăng ký trong routes/web.php
        window.location.href = "{{ url('/admin/products/delete') }}/" + id;
    }
}
</script>

<script src="{{ asset('table.js') }}"></script>
@endsection