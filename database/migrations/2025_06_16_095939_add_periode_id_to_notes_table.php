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
    Schema::table('notes', function (Blueprint $table) {
        $table->unsignedBigInteger('periode_id')->after('matiere_id');
        $table->foreign('periode_id')->references('id')->on('periodes_academiques')->onDelete('cascade');
         $table->boolean('is_locked')->default(false);
    });
}

public function down(): void
{
    Schema::table('notes', function (Blueprint $table) {
        $table->dropForeign(['periode_id']);
        $table->dropColumn('periode_id');
    });
}

};
