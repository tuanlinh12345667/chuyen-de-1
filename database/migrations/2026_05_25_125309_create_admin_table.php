<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id(); // Khóa chính tự động tăng
            
            // Thêm 3 dòng này vào file của bạn:
            $table->string('username')->unique(); // Tên tài khoản (viết thường, duy nhất)
            $table->string('password');           // Mật khẩu tài khoản (viết thường)
            $table->string('fullname')->nullable(); // Họ tên hiển thị (cho phép rỗng)
            
            $table->timestamps(); // Tự động sinh ra 2 cột gán mốc thời gian: created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
};