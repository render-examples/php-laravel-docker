<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bulletins', function (Blueprint $table) {
            $table->dropColumn('coefficient_total');
        });
    }

    public function down(): void
    {

    }
};
