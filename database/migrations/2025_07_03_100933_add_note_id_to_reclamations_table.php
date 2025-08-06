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
    Schema::table('reclamations', function (Blueprint $table) {
        $table->unsignedBigInteger('note_id')->nullable()->after('eleve_id');
        $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('reclamations', function (Blueprint $table) {
        $table->dropForeign(['note_id']);
        $table->dropColumn('note_id');
    });
}
};
