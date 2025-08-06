<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBulletinIdToNotesTable extends Migration
{
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->unsignedBigInteger('bulletin_id')->nullable()->after('id');

            $table->foreign('bulletin_id')->references('id')->on('bulletins')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['bulletin_id']);
            $table->dropColumn('bulletin_id');
        });
    }
}
