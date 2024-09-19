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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('fixtureId');
            $table->string('date');
            $table->string('time');
            $table->string('place')->nullable();
            $table->string('city')->nullable();
            $table->string('teams_home_name');
            $table->string('teams_home_logo');
            $table->string('teams_home_goals')->nullable();
            $table->string('teams_away_name');
            $table->string('teams_away_logo');
            $table->string('teams_away_goals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
