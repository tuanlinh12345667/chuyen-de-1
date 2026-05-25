 

<?php $__env->startSection('admin_content'); ?> 
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm rounded border-0 bg-white">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-dark fw-bold border-bottom pb-3">
                        <i class="fas fa-edit text-warning me-2"></i>Cập Nhật Sản Phẩm #<?php echo e($product->MaSP); ?>

                    </h4>

                    <form action="<?php echo e(url('/admin/products/update/'.$product->MaSP)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tên Sản Phẩm Đồng Hồ</label>
                            <input type="text" name="TenSP" class="form-control" value="<?php echo e($product->TenSP); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Giá Bán Hiện Tại (đ)</label>
                            <input type="number" name="Gia" class="form-control" value="<?php echo e($product->Gia); ?>" required>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="<?php echo e(url('/admin/products')); ?>" class="btn btn-secondary btn-sm px-3">
                                <i class="fas fa-arrow-left me-1"></i> Hủy bỏ & Quay lại
                            </a>
                            <button type="submit" class="btn btn-warning btn-sm px-4 text-dark fw-bold">
                                <i class="fas fa-sync-alt me-1"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\thanh an\shop-dong-ho\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>