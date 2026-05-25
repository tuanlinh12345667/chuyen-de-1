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
       Schema::create('products', function (Blueprint $table) {
        $table->id();
        // Khóa ngoại: Liên kết sản phẩm với bảng categories ở trên
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        
        $table->string('name'); // Tên đồng hồ
        $table->string('slug')->unique(); // Đường dẫn sản phẩm
        $table->string('image')->nullable(); // Tên file ảnh sản phẩm
        $table->double('price'); // Giá bán
        $table->text('description')->nullable(); // Mô tả chi tiết đồng hồ
        $table->integer('stock')->default(0); // Số lượng hàng trong kho
        $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
