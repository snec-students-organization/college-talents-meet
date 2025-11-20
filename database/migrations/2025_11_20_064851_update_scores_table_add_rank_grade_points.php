<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scores', function (Blueprint $table) {

            if (!Schema::hasColumn('scores', 'rank')) {
                $table->integer('rank')->nullable();
            }

            if (!Schema::hasColumn('scores', 'grade')) {
                $table->string('grade')->nullable();
            }

            if (!Schema::hasColumn('scores', 'points')) {
                $table->integer('points')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropColumn(['rank', 'grade', 'points']);
        });
    }
};

