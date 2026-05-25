

<?php $__env->startSection('admin_content'); ?>
<div class="container-fluid">
    <div class="main__title mb-3 rounded">
        Quản lý phản hồi
    </div>
    <div class="main__content shadow p-3 bg-white rounded">
        <div class="main__top mb-3">
            <div class="input-group" style="max-width: 400px;">
                <input id="Search" type="text" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
                <button class="btn btn-info text-white"><i class="fas fa-search"></i></button>
            </div>
        </div>

        <div class="main__table">
            <table class="table table-hover text-center align-middle" id="myTable">
                <thead class="table-light">
                    <tr>
                        <th>Mã</th>
                        <th>Tên Khách Hàng</th>
                        <th>Email</th>
                        <th>Tiêu đề</th>
                        <th>Tác vụ</th>
                    </tr>
                </thead>    
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="table__row">
                            <td><strong>#<?php echo e($contact->MaLH); ?></strong></td>
                            <td><?php echo e($contact->TenKH); ?></td>
                            <td><?php echo e($contact->Email); ?></td>
                            <td class="text-start"><?php echo e($contact->TieuDe); ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary btn-view-contact" data-id="<?php echo e($contact->MaLH); ?>">
                                    <i class="fas fa-info-circle"></i> Xem
                                </button>
                            </td>
                        </tr> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Hiện tại chưa có phản hồi nào từ khách hàng.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="contactModalLabel"><i class="fas fa-envelope-open-text"></i> Chi tiết nội dung phản hồi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Khách hàng:</strong> <span id="modal-name">Loading...</span></p>
                <p><strong>Email thư:</strong> <span id="modal-email">Loading...</span></p>
                <p><strong>Tiêu đề:</strong> <span id="modal-title">Loading...</span></p>
                <hr>
                <p><strong>Nội dung phản hồi từ khách:</strong></p>
                <div class="p-3 bg-light rounded border italic text-muted" id="modal-content" style="white-space: pre-line;">
                    Loading...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng lại</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Khi người dùng click vào bất kỳ nút "Xem" nào
    $('.btn-view-contact').on('click', function() {
        var contactId = $(document).ready().find(this).data('id');
        
        // Gửi yêu cầu lấy dữ liệu ngầm (AJAX) lên Server Laravel
        $.ajax({
            url: '<?php echo e(url("/admin/contacts")); ?>/' + contactId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.status == 200) {
                    // Đổ dữ liệu thật từ Database nhận được vào các ô tương ứng trong Modal
                    $('#modal-name').text(response.data.TenKH);
                    $('#modal-email').text(response.data.Email);
                    $('#modal-title').text(response.data.TieuDe);
                    
                    // Nếu trong DB của bạn tên cột là NoiDung hoặc NoiDungLH, hãy map cho đúng (mặc định là NoiDung)
                    $('#modal-content').text(response.data.NoiDung ? response.data.NoiDung : 'Không có nội dung chi tiết.');
                    
                    // Kích hoạt hiển thị Modal lên màn hình
                    var myModal = new bootstrap.Modal(document.getElementById('contactModal'));
                    myModal.show();
                } else {
                    alert('Lỗi: ' + response.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra, không thể tải dữ liệu phản hồi này!');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\thanh an\shop-dong-ho\resources\views/admin/contacts.blade.php ENDPATH**/ ?>