<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reclamations', function (Blueprint $table) {

            DB::statement('DELETE FROM reclamations WHERE note_id IS NULL');

          
            $table->foreignId('note_id')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('reclamations', function (Blueprint $table) {
            $table->foreignId('note_id')->nullable()->change();
        });
    }
};
