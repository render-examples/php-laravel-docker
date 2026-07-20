<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();

            // 外鍵連到 products 表
            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');

            // 外鍵連到 orders 表，可為 null
            $table->foreignId('order_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // 外鍵連到 users 表，可為 null
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // 庫存變動類型，用整數表示
            $table->tinyInteger('type')->comment('紀錄狀態: 1=in, 2=out, 3=reserved, 4=return');

            $table->integer('balance')->comment('這次變動後的產品剩餘數量');

            $table->integer('quantity'); // 變動數量
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
