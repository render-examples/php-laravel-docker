<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBulletinsTable extends Migration
{
    public function up()
    {
        Schema::table('bulletins', function (Blueprint $table) {

            $table->dropColumn('periode');

            $table->decimal('moyenne_coefficient', 5, 2)->after('moyenne')->default(0);
            $table->decimal('moyenne_generale', 5, 2)->after('moyenne_coefficient')->nullable();

            $table->unsignedBigInteger('periode_id')->after('moyenne_generale');
            $table->foreign('periode_id')->references('id')->on('periodes_academiques')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('bulletins', function (Blueprint $table) {

            $table->dropForeign(['periode_id']);
            $table->dropColumn('periode_id');
            $table->dropColumn('moyenne_coefficient');
            $table->dropColumn('moyenne_generale');

        });
    }
}
