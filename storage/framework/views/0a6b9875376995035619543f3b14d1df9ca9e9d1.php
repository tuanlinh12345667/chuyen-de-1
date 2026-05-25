

<?php $__env->startSection('admin_content'); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="text-center">
                            <td><strong>#<?php echo e($order->MaPhieuDat); ?></strong></td>
                            <td><?php echo e($order->MaKH); ?></td>
                            <td><?php echo e(date('d-m-Y', strtotime($order->ThoiGianDat))); ?></td>
                            <td class="text-danger fw-bold">
                                <?php echo e(number_format($order->TongTien, 0, ',', '.')); ?> đ
                            </td>
                            <td>
                                <?php if($order->TrangThai == 'Hoàn thành'): ?>
                                    <span class="badge bg-success"><?php echo e($order->TrangThai); ?></span>
                                <?php elseif($order->TrangThai == 'Đang giao'): ?>
                                    <span class="badge bg-primary"><?php echo e($order->TrangThai); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark"><?php echo e($order->TrangThai); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(url('/admin/orders/delete/'.$order->MaPhieuDat)); ?>" class="text-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Hiện tại hệ thống chưa có đơn hàng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\thanh an\shop-dong-ho\resources\views/admin/oder/index.blade.php ENDPATH**/ ?>