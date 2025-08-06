<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classe_matiere_professeur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained();
            $table->foreignId('matiere_id')->constrained();
            $table->foreignId('professeur_id')->nullable()->constrained('professeurs')->onDelete('cascade');
            $table->integer('coefficient')->default(1);
            $table->timestamps();

            $table->unique(['classe_id', 'matiere_id', 'professeur_id'], 'cmp_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classe_matiere_professeur');
    }
};
