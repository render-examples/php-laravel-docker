<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::table('reclamations', function (Blueprint $table) {
        $table->text('reponse_admin')->nullable()->after('statut');
    });
}

public function down()
{
    Schema::table('reclamations', function (Blueprint $table) {
        $table->dropColumn('reponse_admin');
    });
}

};
