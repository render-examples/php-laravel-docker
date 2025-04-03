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
        Schema::table('messages', function (Blueprint $table) {
            // chat_idとcreated_atにインデックスを追加
            $table->index('chat_id');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['chat_id']);
            $table->dropIndex(['created_at']);
        });
    }
};
