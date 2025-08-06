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
        Schema::table('bulletins', function (Blueprint $table) {
            $table->unsignedBigInteger('matiere_id')->nullable()->after('periode_id');
        });
    }

    public function down()
    {
        Schema::table('bulletins', function (Blueprint $table) {
            $table->dropForeign(['matiere_id']);
            $table->dropColumn('matiere_id');
        });
    }
};
