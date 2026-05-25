<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Thư viện kết nối cơ sở dữ liệu Query Builder

class HomeController extends Controller
{
    /**
     * 1. Hiển thị trang chủ VÀ xử lý chuyển trang danh sách khi click bộ lọc Menu Dropdown
     */
    public function index(Request $request)
    {
        $query = DB::table('sanpham');

        // Biến đánh dấu xem người dùng có đang thực hiện lọc dữ liệu hay không
        $isFiltering = false;

        if ($request->has('TH') && $request->input('TH') != '') {
            $query->where('ThuongHieu', $request->input('TH'));
            $isFiltering = true;
        }

        if ($request->has('XX') && $request->input('XX') != '') {
            $query->where('XuatXu', $request->input('XX'));
            $isFiltering = true;
        }

        if ($request->has('DT') && $request->input('DT') != '') {
            $query->where('DoiTuong', $request->input('DT'));
            $isFiltering = true;
        }

        $products = $query->get(); 

        // Lấy dữ liệu danh mục để nuôi thanh Menu Dropdown ở tất cả các trang, tránh lỗi trống menu
        $brands = DB::table('sanpham')->distinct()->whereNotNull('ThuongHieu')->pluck('ThuongHieu');
        $origins = DB::table('sanpham')->distinct()->whereNotNull('XuatXu')->pluck('XuatXu');
        $targets = DB::table('sanpham')->distinct()->whereNotNull('DoiTuong')->pluck('DoiTuong');

        // NẾU ĐANG LỌC: Trả sang trang giao diện mới "products.blade.php" chỉ có mỗi sản phẩm
        if ($isFiltering || $request->is('products')) {
            return view('products', compact('products', 'brands', 'origins', 'targets'));
        }

        // MẶC ĐỊNH: Trả về trang chủ gốc đầy đủ slide quảng cáo và đối tác
        return view('home', compact('products', 'brands', 'origins', 'targets'));
    }

    /**
     * 2. Hiển thị trang chi tiết sản phẩm dựa theo MaSP
     */
    public function show($id)
    {
        $product = DB::table('sanpham')->where('MaSP', $id)->first();

        if (!$product) {
            abort(404, "Sản phẩm không tồn tại!");
        }

        $brands = DB::table('sanpham')->distinct()->whereNotNull('ThuongHieu')->pluck('ThuongHieu');
        $origins = DB::table('sanpham')->distinct()->whereNotNull('XuatXu')->pluck('XuatXu');
        $targets = DB::table('sanpham')->distinct()->whereNotNull('DoiTuong')->pluck('DoiTuong');

        return view('detail', compact('product', 'brands', 'origins', 'targets'));
    }

    /**
     * 3. Trang Giới thiệu
     */
    public function gioiThieu()
    {
        $brands = DB::table('sanpham')->distinct()->whereNotNull('ThuongHieu')->pluck('ThuongHieu');
        $origins = DB::table('sanpham')->distinct()->whereNotNull('XuatXu')->pluck('XuatXu');
        $targets = DB::table('sanpham')->distinct()->whereNotNull('DoiTuong')->pluck('DoiTuong');

        return view('gioithieu', compact('brands', 'origins', 'targets'));
    }

    /**
     * 4. Trang Tin tức
     */
    public function tinTuc()
    {
        $brands = DB::table('sanpham')->distinct()->whereNotNull('ThuongHieu')->pluck('ThuongHieu');
        $origins = DB::table('sanpham')->distinct()->whereNotNull('XuatXu')->pluck('XuatXu');
        $targets = DB::table('sanpham')->distinct()->whereNotNull('DoiTuong')->pluck('DoiTuong');

        return view('tintuc', compact('brands', 'origins', 'targets'));
    }

    /**
     * 5. Trang Liên hệ
     */
    public function lienHe()
    {
        $brands = DB::table('sanpham')->distinct()->whereNotNull('ThuongHieu')->pluck('ThuongHieu');
        $origins = DB::table('sanpham')->distinct()->whereNotNull('XuatXu')->pluck('XuatXu');
        $targets = DB::table('sanpham')->distinct()->whereNotNull('DoiTuong')->pluck('DoiTuong');

        return view('lienhe', compact('brands', 'origins', 'targets'));
    }

    /**
     * 6. Hiển thị trang giỏ hàng
     */
    public function viewCart()
    {
        $brands = DB::table('sanpham')->distinct()->whereNotNull('ThuongHieu')->pluck('ThuongHieu');
        $origins = DB::table('sanpham')->distinct()->whereNotNull('XuatXu')->pluck('XuatXu');
        $targets = DB::table('sanpham')->distinct()->whereNotNull('DoiTuong')->pluck('DoiTuong');

        // Lấy giỏ hàng từ session, nếu chưa có thì gán mảng rỗng []
        $cart = session()->get('cart', []);

        return view('giohang', compact('cart', 'brands', 'origins', 'targets'));
    }

    /**
     * 7. Thêm một sản phẩm vào giỏ hàng
     */
    public function addToCart($id)
    {
        $product = DB::table('sanpham')->where('MaSP', $id)->first();

        if (!$product) {
            abort(404, "Sản phẩm không tồn tại!");
        }

        $cart = session()->get('cart', []);

        // Nếu sản phẩm đã có trong giỏ, tăng số lượng lên 1
        if (isset($cart[$id])) {
            $cart[$id]['soluong']++;
        } else {
            // Nếu chưa có, thêm mới sản phẩm vào cấu trúc mảng giỏ hàng
            $cart[$id] = [
                "id" => $product->MaSP,
                "ten" => $product->TenSP,
                "gia" => $product->Gia,
                "anh" => $product->AnhSP,
                "soluong" => 1
            ];
        }

        session()->put('cart', $cart);

        // Quay lại trang trước đó và gửi kèm thông báo thành công
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');
    }

    /**
     * 8. Cập nhật số lượng sản phẩm trực tiếp từ ô Input trong Giỏ hàng
     */
    public function updateCart(Request $request)
    {
        if ($request->id && $request->soluong) {
            $cart = session()->get('cart', []);
            
            if (isset($cart[$request->id])) {
                $cart[$request->id]['soluong'] = $request->soluong;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Số lượng sản phẩm đã được cập nhật!');
            }
        }
    }

    /**
     * 9. Xóa một sản phẩm ra khỏi giỏ hàng
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Loại bỏ phần tử khỏi mảng session
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    /**
     * 10. Giao diện trang điền thông tin thanh toán
     */
    public function viewCheckout()
    {
        $brands = DB::table('sanpham')->distinct()->whereNotNull('ThuongHieu')->pluck('ThuongHieu');
        $origins = DB::table('sanpham')->distinct()->whereNotNull('XuatXu')->pluck('XuatXu');
        $targets = DB::table('sanpham')->distinct()->whereNotNull('DoiTuong')->pluck('DoiTuong');

        $cart = session()->get('cart', []);

        // Nếu giỏ hàng trống thì không cho vào trang thanh toán, bắt quay về giỏ hàng
        if (count($cart) == 0) {
            return redirect('/giohang')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        return view('thanhtoan', compact('cart', 'brands', 'origins', 'targets'));
    }

    /**
     * 11. Xử lý đặt hàng thành công và xóa sạch giỏ hàng
     */
    public function processCheckout(Request $request)
    {
        // Kiểm tra bắt buộc nhập dữ liệu khách hàng
        $request->validate([
            'ten_khach_hang' => 'required',
            'so_dien_thoai' => 'required',
            'dia_chi' => 'required',
        ], [
            'ten_khach_hang.required' => 'Vui lòng nhập họ và tên!',
            'so_dien_thoai.required' => 'Vui lòng nhập số điện thoại!',
            'dia_chi.required' => 'Vui lòng nhập địa chỉ nhận hàng!',
        ]);

        // Xóa sạch giỏ hàng trong Session sau khi đặt thành công
        session()->forget('cart');

        // Chuyển hướng về trang chủ kèm thông báo thành công rực rỡ
        return redirect('/')->with('order_success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ bạn sớm nhất để xác nhận đơn hàng.');
    }
}