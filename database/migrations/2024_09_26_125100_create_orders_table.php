<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('address');
        $table->string('phone');
        $table->string('payment_method'); // Có thể sử dụng enum nếu bạn muốn giới hạn giá trị
        $table->integer('total_price'); // Giữ nguyên kiểu integer
        $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending'); // Thêm trạng thái
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
