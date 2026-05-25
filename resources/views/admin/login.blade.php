<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống Admin</title>
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
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.95);
            overflow: hidden;
            max-width: 420px;
            width: 100%;
        }
        .login-header {
            background: #4facfe;
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .login-header i {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        .btn-login {
            background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="login-card p-0">
    <div class="login-header">
        <i class="fas fa-user-shield"></i>
        <h4 class="mb-0 fw-bold">WELCOME ADMIN</h4>
        <small class="opacity-75">Hệ thống quản trị cửa hàng đồng hồ</small>
    </div>
    
    <div class="card-body p-4">
        {{-- Thông báo lỗi đăng nhập --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Thông báo khi vừa đăng ký tài khoản thành công --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ url('/admin/login') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary">Tên đăng nhập</label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Nhập tài khoản quản trị" value="{{ old('username') }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Mật khẩu bảo mật</label>
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 rounded-pill shadow-sm mb-3">
                <i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP HỆ THỐNG
            </button>

            <div class="text-center mt-2">
                <span class="text-muted small">Chưa có tài khoản quản trị?</span>
                <a href="{{ url('/admin/register') }}" class="text-decoration-none small fw-bold ms-1" style="color: #4facfe;">Đăng ký tại đây</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>