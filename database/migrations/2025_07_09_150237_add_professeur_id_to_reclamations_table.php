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
        Schema::table('reclamations', function (Blueprint $table) {
            if (! Schema::hasColumn('reclamations', 'professeur_id')) {
                $table->unsignedBigInteger('professeur_id')->nullable()->after('eleve_id');
                $table->foreign('professeur_id')->references('id')->on('professeurs')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reclamations', function (Blueprint $table) {
            $table->dropForeign(['professeur_id']);
            $table->dropColumn('professeur_id');
        });
    }
};
