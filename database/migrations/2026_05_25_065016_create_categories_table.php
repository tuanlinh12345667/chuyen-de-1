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
        Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Tên danh mục/thương hiệu (Ví dụ: Casio)
        $table->string('slug')->unique(); // Đường dẫn link (Ví dụ: casio)
        $table->timestamps(); // Tạo sẵn 2 cột thời gian: ngày tạo và ngày cập nhật
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
