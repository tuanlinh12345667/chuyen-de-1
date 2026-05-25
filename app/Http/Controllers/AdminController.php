<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * VÒNG BẢO VỆ (MIDDLEWARE)
     * Bắt buộc kiểm tra đăng nhập trước khi sử dụng bất kỳ tính năng nào bên dưới
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Nếu không có phiên làm việc 'admin_user', chuyển hướng về trang đăng nhập
            if (!session()->has('admin_user')) {
                return redirect('/admin/login')->with('error', 'Vui lòng đăng nhập tài khoản hệ thống trước!');
            }
            return $next($request);
        });
    }

    // 1. TRANG CHỦ ADMIN (Giao diện các ô Box sắc màu)
    public function dashboard()
    {
        // Tính toán số liệu dựa trên bảng dathang thực tế
        $tongDonHang      = DB::table('dathang')->count();
        $donChuaHoanThanh = DB::table('dathang')->where('TrangThai', '!=', 'Hoàn thành')->count();
        $tongDoanhThu     = DB::table('dathang')->where('TrangThai', 'Hoàn thành')->sum('TongTien');
        
        // Đếm số lượng khách hàng
        $tongKhachHang    = DB::table('khachhang')->count();

        // Các thông số hiển thị bổ sung trên giao diện
        $dongHoDaBan = 113; 
        $thuongHieuUaChuong = "Movado";
        $thuongHieuDongHanh = 9;
        $khachHangQuayLai = 2;
        $doTuoiMuaNhieu   = 20;

        return view('admin.dashboard', compact(
            'tongDonHang', 'donChuaHoanThanh', 'tongDoanhThu', 
            'tongKhachHang', 'dongHoDaBan', 'thuongHieuUaChuong', 
            'thuongHieuDongHanh', 'khachHangQuayLai', 'doTuoiMuaNhieu'
        ));
    }

    // 2. TRANG THỐNG KÊ (Hỗ trợ lọc dữ liệu theo ngày tháng năm)
    public function statistical(Request $request)
    {
        // Lấy ngày bắt đầu và ngày kết thúc từ form bộ lọc (nếu có)
        $tuNgay = $request->input('tu_ngay');
        $denNgay = $request->input('den_ngay');

        // Khởi tạo các câu lệnh truy vấn cơ bản vào bảng dathang
        $queryOrders = DB::table('dathang');
        $queryRecent = DB::table('dathang')
            ->leftJoin('khachhang', 'dathang.MaKH', '=', 'khachhang.MaKH')
            ->select('dathang.*', 'khachhang.TenKH')
            ->orderBy('dathang.MaPhieuDat', 'desc');

        // Nếu người dùng chọn lọc theo ngày, thêm điều kiện WHERE vào câu lệnh SQL
        if ($tuNgay && $denNgay) {
            // Chuyển định dạng ngày để so sánh chính xác với cột ThoiGianDat trong MySQL
            $queryOrders->whereBetween('ThoiGianDat', [$tuNgay . ' 00:00:00', $denNgay . ' 23:59:59']);
            $queryRecent->whereBetween('dathang.ThoiGianDat', [$tuNgay . ' 00:00:00', $denNgay . ' 23:59:59']);
        }

        // 1. Tính toán số lượng đơn hàng dựa trên kết quả lọc
        $donChoXacNhan = (clone $queryOrders)->where('TrangThai', 'Chờ xác nhận')->count();
        $donDangGiao    = (clone $queryOrders)->where('TrangThai', 'Đang giao')->count();
        $donHoanThanh   = (clone $queryOrders)->where('TrangThai', 'Hoàn thành')->count();
        $totalOrders    = (clone $queryOrders)->count();

        // 2. Tính toán tiền thu dựa trên kết quả lọc
        $tienDaThu      = (clone $queryOrders)->where('TrangThai', 'Hoàn thành')->sum('TongTien');
        $tienChuaThu    = (clone $queryOrders)->whereIn('TrangThai', ['Chờ xác nhận', 'Đang giao'])->sum('TongTien');
        $tongTienHeThong = (clone $queryOrders)->sum('TongTien');

        // 3. Lấy danh sách kết quả bảng phía dưới
        $recentOrders = $queryRecent->get();

        return view('admin.statistical', compact(
            'donChoXacNhan', 'donDangGiao', 'donHoanThanh', 'totalOrders',
            'tienDaThu', 'tienChuaThu', 'tongTienHeThong', 'recentOrders',
            'tuNgay', 'denNgay'
        ));
    }
    // =======================================================
    // 2.5 QUẢN LÝ SẢN PHẨM (Bị thiếu khiến hệ thống báo lỗi)
    // =======================================================
    
    // Danh sách sản phẩm
    public function productIndex()
    {
        // Lấy danh sách sản phẩm, sắp xếp theo mã sản phẩm mới nhất
        $products = DB::table('sanpham')->orderBy('MaSP', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    // Trang thêm sản phẩm mới
    public function productCreate()
    {
        return view('admin.products.create');
    }

    // Xử lý lưu sản phẩm vào Database
    public function productStore(Request $request)
    {
        // Bạn có thể bổ sung validate dữ liệu tùy theo nhu cầu đồ án
        DB::table('sanpham')->insert([
            'TenSP' => $request->TenSP,
            'Gia'   => $request->Gia,
            // Thêm các cột khác của bảng sanpham ở đây...
        ]);
        return redirect('/admin/products')->with('success', 'Thêm sản phẩm thành công!');
    }

    // Trang sửa sản phẩm
    public function productEdit($id)
    {
        $product = DB::table('sanpham')->where('MaSP', $id)->first();
        return view('admin.products.edit', compact('product'));
    }

    // Xử lý cập nhật sản phẩm
    public function productUpdate(Request $request, $id)
    {
        DB::table('sanpham')->where('MaSP', $id)->update([
            'TenSP' => $request->TenSP,
            'Gia'   => $request->Gia,
        ]);
        return redirect('/admin/products')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // Xóa sản phẩm
    public function productDestroy($id)
    {
        DB::table('sanpham')->where('MaSP', $id)->delete();
        return redirect('/admin/products')->with('success', 'Xóa sản phẩm thành công!');
    }

    // 3. QUẢN LÝ ĐƠN HÀNG
    public function orderIndex()
    {
        // Sắp xếp theo MaPhieuDat giảm dần (Đơn hàng mới nhất lên đầu)
        $orders = DB::table('dathang')->orderBy('MaPhieuDat', 'desc')->get();
        
        return view('admin.oder.index', compact('orders'));
    }

    // 4. QUẢN LÝ KHÁCH HÀNG
    public function customerIndex()
    {
        $customers = DB::table('khachhang')->orderBy('MaKH', 'desc')->get();
        return view('admin.customers', compact('customers'));
    }

    public function customerDestroy($id)
    {
        DB::table('khachhang')->where('MaKH', $id)->delete();
        return redirect('/admin/customers')->with('success', 'Xóa tài khoản khách hàng thành công!');
    }

    // 5. QUẢN LÝ LIÊN HỆ / PHẢN HỒI
    public function contactIndex()
    {
        // Sử dụng khóa chính MaLH tương thích chính xác với Database
        $contacts = DB::table('lienhe')->orderBy('MaLH', 'desc')->get();
        
        return view('admin.contacts', compact('contacts'));
    }

    // 5.2 LẤY CHI TIẾT PHẢN HỒI (Dùng cho AJAX Modal)
    public function contactDetail($id)
    {
        // Tìm phản hồi theo MaLH trong database
        $contact = DB::table('lienhe')->where('MaLH', $id)->first();

        if ($contact) {
            return response()->json([
                'status' => 200,
                'data'   => $contact
            ]);
        }

        return response()->json([
            'status'  => 404,
            'message' => 'Không tìm thấy dữ liệu phản hồi này!'
        ]);
    }
}