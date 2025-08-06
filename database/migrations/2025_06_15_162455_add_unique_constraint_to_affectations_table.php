<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToAffectationsTable extends Migration
{
    public function up()
    {
        Schema::table('affectations', function (Blueprint $table) {
            $table->unique(['professeur_id', 'classe_id', 'matiere_id', 'annee_academique_id'], 'unique_affectation');
        });
    }

    public function down()
    {
        Schema::table('affectations', function (Blueprint $table) {
            $table->dropUnique('unique_affectation');
        });
    }
}
