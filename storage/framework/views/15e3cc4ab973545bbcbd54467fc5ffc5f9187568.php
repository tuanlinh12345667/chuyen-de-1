<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5 0%, #9ecefa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.95);
            max-width: 420px;
            width: 100%;
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .register-header i { font-size: 3rem; margin-bottom: 10px; }
        .btn-register {
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="register-header">
        <i class="fas fa-user-plus"></i>
        <h4 class="mb-0 fw-bold">CREATE ACCOUNT</h4>
        <small class="opacity-75">Đăng ký thành viên quản trị</small>
    </div>
    
    <div class="card-body p-4">
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(url('/admin/register')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Họ và tên hiển thị</label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="fas fa-id-card"></i></span>
                    <input type="text" name="fullname" class="form-control" placeholder="Họ và tên hoặc Biệt danh" value="<?php echo e(old('fullname')); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Tên đăng nhập mới</label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Tạo tài khoản đăng nhập" value="<?php echo e(old('username')); ?>" required>
                </div>
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger d-block mt-1 fw-bold"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Mật khẩu tài khoản</label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Tạo mật khẩu bảo mật" required>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger d-block mt-1 fw-bold"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="btn btn-register w-100 rounded-pill shadow-sm mb-3">XÁC NHẬN ĐĂNG KÝ</button>

            <div class="text-center mt-2">
                <span class="text-muted small">Đã có tài khoản hệ thống?</span>
                <a href="<?php echo e(url('/admin/login')); ?>" class="text-decoration-none small fw-bold ms-1" style="color: #4facfe;">Đăng nhập ngay</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Users\thanh an\shop-dong-ho\resources\views/admin/register.blade.php ENDPATH**/ ?>