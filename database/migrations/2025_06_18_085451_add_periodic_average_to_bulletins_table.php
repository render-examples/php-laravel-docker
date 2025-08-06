<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bulletins', function (Blueprint $table) {
            $table->decimal('moyenne_periodique', 5, 2)->nullable()->after('rang');
            $table->integer('coefficient_total')->default(0)->after('moyenne_periodique');
        });
    }

    public function down()
    {
        Schema::table('bulletins', function (Blueprint $table) {
            $table->dropColumn(['moyenne_periodique', 'coefficient_total']);
        });
    }
};
