<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // 1. Hiển thị trang chi tiết sản phẩm
    public function show($id)
    {
        // Lấy thông tin sản phẩm theo ID (MaSP)
        $product = DB::table('sanpham')->where('MaSP', $id)->first();

        // Nếu không tìm thấy sản phẩm, trả về trang 404
        if (!$product) {
            abort(404, 'Sản phẩm không tồn tại!');
        }

        // Lấy danh sách sản phẩm tương tự (Cùng thương hiệu hoặc ngẫu nhiên)
        $relatedProducts = DB::table('sanpham')
            ->where('ThuongHieu', $product->ThuongHieu)
            ->where('MaSP', '!=', $id)
            ->take(8)
            ->get();

        // Lấy danh sách đánh giá của sản phẩm kèm thông tin khách hàng
        $reviews = DB::table('danhgia')
            ->join('khachhang', 'danhgia.MaKH', '=', 'khachhang.MaKH')
            ->where('danhgia.MaSP', $id)
            ->orderBy('danhgia.ThoiGian', 'DESC')
            ->get();

        // Lấy các danh mục để hiển thị trên Menu (Thương hiệu, Xuất xứ, Đối tượng, Bộ máy)
        $brands = DB::table('sanpham')->distinct()->pluck('ThuongHieu');
        $origins = DB::table('sanpham')->distinct()->pluck('XuatXu');
        $targets = DB::table('sanpham')->distinct()->pluck('DoiTuong');
        $engines = DB::table('sanpham')->distinct()->pluck('BoMay');

        // Trả về view detail.blade.php kèm các biến dữ liệu
        return view('detail', compact('product', 'relatedProducts', 'reviews', 'brands', 'origins', 'targets', 'engines'));
    }

    // 2. XỬ LÝ GỬI ĐÁNH GIÁ SẢN PHẨM (POST) - ĐÃ ĐƯỢC SỬA LẠI CHUẨN
    public function storeRate(Request $request, $id)
    {
        // Lấy dữ liệu từ Form đánh giá gửi lên
        $tenKH = $request->input('Name');
        $sdt = $request->input('SDT');
        $cmt = $request->input('Comment');
        $sao = $request->input('rating', 5); // Mặc định 5 sao nếu người dùng không chọn

        // Bước 1: Kiểm tra xem thông tin khách hàng (Tên + SĐT) này đã tồn tại trong DB chưa
        $khachHang = DB::table('khachhang')
            ->where('TenKH', $tenKH)
            ->where('SDT', $sdt)
            ->first();

        // Bước 2: Nếu tìm thấy khách hàng (nghĩa là đã từng mua hàng hoặc đăng ký hệ thống)
        if ($khachHang) {
            
            // Xử lý lưu tên file ảnh đánh giá (nếu có upload)
            $anh1 = $request->hasFile('AnhSP1') ? time() . '_' . $request->file('AnhSP1')->getClientOriginalName() : null;
            $anh2 = $request->hasFile('AnhSP2') ? time() . '_' . $request->file('AnhSP2')->getClientOriginalName() : null;
            $anh3 = $request->hasFile('AnhSP3') ? time() . '_' . $request->file('AnhSP3')->getClientOriginalName() : null;

            // Thực hiện di chuyển file ảnh vào thư mục public/image
            if($request->hasFile('AnhSP1')) $request->file('AnhSP1')->move(public_path('image'), $anh1);
            if($request->hasFile('AnhSP2')) $request->file('AnhSP2')->move(public_path('image'), $anh2);
            if($request->hasFile('AnhSP3')) $request->file('AnhSP3')->move(public_path('image'), $anh3);

            // Tự động tạo một chuỗi Mã đánh giá ngẫu nhiên (hoặc bạn có thể dùng ID tự tăng trong DB)
            $maDG = 'DG' . rand(100000, 999999);

            // Tiến hành chèn (Insert) dữ liệu mới vào bảng 'danhgia'
            DB::table('danhgia')->insert([
                'MaDG'     => $maDG, // Thêm Mã đánh giá để tránh lỗi thiếu khóa chính nếu DB không tự tăng
                'MaSP'     => $id,
                'MaKH'     => $khachHang->MaKH,
                'SoSao'    => $sao,
                'ThoiGian' => now(), // Lấy thời gian hiện tại lúc đánh giá
                'BinhLuan' => $cmt,
                'AnhSP1'   => $anh1,
                'AnhSP2'   => $anh2,
                'AnhSP3'   => $anh3,
            ]);

            // Trả về trang trước đó kèm thông báo thành công xanh sàn
            return redirect()->back()->with('alert_success', 'Đánh giá sản phẩm thành công!');
        } 
        
        // Bước 3: Nếu không tìm thấy khách hàng này trong hệ thống
        else {
            // Trả về và báo lỗi đỏ để yêu cầu mua hàng trước
            return redirect()->back()->with('alert_error', 'Thông tin Tên hoặc Số điện thoại không khớp! Vui lòng kiểm tra lại hoặc mua hàng trước khi đánh giá.');
        }
    }
}