<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reclamations', function (Blueprint $table) {
            $table->id();


            $table->foreignId('matiere_id')->constrained('matieres');
            $table->foreignId('periode_id')->constrained('periodes_academiques');
            $table->foreignId('annee_academique_id')->constrained('annee_academique'); 
            $table->foreignId('bulletin_id')->constrained('bulletins');
            $table->foreignId('eleve_id')->constrained('eleves');

            $table->string('type_evaluation');
            $table->string('type');
            $table->text('description');
            $table->string('statut')->default('nouvelle');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reclamations');
    }
};
