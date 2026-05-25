<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

class AuthAdminController extends Controller
{
    /**
     * 1. Hiển thị giao diện đăng nhập
     */
    public function showLogin()
    {
        if (Session::has('admin_user')) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    /**
     * 2. Xử lý logic đăng nhập (So sánh chuỗi trực tiếp thô)
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Vui lòng nhập tên tài khoản!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
        ]);

        // Kiểm tra linh hoạt hoa thường khi tìm tài khoản
        $admin = DB::table('admin')->where('username', $request->username)
                                   ->orWhere('UserName', $request->username)
                                   ->first();

        if ($admin) {
            $adminArray = (array)$admin;
            
            // Tự động nhận diện tên cột Tài khoản & Mật khẩu trong DB
            $dbUser = $adminArray['username'] ?? $adminArray['UserName'] ?? $request->username;
            $dbPassword = $adminArray['password'] ?? $adminArray['Password'] ?? null;

            if ($dbPassword && $request->password == $dbPassword) {
                // Đăng nhập thành công -> Lưu Session
                Session::put('admin_user', $dbUser);
                
                // Nhận diện cột họ tên nếu có, không có thì lấy tạm tên tài khoản
                $fullname = $adminArray['fullname'] ?? $adminArray['Fullname'] ?? $dbUser;
                Session::put('admin_name', $fullname);

                return redirect('/admin/dashboard')->with('success', 'Đăng nhập thành công!');
            }
        }

        return back()->withInput()->with('error', 'Tài khoản hoặc mật khẩu không chính xác!');
    }

    /**
     * 3. Đăng xuất hệ thống
     */
    public function logout()
    {
        Session::forget('admin_user');
        Session::forget('admin_name');
        return redirect('/admin/login')->with('success', 'Đã đăng xuất thành công!');
    }

    /**
     * 4. Hiển thị giao diện trang Đăng ký Admin
     */
    public function showRegister()
    {
        return view('admin.register');
    }

    /**
     * 5. Xử lý logic đăng ký (Tự động thích ứng cấu trúc mọi Database)
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4',
            'password' => 'required|min:4',
        ], [
            'username.required' => 'Vui lòng điền tên tài khoản!',
            'username.min'      => 'Tài khoản phải từ 4 ký tự trở lên!',
            'password.required' => 'Vui lòng điền mật khẩu!',
            'password.min'      => 'Mật khẩu phải từ 4 ký tự trở lên!',
        ]);

        // Kiểm tra trùng tài khoản (không phân biệt hoa thường)
        $checkUser = DB::table('admin')
            ->where('UserName', $request->username)
            ->orWhere('username', $request->username)
            ->first();

        if ($checkUser) {
            return back()->withInput()->with('error', 'Tên tài khoản này đã tồn tại trên hệ thống!');
        }

        // Tạo mảng dữ liệu chèn vào DB dựa trên cấu trúc cột thực tế của bạn
        $insertData = [
            'UserName' => $request->username,
            'Password' => $request->password,
        ];

        // Thuật toán thông minh: Nếu DB có cột 'Fullname' hoặc 'fullname' thì mới truyền vào dữ liệu chèn
        if (Schema::hasColumn('admin', 'Fullname')) {
            $insertData['Fullname'] = $request->fullname ?? $request->username;
        } elseif (Schema::hasColumn('admin', 'fullname')) {
            $insertData['fullname'] = $request->fullname ?? $request->username;
        }

        // Thực hiện chèn dữ liệu an toàn vào Database
        DB::table('admin')->insert($insertData);

        return redirect('/admin/login')->with('success', 'Đăng ký tài khoản Admin thành công! Mời bạn đăng nhập.');
    }
}