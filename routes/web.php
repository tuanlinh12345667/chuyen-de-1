<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthAdminController;

// ==========================================
// I. GIAO DIỆN KHÁCH HÀNG (CLIENT WEBSITE)
// ==========================================
Route::get('/', [HomeController::class, 'index']);
Route::get('/products', [HomeController::class, 'index']);
Route::get('/products/{id}', [HomeController::class, 'show'])->name('products.show');
Route::get('/gioi-thieu', [HomeController::class, 'gioiThieu']);
Route::get('/tin-tuc', [HomeController::class, 'tinTuc']);
Route::get('/lien-he', [HomeController::class, 'lienHe']);
Route::get('/giohang', [HomeController::class, 'viewCart']);
Route::get('/giohang/them/{id}', [HomeController::class, 'addToCart']);
Route::post('/giohang/capnhat', [HomeController::class, 'updateCart']);
Route::get('/giohang/xoa/{id}', [HomeController::class, 'removeFromCart']);
Route::get('/thanh-toan', [HomeController::class, 'viewCheckout']);
Route::post('/thanh-toan/hoan-tat', [HomeController::class, 'processCheckout']);


// ==========================================
// II. KHU VỰC ĐĂNG NHẬP & ĐĂNG KÝ ADMIN 
// (Bắt buộc để ngoài group prefix để không bị chặn bởi Construct)
// ==========================================
Route::get('/admin/login', [AuthAdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthAdminController::class, 'login']);
Route::get('/admin/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

// 2 Route Đăng ký vừa được thêm mới hoàn chỉnh ở đây:
Route::get('/admin/register', [AuthAdminController::class, 'showRegister']);
Route::post('/admin/register', [AuthAdminController::class, 'register']);


// ==========================================
// III. GIAO DIỆN QUẢN TRỊ (CHỊU SỰ BẢO VỆ CỦA CONSTRUCT)
// ==========================================
Route::prefix('admin')->group(function () {
    
    // 1. Trang chủ Dashboard tổng quan
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // 2. Trang Thống kê báo cáo (GET để xem, POST để lọc)
    Route::get('/statistical', [AdminController::class, 'statistical']);
    Route::post('/statistical', [AdminController::class, 'statistical']);

    // 3. Quản lý Sản phẩm (CRUD) - Đã làm gọn sạch, loại bỏ phần trùng lặp
    Route::get('/products', [AdminController::class, 'productIndex']);
    Route::get('/products/create', [AdminController::class, 'productCreate']);
    Route::post('/products/store', [AdminController::class, 'productStore']);
    Route::get('/products/edit/{id}', [AdminController::class, 'productEdit']);
    Route::post('/products/update/{id}', [AdminController::class, 'productUpdate']);
    Route::get('/products/delete/{id}', [AdminController::class, 'productDestroy']);

    // 4. Quản lý Đơn hàng (Orders)
    Route::get('/orders', [AdminController::class, 'orderIndex']);
    Route::get('/orders/detail/{id}', [AdminController::class, 'orderDetail']);
    Route::get('/orders/delete/{id}', [AdminController::class, 'orderDestroy']);

    // 5. Quản lý Khách hàng (Customers)
    Route::get('/customers', [AdminController::class, 'customerIndex']);
    Route::get('/customers/delete/{id}', [AdminController::class, 'customerDestroy']);

    // 6. Quản lý Liên hệ / Phản hồi (Contacts)
    Route::get('/contacts', [AdminController::class, 'contactIndex']);
    Route::get('/contacts/{id}', [AdminController::class, 'contactDetail']);
});