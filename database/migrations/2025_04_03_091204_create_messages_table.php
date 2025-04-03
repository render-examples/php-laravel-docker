<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string("chat_id");
            $table->text('text');
            $table->timestamps();
        });

        // パーティションの作成（MySQLの場合）
//        DB::statement('
//            ALTER TABLE messages
//            PARTITION BY HASH (chat_id)
//            PARTITIONS 10;  // ここで分割数を指定
//        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
